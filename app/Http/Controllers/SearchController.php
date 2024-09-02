<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\View\Components\PostList;
use App\View\Components\UserList;

class SearchController extends Controller
{
    public function index(Request $request) {
        $query = $request->input('query');

        $posts = Post::where('content', 'LIKE', "%{$query}%")->take(3)->get();
        $users = $query ? User::where('name', 'LIKE', "%{$query}%")
                            ->orWhere('email', 'LIKE', "%{$query}%")
                            ->get() : collect();

        if ($request->ajax()) {
            return response()->json([
                'posts' => view('components.post-list', ['posts' => $posts])->render(),
                'users' => view('components.user-list', ['users' => $users])->render(),
            ]);
        }

        return view('pages.search', compact('query', 'posts', 'users'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $posts = Post::where('content', 'LIKE', "%{$query}%")->take(3)->get();
        $users = $query ? User::where('name', 'like', '%' . $query . '%')
                             ->orWhere('email', 'like', '%' . $query . '%')
                             ->get() : collect();

        return response()->json([
            'posts' => view('components.post-list', ['posts' => $posts])->render(),
            'users' => view('components.user-list', ['users' => $users])->render(),
        ]);
    }
}
