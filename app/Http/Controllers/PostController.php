<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Post;
use App\Models\PostType;
use App\Models\PostMedia;
use App\Models\Like;
use App\Models\User;
use App\Models\Mention;
use App\Notifications\MentionNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\FollowRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post)
    {
        return view('pages.specific-post', compact('post'));
    }

    public function index()
    {
        $user = auth()->user();
        $blockedUsers = $user->blockedUsers->pluck('blocked_user_id');

        $posts = Post::whereNotIn('user_id', $blockedUserIds)->get();
        return view('pages.index', compact('posts'));
    }

    public function newpost(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg|max:10240',
        ]);
        if (empty($request->content) && !$request->hasFile('image') && !$request->hasFile('video')) {
            return redirect()->back()->withErrors(['error' => 'En az bir içerik (metin, resim veya video) eklemelisiniz.']);
        }
        $postTypeId = PostType::where('type_name', 'text')->first()->id;
        $mediaType = null;
        $mediaPath = null;

        if ($request->hasFile('image')) {
            $mediaPath = $request->file('image')->store('media', 'public');
            $postTypeId = PostType::where('type_name', 'image')->first()->id;
            $mediaType = 'image';
        } elseif ($request->hasFile('video')) {
            try {
                $mediaPath = $request->file('video')->store('media', 'public');
                $postTypeId = PostType::where('type_name', 'video')->first()->id;
                $mediaType = 'video';
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Video yükleme başarısız: ' . $e->getMessage()]);
            }

        }

        $post = Post::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'post_type_id' => $postTypeId,
        ]);

        if ($mediaPath) {
            PostMedia::create([
                'post_id' => $post->id,
                'media_type' => $mediaType,
                'media_path' => $mediaPath,
            ]);
        }

        // Etiketlenen kullanıcıları bulma
        preg_match_all('/@([a-zA-Z0-9_]+)/', $request->content, $matches);
        $mentionedUsers = User::whereIn('name', $matches[1])->get();

        // Mention kaydı
        foreach ($mentionedUsers as $mentionedUser) {
            Mention::create([
                'user_id' => Auth::id(),
                'mentioned_user_id' => $mentionedUser->id,
                'post_id' => $post->id,
                'comment_id' => null, // Yorum olmadığı için null
            ]);

            // Bildirim gönderme
            $mentionedUser->notify(new MentionNotification($post));
        }

        return redirect()->route('index')->with('success', 'Post başarıyla eklendi!');

    }

    public function like($id, Request $request)
    {
        $post = Post::findOrFail($id);
        $user = $request->user();

        if ($post->user_id == $user->id) {
            return redirect()->back()->withErrors(['error' => 'Kendi postunuzu beğenemezsiniz.'], 500);
        }

        if ($user->likes()->where('post_id', $id)->exists()) {
            $user->likes()->where('post_id', $id)->delete();
            $post->like_count -= 1;
        } else {
            $user->likes()->create(['post_id' => $id]);
            $post->like_count += 1;
        }

        $post->save();
        return response('Beğeni işlemi başarılı.', 200);
    }

    public function update(Request $request, Post $post)
    {
        if ($request->user()->id !== $post->user_id) {
            return redirect()->back()->with('error', 'Bu postu düzenleme yetkiniz yok.');
        }
        try {
            $request->validate([
                'content' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'video' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg|max:10240',
            ]);

            $post->content = $request->input('content');

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('media', 'public');
                $post->postMedia()->where('media_type', 'image')->each(function ($media) {
                    Storage::disk('public')->delete($media->media_path);
                    $media->delete();
                });
                $post->postMedia()->create([
                    'media_path' => $imagePath,
                    'media_type' => 'image'
                ]);
            }

            if ($request->hasFile('video')) {
                $videoPath = $request->file('video')->store('media', 'public');
                $post->postMedia()->where('media_type', 'video')->each(function ($media) {
                    Storage::disk('public')->delete($media->media_path);
                    $media->delete();
                });
                $post->postMedia()->create([
                    'media_path' => $videoPath,
                    'media_type' => 'video'
                ]);
            }

            $post->save();

            return redirect()->route('index')->with('success', 'Post başarıyla güncellendi!');
        } catch (\Exception $e) {
            \Log::error('Update post error: ' . $e->getMessage());
            return response('Bir hata oluştu, post güncellenemedi.', 500);
        }
    }

    public function destroy(Post $post)
    {
        if (auth()->user()->id !== $post->user_id) {
            return redirect()->back()->with('error', 'Bu postu silme yetkiniz yok.');
        }

            $post->postMedia()->each(function($media) {
                Storage::disk('public')->delete($media->media_path);
                $media->delete();
            });

            $post->delete();

            return response('Post başarıyla silindi!', 200);

    }

    public function commentPost(Request $request, $post)
    {
        $post = Post::findOrFail($post);
        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->input('comment')
        ]);

        return redirect()->back()->with('message', 'Yorum başarıyla eklendi.');
    }
}
