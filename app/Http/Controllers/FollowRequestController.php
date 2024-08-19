<?php

namespace App\Http\Controllers;
use App\Models\FollowRequest;

use Illuminate\Http\Request;

class FollowRequestController extends Controller
{
    public function accept($id)
    {
        $followRequest = FollowRequest::findOrFail($id);

        if ($followRequest->followed_id !== auth()->id()) {
            return redirect()->back()->withErrors('Bu talebi onaylama izniniz yok.');
        }

        $followRequest->status = 'accepted';
        $followRequest->save();

        return redirect()->route('follow_requests')->with('status', 'Takip talebi onaylandı!');
    }

    public function reject($id)
    {
        $followRequest = FollowRequest::findOrFail($id);

        if ($followRequest->followed_id !== auth()->id()) {
            return redirect()->back()->withErrors('Bu talebi reddetme izniniz yok.');
        }

        $followRequest->status = 'rejected';
        $followRequest->save();

        return redirect()->route('follow_requests')->with('status', 'Takip talebi reddedildi!');
    }

}
