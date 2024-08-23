<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Comment;
use App\Policies\CommentPolicy;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Kimi takip etmeli
        View::composer('*', function ($view) {
            $currentUserId = auth()->id();
            $suggestedUsers = [];

            if ($currentUserId) {
                $suggestedUsers = User::where('id', '!=', $currentUserId)
                    ->whereDoesntHave('followers', function ($query) use ($currentUserId) {
                        $query->where('follower_id', $currentUserId);
                    })
                    ->inRandomOrder()
                    ->take(5)
                    ->get();
            }
            $view->with('suggestedUsers', $suggestedUsers);

            //leftSidebar profile_image
            View::share('profileImage', Auth::check() && Auth::user()->profile_image
            ? asset('storage/' . Auth::user()->profile_image)
            : asset('images/profile.png'));
        });
    }

    protected $policies = [
        Comment::class => CommentPolicy::class,
    ];
}
