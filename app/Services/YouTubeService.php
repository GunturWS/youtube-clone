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
                    'part' => 'snippet,statistics,contentDetails',
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
                    'part' => 'snippet,statistics',
                    'chart' => 'mostPopular',
                    'regionCode' => 'ID',
                    'maxResults' => 24,
                ]);
            }
        );
    }

    /**
     * GET VIDEOS FROM A SPECIFIC CHANNEL
     * → CACHE 15 MENIT
     */
    public function getChannelVideos($channelId, $maxResults = 12)
    {
        $cacheKey = 'yt_channel_' . md5($channelId . '_' . $maxResults);

        return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($channelId, $maxResults) {
            try {
                $result = $this->request('/search', [
                    'part' => 'snippet',
                    'channelId' => $channelId,
                    'maxResults' => $maxResults,
                    'order' => 'date',
                    'type' => 'video',
                ]);

                return $result;

            } catch (\Exception $e) {
                Log::error('YouTube API Error (getChannelVideos): ' . $e->getMessage());
                return ['error' => 'Failed to fetch channel videos', 'items' => []];
            }
        });
    }

    /**
     * GET SUBSCRIPTION VIDEOS (MULTIPLE CHANNELS)
     * → CACHE 10 MENIT
     */
    public function getSubscriptionVideos($channelIds, $maxResults = 12)
    {
        if (empty($channelIds)) {
            return ['items' => []];
        }

        $cacheKey = 'yt_subscription_' . md5(implode(',', $channelIds) . '_' . $maxResults);

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($channelIds, $maxResults) {
            try {
                // Untuk multiple channels, ambil dari beberapa channel pertama
                $videos = [];
                $channelsToFetch = array_slice($channelIds, 0, 3); // Ambil max 3 channel

                foreach ($channelsToFetch as $channelId) {
                    $channelVideos = $this->getChannelVideos($channelId, ceil($maxResults / count($channelsToFetch)));
                    
                    if (isset($channelVideos['items'])) {
                        $videos = array_merge($videos, $channelVideos['items']);
                    }
                    
                    // Jika sudah cukup video, berhenti
                    if (count($videos) >= $maxResults) {
                        break;
                    }
                }

                // Potong hasil jika lebih dari maxResults
                if (count($videos) > $maxResults) {
                    $videos = array_slice($videos, 0, $maxResults);
                }

                return ['items' => $videos];

            } catch (\Exception $e) {
                Log::error('YouTube API Error (getSubscriptionVideos): ' . $e->getMessage());
                return ['items' => []];
            }
        });
    }

    /**
     * GET CHANNEL DETAILS
     * → CACHE 1 JAM
     */
    public function getChannelById($channelId)
    {
        $cacheKey = 'yt_channel_details_' . $channelId;

        return Cache::remember($cacheKey, now()->addHour(), function () use ($channelId) {
            try {
                $result = $this->request('/channels', [
                    'part' => 'snippet,statistics',
                    'id' => $channelId,
                ]);

                return $result['items'][0] ?? null;

            } catch (\Exception $e) {
                Log::error('YouTube API Error (getChannelById): ' . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * GET VIDEO STATISTICS
     * → CACHE 30 MENIT
     */
    public function getVideoStatistics($videoId)
    {
        $cacheKey = 'yt_stats_' . $videoId;

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($videoId) {
            try {
                $result = $this->request('/videos', [
                    'part' => 'statistics',
                    'id' => $videoId,
                ]);

                return $result['items'][0]['statistics'] ?? [];

            } catch (\Exception $e) {
                Log::error('YouTube API Error (getVideoStatistics): ' . $e->getMessage());
                return [];
            }
        });
    }
}