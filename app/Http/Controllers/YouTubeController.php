<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\YouTubeService;

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



}

