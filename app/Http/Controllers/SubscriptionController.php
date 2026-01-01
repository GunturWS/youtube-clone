<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    // Toggle subscription
    public function toggle(Request $request)
    {
        $request->validate([
            'channel_id' => 'required|string',
            'channel_name' => 'required|string',
            'channel_thumbnail' => 'nullable|string'
        ]);

        $user = Auth::user();
        
        // Cek apakah sudah subscribe
        $subscription = $user->subscriptions()
            ->where('channel_id', $request->channel_id)
            ->first();

        if ($subscription) {
            // Unsubscribe
            $subscription->delete();
            $subscribed = false;
            $message = 'Unsubscribed successfully';
        } else {
            // Subscribe
            $user->subscribeToChannel(
                $request->channel_id,
                $request->channel_name,
                $request->channel_thumbnail
            );
            $subscribed = true;
            $message = 'Subscribed successfully';
        }

        // Hitung total subscribers (dari database lokal)
        $totalSubscribers = Subscription::where('channel_id', $request->channel_id)->count();

        return response()->json([
            'success' => true,
            'subscribed' => $subscribed,
            'total_subscribers' => $totalSubscribers,
            'message' => $message
        ]);
    }

    // Check subscription status
    public function check($channelId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'subscribed' => false,
                'total_subscribers' => 0
            ]);
        }

        $subscribed = $user->isSubscribedTo($channelId);
        $totalSubscribers = Subscription::where('channel_id', $channelId)->count();

        return response()->json([
            'subscribed' => $subscribed,
            'total_subscribers' => $totalSubscribers
        ]);
    }

    // Get user's subscriptions
    public function index()
    {
        $subscriptions = Auth::user()
            ->subscriptions()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($subscriptions);
    }
}