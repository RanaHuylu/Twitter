<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\PostMedia;
use App\Models\PostType;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $blockedUsers = auth()->user()->blockedUsers->pluck('id')->toArray();
        $user = auth()->user();
        $posts = Post::with('user', 'postMedia', 'postType')
                    ->whereNotIn('user_id', $blockedUsers)
                    ->orderBy('created_at', 'desc')
                    ->get();
        return view('pages.index', compact('posts' , 'user'));
    }
}
