<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\FollowRequest;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('pages.profile-edit' , compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
            'is_private' => 'nullable|boolean',
        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');

            if (!Storage::exists('public/profile_images')) {
                Storage::makeDirectory('public/profile_images');
            }

            $path = $profileImage->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        if ($request->hasFile('background_image')) {
            $backgroundImage = $request->file('background_image');

            if (!Storage::exists('public/profile_images')) {
                Storage::makeDirectory('public/profile_images');
            }

            $path = $backgroundImage->store('profile_images', 'public');
            $user->background_image = $path;
        }

        if ($request->filled('description')) {
            $user->description = $request->input('description');
        }

        $user->is_private = $request->input('is_private') == '1' ? 1 : 0;
        $user->save();

        return redirect()->route('profile.index', $user->id)->with('success', 'Profil başarıyla güncellendi.');
    }

    public function follow(User $user)
    {
        $currentUser = auth()->user();

        if ($currentUser->id === $user->id) {
            return redirect()->back()->with('error', 'Kendinizi takip edemezsiniz.');
        }

        if ($currentUser->following()->where('followed_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Zaten bu kullanıcıyı takip ediyorsunuz.');
        }

        if ($user->is_private) {
            FollowRequest::create([
                'follower_id' => $currentUser->id,
                'followed_id' => $user->id,
            ]);
            return redirect()->back()->with('message', 'Takip isteği gönderildi.');
        }

        $currentUser->following()->attach($user->id);

        $currentUser->increment('following_count');
        $user->increment('follower_count');

        return $this->follow($user);
    }

    public function unfollow(User $user)
    {
        $currentUser = auth()->user();

        if (!$currentUser->following()->where('followed_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Bu kullanıcıyı takip etmiyorsunuz.');
        }

        $currentUser->following()->detach($user->id);

        $currentUser->decrement('following_count');
        $user->decrement('follower_count');

        return redirect()->back()->with('message', 'Kullanıcıyı takip etmeyi bıraktınız.');
    }

    public function acceptFollowRequest(FollowRequest $followRequest)
    {
        $currentUser = auth()->user();

        if ($followRequest->followed_id !== $currentUser->id) {
            return redirect()->back()->with('error', 'Bu isteği onaylayamazsınız.');
        }

        if ($currentUser->following()->where('followed_id', $currentUser->id)->exists()) {
            return redirect()->back()->with('error', 'Bu kullanıcıyı zaten takip ediyorsunuz.');
        }

        $currentUser->followers()->syncWithoutDetaching([$followRequest->follower_id]);
        $followRequest->follower->following()->syncWithoutDetaching([$currentUser->id]);
        $followRequest->delete();

        return redirect()->back()->with('message', 'Takip isteği kabul edildi.');
    }


    public function showFollowRequests()
    {
        $user = auth()->user();
        $followRequests = $user->is_private
            ? $user->followRequestsReceived()->where('status', 'pending')->with('follower')->get()
            : $user->followRequestsReceived()->with('follower')->get();

        return view('pages.follow_requests', compact('followRequests'));
    }


    public function declineFollowRequest(FollowRequest $followRequest)
    {
        $currentUser = auth()->user();

        if ($followRequest->followed_id !== $currentUser->id) {
            return redirect()->back()->with('error', 'Bu isteği reddedemezsiniz.');
        }

        $followRequest->delete();

        return redirect()->back()->with('message', 'Takip isteği reddedildi.');
    }
}
