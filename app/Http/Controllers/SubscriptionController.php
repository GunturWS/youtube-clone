<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'channel_id' => 'required|string'
        ]);

        $user = Auth::user();
        $channelId = $request->channel_id;

        $subscription = Subscription::where('subscriber_id', $user->id)
                                    ->where('channel_id', $channelId)
                                    ->first();

        if ($subscription) {
            $subscription->delete();
            $subscribed = false;
        } else {
            Subscription::create([
                'subscriber_id' => $user->id,
                'channel_id' => $channelId
            ]);
            $subscribed = true;
        }

        $totalSubscribers = Subscription::where('channel_id', $channelId)->count();

        return response()->json([
            'subscribed' => $subscribed,
            'total_subscribers' => $totalSubscribers
        ]);
    }
}