<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class KAAService
{
    protected string $baseUrl = 'https://kaa.lt';

 
private function safeGet(
    
    string $url,
    array $headers = []
): array {

dd('SAFEGET ENTERED');

    try {

        $response = Http::withHeaders(
            array_merge([
                'User-Agent' => 'Mozilla/5.0',
                'Accept' => 'application/json',
            ], $headers)
        )
        ->connectTimeout(5)
        ->timeout(10)
        ->retry(
            2,
            500
        )
        ->get($url);

        if (!$response->successful()) {

            logger()->warning(
                'KAA_HTTP_FAILED',
                [
                    'url' => $url,
                    'status' => $response->status(),
                ]
            );

            return [];
        }

        dd([
    'status' => $response->status(),
    'headers' => $response->headers(),
    'body' => $response->body(),
]);

    } catch (\Throwable $e) {

    dd([
        'exception' => get_class($e),
        'message' => $e->getMessage(),
    ]);

}

}

private function safePost(
    string $url,
    array $payload = [],
    array $headers = []
): array {

    try {

        $response = Http::withHeaders(
            array_merge([
                'User-Agent' => 'Mozilla/5.0',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ], $headers)
        )
        ->connectTimeout(5)
        ->timeout(10)
        ->retry(2, 500)
        ->asJson()
        ->post($url, $payload);

        if (!$response->successful()) {

            logger()->warning(
                'KAA_HTTP_POST_FAILED',
                [
                    'url' => $url,
                    'status' => $response->status(),
                ]
            );

            return [];
        }

        return $response->json() ?? [];

    } catch (\Throwable $e) {

        logger()->error(
            'KAA_HTTP_POST_EXCEPTION',
            [
                'url' => $url,
                'message' => $e->getMessage(),
            ]
        );

        return [];
    }
}

private function safeHtml(
    string $url,
    array $headers = []
): string {

    try {

        $response = Http::withHeaders(
            array_merge([
                'User-Agent' => 'Mozilla/5.0',
            ], $headers)
        )
        ->connectTimeout(5)
        ->timeout(10)
        ->retry(2, 500)
        ->get($url);

        if (!$response->successful()) {

            logger()->warning(
                'KAA_HTML_FAILED',
                [
                    'url' => $url,
                    'status' => $response->status(),
                ]
            );

            return '';
        }

        return $response->body();

    } catch (\Throwable $e) {

        logger()->error(
            'KAA_HTML_EXCEPTION',
            [
                'url' => $url,
                'message' => $e->getMessage(),
            ]
        );

        return '';
    }
}

public function search(string $query): array
{
return $this->safePost(
    'https://kaa.lt/api/search',
    [
        'query' => $query
    ],
    [
        'Origin' => 'https://kaa.lt',
        'Referer' => 'https://kaa.lt/',
        'X-Origin' => 'kaa.lt',
        'X-Requested-With' => 'XMLHttpRequest',
    ]
);
}

public function getAnime(string $slug): array
{
$data = $this->safeGet(
    "https://kaa.lt/api/show/$slug"
);

    return [
        'slug' => $slug,
        'title' => $data['title'] ?? $slug,

        'poster' => !empty($data['poster']['hq'])
            ? 'https://kaa.lt/image/poster/' . $data['poster']['hq'] . '.webp'
            : null,

        'description' =>
            $data['synopsis'] ?? null,

        'genres' =>
            $data['genres'] ?? [],

        'rating' =>
            $data['rating'] ?? null,

        'year' =>
            $data['year'] ?? null,

        'type' =>
            $data['type'] ?? null,
    ];
}
public function getSource(
    string $animeSlug,
    string $episodeSlug,
    bool $section = false
)
{
    $t = microtime(true);

    $episodesKey = "kaa_episodes_{$animeSlug}";

    if (Cache::has($episodesKey)) {
        logger()->info('EPISODES_CACHE_HIT');
    }

    $allEpisodes = Cache::rememberForever(
        $episodesKey,
        function () use ($animeSlug) {

            $episodes = [];
            $page = 1;

            do {

            $data = $this->safeGet(
                "https://kaa.lt/api/show/$animeSlug/episodes?ep=1&page={$page}&lang=ja-JP"
            );

                $episodes = array_merge(
                    $episodes,
                    $data['result'] ?? []
                );

                $hasNext =
                    !empty($data['pages']) &&
                    $page < max(
                        array_column(
                            $data['pages'],
                            'number'
                        )
                    );

                $page++;

            } while ($hasNext);

            return $episodes;
        }
    );

    logger()->info(
        'ALL_EPISODES_END',
        [
            'seconds' => microtime(true) - $t
        ]
    );

    $episode = collect($allEpisodes)
        ->firstWhere(
            'slug',
            $episodeSlug
        );

    if (!$episode) {
        abort(404);
    }

    $sourceKey =
        "kaa_source_{$animeSlug}_{$episodeSlug}";

    if (Cache::has($sourceKey)) {
        logger()->info('SOURCE_CACHE_HIT');
    }

$cached = Cache::remember(
        $sourceKey,
        86400,
        function () use (
            $animeSlug,
            $episodeSlug,
            $episode
        ) {

            $watchUri =
                '/' .
                $animeSlug .
                '/ep-' .
                $episode['episode_number'] .
                '-' .
                $episodeSlug;

            $t1 = microtime(true);

           $html = $this->safeHtml(
                'https://kaa.lt'.$watchUri
            );

            logger()->info(
                'WATCH_HTML',
                [
                    'seconds' =>
                        microtime(true) - $t1
                ]
            );

            preg_match(
                '/player\?id=([^&"]+)/',
                $html,
                $matches
            );

            $playerId =
                $matches[1] ?? null;

           $realManifest = null;
        $subtitles = [];
        $thumbnails = null;

            preg_match(
                '/src:"([^"]+)"/',
                $html,
                $srcMatch
            );

            $src = str_replace(
                '\u002F',
                '/',
                $srcMatch[1] ?? ''
            );

            if ($src) {

                $t2 = microtime(true);

                $response = Http::connectTimeout(3)
                    ->timeout(8)
                    ->withHeaders([
                        'Referer' => 'https://kaa.lt/',
                        'User-Agent' => 'Mozilla/5.0'
                    ])
                    ->get($src);

                logger()->info(
                    'SOURCE_SERVER',
                    [
                        'seconds' =>
                            microtime(true) - $t2
                    ]
                );

                $body = html_entity_decode(
                    $response->body(),
                    ENT_QUOTES | ENT_HTML5
                );
                
                preg_match(
    '/"subtitles":(.*?),"thumbnails"/s',
    $body,
    $subtitleMatch
);
if (!empty($subtitleMatch[1])) {

    logger()->info(
        'SUBTITLE_FOUND',
        [
            'data' => $subtitleMatch[1]
        ]
    );

    preg_match_all(
        '/"language":\[0,"([^"]+)"\].*?"name":\[0,"([^"]+)"\].*?"src":\[0,"([^"]+)"\]/s',
        $subtitleMatch[1],
        $subs,
        PREG_SET_ORDER
    );

    foreach ($subs as $sub) {
    $subSrc = str_replace(
        'https:///',
        'https://',
        $sub[3]
    );

    $subSrc = str_replace(
        'http:///',
        'http://',
        $subSrc
    );

        $subtitles[] = [
            'language' => $sub[1],
            'name'     => $sub[2],
            'src'      => url('/kaa-subtitle') . '?url=' . urlencode($subSrc),
        ];
    }
}

preg_match(
    '/"thumbnails":\[0,"([^"]+)"\]/',
    $body,
    $thumbMatch
);

if (!empty($thumbMatch[1])) {

$thumbUrl = str_replace(
    'https:///',
    'https://',
    $thumbMatch[1]
);

$thumbnails =
    url('/kaa-thumbnail')
    . '?url='
    . urlencode($thumbUrl);

    logger()->info(
        'THUMBNAIL_FOUND',
        [
            'url' => $thumbnails
        ]
    );
}
                preg_match(
                    '/"manifest":\[0,"([^"]+)"/',
                    $body,
                    $manifestMatch
                );

                $realManifest =
                    $manifestMatch[1] ?? null;

                if (
                    $realManifest &&
                    str_starts_with(
                        $realManifest,
                        '//'
                    )
                ) {
                    $realManifest =
                        'https:' . $realManifest;
                }
            }

            $manifest =
                $realManifest
                ?: (
                    $playerId
                    ? "https://hls.krussdomi.com/manifest/{$playerId}/master.m3u8"
                    : null
                );
return [
    $playerId,
    $manifest,
    $subtitles,
    $thumbnails
];
        }
    );

    $playerId = $cached[0] ?? null;
$manifest = $cached[1] ?? null;
$subtitles = $cached[2] ?? [];
$thumbnails = $cached[3] ?? null;
$animeInfo = $this->getAnime($animeSlug);

$data = [

    'anime' => $animeSlug,
    'episode' => $episodeSlug,

    'episodes' => collect($allEpisodes)
        ->map(fn ($ep) => [
            'slug' => $ep['slug'],
            'episode_number' => $ep['episode_number']
        ])
        ->values(),

    'playerId' => $playerId,
    'manifest' => $manifest,
    'subtitles' => $subtitles,
    'thumbnails' => $thumbnails,

    'title' => $animeInfo['title'] ?? $animeSlug,
    'poster' => $animeInfo['poster'] ?? null,
    'synopsis' => $animeInfo['description'] ?? null,

];

return view(
    $section
        ? 'sections.watch'
        : 'kaa.watch',
    $data
);
}
public function getEpisodes(string $slug): array
{
    return Cache::remember(
        "kaa_first_page_{$slug}",
        3600,
        function () use ($slug) {

            $data = $this->safeGet(
    "https://kaa.lt/api/show/$slug/episodes?ep=1&lang=ja-JP"
);


            return [
                'slug' => $slug,
                'episodes' => $data['result'] ?? []
            ];
        }
    );
}


public function topAiring()
{
return $this->safeGet(
    'https://kaa.lt/api/top_airing'
);
}

public function recent(int $page = 1): array
{
    return Cache::remember(
        "kaa_recent_page_{$page}",
        300,
        function () use ($page) {

            return $this->safeGet(
                "https://kaa.lt/api/show/recent?type=all&page={$page}"
            );

        }
    );
}
public function schedule(): array
{
  return $this->safeGet(
    "https://kaa.lt/api/schedule"
);
}
public function homepage()
{
return $this->safeHtml(
    'https://kaa.lt'
);
}
public function animePage($page = 1)
{
    return $this->safeGet(
        "https://kaa.lt/api/anime?page={$page}"
    );
}
public function popular(int $page = 1): array
{
    return Cache::remember(
        "kaa_popular_page_{$page}",
        3600,
        function () use ($page) {

           $data = $this->safeGet(
                "https://kaa.lt/api/show/popular?page={$page}"
            );

                return [
            'anime'=>$data['result'] ?? [],
            'maxPage'=>$data['maxPage'] ?? 1,
        ];
        }
    );
}
}

