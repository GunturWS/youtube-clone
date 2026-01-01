<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\YouTubeService;
use Illuminate\Support\Facades\Auth;

class YouTubeController extends Controller
{
    protected $youtube;

    public function __construct(YouTubeService $youtube)
    {
        $this->youtube = $youtube;
    }

    // HOME
    public function index(Request $request)
    {
        $query = $request->q ?? 'trending';

        $result = $this->youtube->search($query);

        // ⛔ QUOTA / API ERROR
        if (isset($result['error'])) {
            return view('youtube.index', [
                'results' => [],
                'query' => $query,
                'nextPageToken' => null,
                'error' => $result['message'],
                'reason' => $result['reason'],
            ]);
        }

        return view('youtube.index', [
            'results' => $result['items'] ?? [],
            'query' => $query,
            'nextPageToken' => $result['nextPageToken'] ?? null,
        ]);
    }

    // LOAD MORE (REAL-TIME)
    public function loadMore(Request $request)
    {
        if ($request->page > 5) {
            return response()->json([
                'items' => [],
                'nextPageToken' => null,
            ]);
        }

        $result = $this->youtube->search(
            $request->q,
            $request->pageToken
        );

        return response()->json([
            'items' => $result['items'] ?? [],
            'nextPageToken' => $result['nextPageToken'] ?? null,
        ]);
    }

    // WATCH
    public function show(string $videoId)
    {
        $video = $this->youtube->getVideoById($videoId);

        abort_if(!$video, 404);

        $related = $this->youtube->relatedVideos(
            $video['snippet']['channelId']
        );

        return view('youtube.watch', [
            'video' => $video,
            'related' => $related['items'] ?? []
        ]);
    }

    // 🔥 TRENDING PAGE
    public function trending()
    {
        $result = $this->youtube->trending();

        // handle quota / error
        if (isset($result['error'])) {
            return view('youtube.trending', [
                'results' => [],
                'error' => $result['message'],
                'reason' => $result['reason'],
            ]);
        }

        return view('youtube.trending', [
            'results' => $result['items'] ?? [],
        ]);
    }

    // ========== TAMBAHKAN METHOD INI ==========
    
    // 🔔 SUBSCRIPTION FEED PAGE
    public function subscriptionsFeed(Request $request)
    {
        // Jika user belum login, redirect ke login
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        // Ambil subscriptions user
        $subscriptions = $user->subscriptions()->get();
        
        // Jika ada channel_id di query, ambil videos dari channel itu
        $channelId = $request->get('channel_id');
        $videos = [];
        
        if ($channelId) {
            // Verifikasi user subscribe ke channel ini
            $isSubscribed = $user->subscriptions()
                ->where('channel_id', $channelId)
                ->exists();
                
            if (!$isSubscribed) {
                return redirect()->route('youtube.subscriptions');
            }
            
            // Ambil videos dari channel spesifik
            $channelVideos = $this->youtube->getChannelVideos($channelId);
            $videos = $channelVideos['items'] ?? [];
            
        } else {
            // Ambil videos trending sebagai fallback
            $trending = $this->youtube->trending();
            $videos = $trending['items'] ?? [];
        }
        
        return view('youtube.subs', [
            'subscriptions' => $subscriptions,
            'videos' => $videos,
            'selectedChannelId' => $channelId
        ]);
    }
    
    // 🔍 SEARCH PAGE (jika route ada tapi method belum ada)
    public function search(Request $request)
    {
        $query = $request->q ?? '';
        
        if (empty($query)) {
            return redirect()->route('youtube.index');
        }
        
        $result = $this->youtube->search($query);
        
        if (isset($result['error'])) {
            return view('youtube.search', [
                'results' => [],
                'query' => $query,
                'error' => $result['message'],
                'reason' => $result['reason'],
            ]);
        }
        
        return view('youtube.search', [
            'results' => $result['items'] ?? [],
            'query' => $query,
            'nextPageToken' => $result['nextPageToken'] ?? null,
        ]);
    }
    
    // 💾 SAVE VIDEO (untuk watch later / playlist)
    public function saveVideo(Request $request)
    {
        $request->validate([
            'video_id' => 'required|string',
            'title' => 'required|string',
            'action' => 'required|in:save,unsave'
        ]);
        
        $user = Auth::user();
        $videoId = $request->video_id;
        
        // Implementasi save/unsave logic
        // Anda bisa buat model SavedVideo atau PlaylistVideo
        
        return response()->json([
            'success' => true,
            'message' => $request->action === 'save' 
                ? 'Video saved to watch later' 
                : 'Video removed from watch later'
        ]);
    }
}