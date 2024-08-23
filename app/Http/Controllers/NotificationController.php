<?php

namespace App\Http\Controllers;
use App\Models\FollowRequest;
use App\Models\Mention;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
        public function index()
    {
        $user = auth()->user();
        $followRequests = $user->is_private
            ? $user->followRequestsReceived()->where('status', 'pending')->with('follower')->get()
            : $user->followRequestsReceived()->with('follower')->get();

            $mentions = Mention::where('mentioned_user_id', $user->id)
                ->with(['user', 'post', 'comment'])
                ->orderBy('created_at', 'desc')
                ->take(4) // Maksimum 4 bildirim
                ->get();
        return view('pages.notification', compact('followRequests' , 'mentions'));
    }

    public function showMentionedComment(Mention $mention)
    {
        $comment = $mention->comment;

        if (!$comment) {
            return redirect()->back()->with('error', 'Yorum bulunamadı.');
        }

        $post = $comment->post->load(['comments.user', 'comments.mentions.mentionedUser']);

        return view('posts.show', compact('post', 'comment'));
    }

}
