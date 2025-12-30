<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class YouTubeService
{
    protected string $baseUrl = 'https://www.googleapis.com/youtube/v3';
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.youtube.key');
    }

    /**
     * GENERIC REQUEST + CEK ERROR / QUOTA
     */
    protected function request(string $endpoint, array $params = [])
    {
        $params['key'] = $this->apiKey;

        $response = Http::get($this->baseUrl . $endpoint, $params);

        if ($response->failed()) {
            Log::error('YouTube API Error', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return [
                'error' => true,
                'message' => $response->json('error.message') ?? 'YouTube API error',
                'reason' => $response->json('error.errors.0.reason') ?? null,
            ];
        }

        return $response->json();
    }

    /**
     * SEARCH VIDEO (MAHAL: ±100 QUOTA)
     * → DI-CACHE 15 MENIT
     */
    public function search(string $query, string $pageToken = null)
    {
        $cacheKey = 'yt_search_' . md5($query . '_' . $pageToken);

        return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($query, $pageToken) {

            $params = [
                'part' => 'snippet',
                'q' => $query,
                'type' => 'video,channel',
                'regionCode' => 'ID',
                'maxResults' => 24,
            ];

            if ($pageToken) {
                $params['pageToken'] = $pageToken;
            }

            return $this->request('/search', $params);
        });
    }

    /**
     * VIDEO DETAIL (MURAH: 1 QUOTA)
     * → DI-CACHE 1 JAM
     */
    public function getVideoById(string $videoId): array
    {
        return Cache::remember(
            'yt_video_' . $videoId,
            now()->addHour(),
            function () use ($videoId) {

                $result = $this->request('/videos', [
                    'part' => 'snippet',
                    'id' => $videoId,
                ]);

                return $result['items'][0] ?? [];
            }
        );
    }

    /**
     * RELATED VIDEOS
     * → CACHE 30 MENIT
     */
    public function relatedVideos(string $channelId, string $pageToken = null)
    {
        $cacheKey = 'yt_related_' . md5($channelId . '_' . $pageToken);

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($channelId, $pageToken) {

            $params = [
                'part' => 'snippet',
                'channelId' => $channelId,
                'type' => 'video',
                'maxResults' => 10,
            ];

            if ($pageToken) {
                $params['pageToken'] = $pageToken;
            }

            return $this->request('/search', $params);
        });
    }

    /**
 * 🔥 TRENDING VIDEOS (PALING AMAN & HEMAT QUOTA)
 * videos.list → chart=mostPopular
 * COST: ±1 quota / request
 */
public function trending()
{
    return Cache::remember(
        'yt_trending_id',
        now()->addMinutes(30),
        function () {
            return $this->request('/videos', [
                'part' => 'snippet',
                'chart' => 'mostPopular',
                'regionCode' => 'ID',
                'maxResults' => 24,
            ]);
        }
    );
}



}
