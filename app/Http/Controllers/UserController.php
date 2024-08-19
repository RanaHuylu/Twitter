<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Post;
use App\Models\BlockedUser;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($id, Request $request)
    {
        $user = User::findOrFail($id);
        $currentUser = auth()->user();

        if (auth()->check()) {
            $blockedUserIds = $currentUser->blockedUsers->pluck('id')->toArray();
        } else {
            $blockedUserIds = [];
        }

        if (in_array($user->id, $blockedUserIds) || $user->blockedUsers->contains($currentUser)) {
            $posts = collect(); // Boş koleksiyon döndür
        } else {
            $posts = Post::where('user_id', $user->id)->whereNotIn('user_id', $blockedUserIds)->get();
        }

        return view('pages.profile', compact('user', 'posts'));
    }

    public function blockUser(Request $request, $user)
    {
        $userToBlock = User::findOrFail($user);
        $blockedUser = BlockedUser::firstOrCreate([
            'user_id' => auth()->id(),
            'blocked_user_id' => $userToBlock->id
        ]);

        return redirect()->back();
    }

    public function unblockUser(Request $request, $user)
    {
        $userToUnblock = User::findOrFail($user);
        auth()->user()->blockedUsers()->detach($userToUnblock);

        return redirect()->back()->with('message', 'Kullanıcı engeli kaldırıldı');
    }

}


