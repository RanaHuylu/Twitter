<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use App\Models\Mention;
use App\Notifications\MentionNotification;
use Illuminate\Support\Facades\Notification;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comment(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string',
        ]);

        $comment = Comment::create([
            'post_id' => $validated['post_id'],
            'user_id' => auth()->id(),
            'body' => $validated['body'],
        ]);

        //Etiketlenen kullanıcıyı bulma işlemi
        preg_match_all('/@([a-zA-Z0-9_]+)/', $validated['body'], $matches);
        $mentionedUsers = User::whereIn('name', $matches[1])->get();

        foreach ($mentionedUsers as $mentionedUser) {
            Mention::create([
                'user_id' => auth()->id(),
                'mentioned_user_id' => $mentionedUser->id,
                'post_id' => $comment->post_id,
                'comment_id' => $comment->id,
            ]);

            // Bildirim gönderme
            $mentionedUser->notify(new MentionNotification($comment));
        }

        return back()->with('success', 'Yorum başarıyla eklendi!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return redirect()->back();
    }



}
