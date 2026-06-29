<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GogoAnimeService
{
    protected $baseUrl = 'https://gogoanime.by';
    protected $apiBaseUrl = 'https://ajax.gogocdn.net';
    
    /**
     * Get the streaming iframe URL for a specific anime episode
     */
    public function getStreamingUrl(string $animeTitle, int $episodeNumber): array
    {
        $result = [
            'iframe_url' => null,
            'player_url' => null,
            'post_id' => null,
            'error' => null
        ];
        
        try {
$animePageUrl = $this->searchAnimePage($animeTitle);

if (!$animePageUrl) {
    $result['error'] = 'Anime search failed';
    return $result;
}
            
            // Fetch anime category page
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ])->get($animePageUrl);
            
            if (!$response->successful()) {
                $result['error'] = 'Failed to fetch anime page: ' . $response->status();
                return $result;
            }
            
            $html = $response->body();

            
            // Extract hidden parameters
            $movieId = $this->extractHiddenValue($html, 'movie_id');
            $alias = $this->extractHiddenValue($html, 'alias_anime');
            $defaultEp = $this->extractHiddenValue($html, 'default_ep');
            
            // Extract ep_start and ep_end
            preg_match('/<li class="active"[^>]*ep_start="(\d+)"[^>]*ep_end="(\d+)"/', $html, $matches);
            $epStart = $matches[1] ?? 0;
            $epEnd = $matches[2] ?? 99999;
            
            // Extract base API URL
            preg_match("/base_url_cdn_api\s*=\s*'([^']+)'/", $html, $apiMatches);
            $apiBase = $apiMatches[1] ?? $this->apiBaseUrl;
            
            // Call internal API for episode list
            $apiUrl = $apiBase . '/ajax/load-list-episode?' . http_build_query([
                'ep_start' => $epStart,
                'ep_end' => $epEnd,
                'id' => $movieId,
                'default_ep' => $defaultEp,
                'alias' => $alias
            ]);
            
            $episodeResponse = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'X-Requested-With' => 'XMLHttpRequest'
            ])->get($apiUrl);
            
            if ($episodeResponse->successful()) {
                $episodeHtml = $episodeResponse->body();
                $extracted = $this->extractPlayerUrlFromEpisodeList($episodeHtml, $episodeNumber);
                
                if ($extracted['iframe_url']) {
                    $result = array_merge($result, $extracted);
                }
            }
            
            // If not found, try direct episode page
            // if (!$result['iframe_url']) {
            //     $directExtract = $this->getPlayerFromEpisodePage($slug, $episodeNumber);
            //     $result = array_merge($result, $directExtract);
            // }
            
        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }
        
        return $result;
    }

    protected function searchAnimePage(string $title): ?string
{
    $url = $this->baseUrl . '/?s=' . urlencode($title);

    $response = Http::get($url);

    if (!$response->successful()) {
        return null;
    }

    $html = $response->body();

    preg_match(
        '/<article class="bs".*?<a href="([^"]+)"/is',
        $html,
        $match
    );

return $match[1] ?? null;
}
    
public function testSearch(string $title)
{
    $url = $this->baseUrl . '/?s=' . urlencode($title);

    $response = Http::get($url);


    return [
        'status' => $response->status(),
        'length' => strlen($response->body()),
        'saved' => true
    ];
}
    
    /**
     * Extract player URL from episode list HTML
     */
    protected function extractPlayerUrlFromEpisodeList(string $html, int $episodeNumber): array
    {
        $result = ['iframe_url' => null, 'player_url' => null, 'post_id' => null];
        
        // Look for episode link
        $pattern = '/<a[^>]*href="([^"]+)"[^>]*data-post-id="(\d+)"[^>]*>.*?Episode\s+' . $episodeNumber . '/i';
        preg_match($pattern, $html, $matches);
        
        if (isset($matches[1])) {
            $episodeUrl = $matches[1];
            $result['post_id'] = $matches[2] ?? null;
            
            if (!str_starts_with($episodeUrl, 'http')) {
                $episodeUrl = $this->baseUrl . $episodeUrl;
            }
            
            $playerData = $this->getPlayerFromEpisodePageByUrl($episodeUrl);
            $result = array_merge($result, $playerData);
        }
        
        return $result;
    }
    
    /**
     * Get player URL from episode page
     */
    protected function getPlayerFromEpisodePage(string $slug, int $episodeNumber): array
    {
        $episodeUrl = $this->baseUrl . '/' . $slug . '-episode-' . $episodeNumber;
        return $this->getPlayerFromEpisodePageByUrl($episodeUrl);
    }
    
    /**
     * Extract iframe source from episode page
     */
    protected function getPlayerFromEpisodePageByUrl(string $url): array
    {
        $result = ['iframe_url' => null, 'player_url' => null, 'post_id' => null];
        
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ])->get($url);
            
            if (!$response->successful()) {
                return $result;
            }
            
            $html = $response->body();



            
            // Extract postId from URL or page
            preg_match('/post[_-]?id[=:]["\']?(\d+)/i', $html, $postIdMatches);
            if (isset($postIdMatches[1])) {
                $result['post_id'] = $postIdMatches[1];
            }
            
            // Extract postId from iframe src as well
            preg_match('/postId=(\d+)/', $html, $iframePostId);
            if (isset($iframePostId[1]) && !$result['post_id']) {
                $result['post_id'] = $iframePostId[1];
            }
            
            // Method 1: Direct iframe
            preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/i', $html, $iframeMatches);
            if (isset($iframeMatches[1])) {
                $result['iframe_url'] = $iframeMatches[1];
                if (!str_starts_with($result['iframe_url'], 'http')) {
                    $result['iframe_url'] = 'https:' . $result['iframe_url'];
                }
            }
            
            // Method 2: Player script
            preg_match('/player_ajax\s*=\s*["\']([^"\']+)["\']/', $html, $playerMatches);
            if (isset($playerMatches[1])) {
                $result['player_url'] = $playerMatches[1];
            }
            
            // Method 3: data-video attribute
            if (!$result['iframe_url']) {
                preg_match('/data-video=["\']([^"\']+)["\']/', $html, $videoMatches);
                if (isset($videoMatches[1])) {
                    $result['iframe_url'] = $videoMatches[1];
                }
            }
            
        } catch (\Exception $e) {
            // Silently fail
        }
        
        return $result;
    }
    
    /**
     * Extract hidden input values from HTML
     */
    protected function extractHiddenValue(string $html, string $id): ?string
    {
        preg_match('/<input[^>]*id="' . $id . '"[^>]*value="([^"]+)"/', $html, $matches);
        return $matches[1] ?? null;
    }
    
    /**
     * Convert anime title to GogoAnime slug format
     */
    protected function titleToSlug(string $title): string
    {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return trim($slug, '-');
    }
}