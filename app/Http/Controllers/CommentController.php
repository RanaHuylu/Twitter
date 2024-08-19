<?php

namespace App\Http\Controllers;
use App\Models\Comment;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comment(Request $request)
{
    $request->validate([
        'post_id' => 'required|exists:posts,id',
        'body' => 'required|string',
    ]);

    Comment::create([
        'post_id' => $request->post_id,
        'user_id' => auth()->id(),
        'body' => $request->body,
    ]);

    return back()->with('success', 'Yorum başarıyla eklendi!');
}
}
