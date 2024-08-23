<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class RightSidebar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    /*public function handle(Request $request, Closure $next): Response
    {   //kimi takip etmeli
        $currentUserId = auth()->id();

        $followedUserIds = User::find($currentUserId)->following()->pluck('id')->toArray();

        $suggestedUsers = User::where('id', '!=', $currentUserId)
            ->whereNotIn('id', $followedUserIds)
            ->inRandomOrder()
            ->take(5)
            ->get();

        // Veri kontrolü için loglama
        \Log::info('Suggested Users:', $suggestedUsers->toArray());

        session(['suggestedUsers' => $suggestedUsers]);
        return $next($request);
    }*/
}
