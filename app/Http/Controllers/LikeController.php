<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'video_id' => 'required|string'
        ]);

        $user = Auth::user();
        $videoId = $request->video_id;

        $like = Like::where('user_id', $user->id)
                    ->where('video_id', $videoId)
                    ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => $user->id,
                'video_id' => $videoId
            ]);
            $liked = true;
        }

        // Hitung total likes
        $totalLikes = Like::where('video_id', $videoId)->count();

        return response()->json([
            'liked' => $liked,
            'total_likes' => $totalLikes
        ]);
    }
}