<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Models\WatchProgress;
use App\Models\Watchlist;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Log;
use App\Services\KAAService;
use App\Http\Controllers\DashboardController;






/*
|--------------------------------------------------------------------------
| Homepage
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return "Render works!";
});
Route::get('/kaa-page', function () {

    $page = request('page', 1);

    $data = Http::get(
        "https://kaa.lt/api/show/recent?type=all&page={$page}"
    )->json();

    $anime = collect($data['result'] ?? [])
        ->where('language', 'ja-JP')
        ->values()
        ->all();

    return view('kaa-page', [
        'anime'   => $anime,
        'page'    => $page,
        'hasNext' => $data['hadNext'] ?? false,
    ]);

});
/*
|--------------------------------------------------------------------------
| Search Anime
|--------------------------------------------------------------------------
*/

Route::get('/search', function (Request $request) {

    $query = $request->q;

    $results = [];

    if ($query) {

        $kaa = new KAAService();

        $results = collect(
    $kaa->search($query)
)
->filter(function ($anime) use ($kaa) {

    $episodes = $kaa->getEpisodes(
        $anime['slug']
    );

    return !empty(
        $episodes['episodes']
    );
})
->values()
->all();
        
    }

return view(
    'kaa.search',
    compact(
        'results',
        'query'
    )
);

});

/*
|--------------------------------------------------------------------------
| Anime Details
|--------------------------------------------------------------------------
*/

Route::get('/anime/{id}', function ($id) {

    $anime = Cache::remember(
        "anime_$id",
        3600,
        function () use ($id) {

            return Http::get(
                "https://api.jikan.moe/v4/anime/$id/full"
            )->json()['data'];

        }
    );

    $recommendationsResponse = Http::get(
        "https://api.jikan.moe/v4/anime/$id/recommendations"
    );

    $recommendations =
        $recommendationsResponse->json()['data'] ?? [];

    $charactersResponse = Http::get(
        "https://api.jikan.moe/v4/anime/$id/characters"
    );

    $characters =
        $charactersResponse->json()['data'] ?? [];
        $episodePage = request('episode_page', 1);

$episodesResponse = Http::get(
    "https://api.jikan.moe/v4/anime/$id/episodes",
    [
        'page' => $episodePage
    ]
);

$episodes =
    $episodesResponse->json()['data'] ?? [];

$episodePagination =
    $episodesResponse->json()['pagination'] ?? [];
        $reviews = Review::where(
    'anime_id',
    $id
)->latest()->get();

return view(
    'anime.show',
    compact(
        'anime',
        'recommendations',
        'characters',
        'reviews',
        'episodes',
        'episodePage',
        'episodePagination'
    )
);

});
Route::get('/top-rated', function () {

    // Browser Refresh (F5 / Ctrl+Shift+R)
    if (!request()->has('section')) {
        return redirect('/?section=top-rated');
    }

    $anime = Cache::remember(
        'top_rated_anime',
        3600,
        function () {
            return Http::get(
                'https://api.jikan.moe/v4/top/anime?page=1&limit=24'
            )->json()['data'];
        }
    );

    return view(
        'sections.top-rated',
        compact('anime')
    );

});

Route::get('/popular', function (KAAService $kaa) {

    // Direct browser refresh (F5 / Ctrl+Shift+R)
    if (!request()->has('section')) {
        return redirect('/?section=popular');
    }

    $page = max(
        1,
        (int) request('page', 1)
    );

    $popular = $kaa->popular($page);

    $anime = $popular['anime'];
    $maxPage = $popular['maxPage'];

    return view(
        'sections.popular',
        compact(
            'anime',
            'page',
            'maxPage'
        )
    );

});

Route::get('/current-season', function () {

    // Browser Refresh (F5 / Ctrl+Shift+R)
    if (!request()->has('section')) {
        return redirect('/?section=current-season');
    }

    $anime = Cache::remember(
        'current_season_anime',
        3600,
        function () {
            return Http::get(
                'https://api.jikan.moe/v4/seasons/now?page=1&limit=24'
            )->json()['data'];
        }
    );

    return view(
        'sections.current-season',
        compact('anime')
    );

});

Route::get('/genre/{genre}', function ($genre) {

    $genres = [
        'action' => 1,
        'comedy' => 4,
        'fantasy' => 10,
        'romance' => 22,
        'horror' => 14,
    ];

    if (!isset($genres[$genre])) {
        abort(404);
    }

    $anime = Http::get(
        'https://api.jikan.moe/v4/anime',
        [
            'genres' => $genres[$genre],
            'limit' => 24
        ]
    )->json()['data'];

    return view(
        'anime.genre',
        compact(
            'anime',
            'genre'
        )
    );

});
Route::post('/favorites', function (Request $request) {

    if (!Auth::check()) {
        return redirect('/login');
    }

    Favorite::firstOrCreate(
        [
            'user_id' => Auth::id(),
            'anime_id' => $request->anime_id,
        ],
        [
            'title' => $request->title,
            'image' => $request->image,
        ]
    );

    return back();

});

Route::get('/favorites', function () {

    $favorites = Favorite::where('user_id', Auth::id())->latest()->get();

    return view(
        'anime.favorites',
        compact('favorites')
    );

});

Route::delete('/favorites/{id}', function ($id) {

    Favorite::findOrFail($id)->delete();

    return back();

});

Route::post('/reviews', function (Request $request) {

    Review::create([

        'anime_id' => $request->anime_id,
        'anime_title' => $request->anime_title,
        'rating' => $request->rating,
        'review' => $request->review,
        'user_id' => Auth::id(),

    ]);

    return back();

});

Route::delete('/reviews/{id}', function ($id) {

    Review::findOrFail($id)->delete();

    return back();

});

Route::post('/watch-progress', function (Request $request) {

    if (!Auth::check()) {
        return response()->json([
            'success' => false
        ], 401);
    }

    WatchProgress::updateOrCreate(
        [
            'user_id' => Auth::id(),
            'anime_id' => $request->anime_id,
        ],
        [
            'anime_title' => $request->anime_title,
            'episode_number' => $request->episode_number,
        ]
    );

    return response()->json([
        'success' => true
    ]);
});

Route::get('/watch/{id}', function ($id, Request $request) {
    $animeResponse = Http::get("https://api.jikan.moe/v4/anime/$id/full");
    
    if (!$animeResponse->successful()) {
        abort(404, 'Anime not found');
    }
    
    $anime = $animeResponse->json()['data'];
    
    $episodesResponse = Http::get("https://api.jikan.moe/v4/anime/$id/episodes");
    $episodes = $episodesResponse->json()['data'] ?? [];
    
    $episode = $request->get('episode', 1);
    
    $title = $anime['title'];
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    $slug = trim($slug, '-');
    
    $gogoUrl = "https://gogoanime.by/{$slug}-episode-{$episode}";

    
    try {
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Referer' => 'https://gogoanime.by/',
        ])->timeout(30)->get($gogoUrl);
        
        if (!$response->successful()) {
            throw new \Exception('Failed to fetch episode source');
        }
        
$html = $response->body();

        
        preg_match('/defaultEnc1\s*=\s*"([^"]+)"/', $html, $enc1);
        preg_match('/defaultEnc2\s*=\s*"([^"]+)"/', $html, $enc2);
        preg_match('/defaultEnc3\s*=\s*"([^"]+)"/', $html, $enc3);
        preg_match('/defaultPostId\s*=\s*"([^"]+)"/', $html, $postId);
        
        $playerUrl = null;
        
        if (!empty($enc1[1]) && !empty($enc2[1]) && !empty($enc3[1]) && !empty($postId[1])) {
            $playerUrl = "https://9animetv.be/wp-content/plugins/video-player/includes/player/player.php"
                . "?Blogger=" . urlencode($enc1[1])
                . "&url2=" . urlencode($enc2[1])
                . "&url3=" . urlencode($enc3[1])
                . "&ref=gogoanime.by"
                . "&postId=" . $postId[1];
        }
        
        if (Auth::check()) {
            WatchProgress::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'anime_id' => $id,
                ],
                [
                    'anime_title' => $anime['title'],
                    'episode_number' => $episode,
                ]
            );
        }
        
        return view(
            'anime.watch',
            compact(
                'anime',
                'episodes',
                'episode',
                'playerUrl'
            )
        );
        
    } catch (\Exception $e) {

    logger()->error('Watch route error: ' . $e->getMessage(), [
        'anime_id' => $id,
        'episode' => $episode,
        'gogo_url' => $gogoUrl
    ]);
        
        if (Auth::check()) {
            WatchProgress::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'anime_id' => $id,
                ],
                [
                    'anime_title' => $anime['title'],
                    'episode_number' => $episode,
                ]
            );
        }
        
        return view(
            'anime.watch',
            compact(
                'anime',
                'episodes',
                'episode'
            )
        )->with('error', 'Unable to load video source. Please try again later.');
    }
});

Route::get('/watchlist', function () {

    $watchlist = Watchlist::where('user_id', Auth::id())->latest()->get();

    return view(
        'anime.watchlist',
        compact('watchlist')
    );

});

Route::post('/watchlist', function (Request $request) {

    if (!Auth::check()) {
        return redirect('/login');
    }

    Watchlist::firstOrCreate(
        [
            'user_id' => Auth::id(),
            'anime_id' => $request->anime_id,
        ],
        [
            'title' => $request->title,
            'image' => $request->image,
        ]
    );

    return back();

});

Route::get('/profile/stats', function () {
    if (!Auth::check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    
    return response()->json([
        'favorites' => Favorite::where('user_id', Auth::id())->count(),
        'watchlist' => Watchlist::where('user_id', Auth::id())->count(),
        'reviews' => Review::where('user_id', Auth::id())->count(),
        'currently_watching' => WatchProgress::where('user_id', Auth::id())->count(),
        'recently_watched' => WatchProgress::where('user_id', Auth::id())->latest()->count(),
    ]);
});

Route::get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


// Route::get('/kaa/master/{id}/{folder}/playlist.m3u8', function ($id, $folder) {

//     $response = Http::withHeaders([
//         'Referer' => 'https://krussdomi.com/',
//         'Origin' => 'https://krussdomi.com',
//         'User-Agent' => 'Mozilla/5.0'
//     ])->get(
//         "https://hls.krussdomi.com/manifest/$id/$folder/playlist.m3u8"
//     );

//     $playlist = $response->body();

// preg_match_all(
//     '#//([^/]+)/([^/]+)/([^/]+)/([^\\n"]+)#',
//     $playlist,
//     $matches,
//     PREG_SET_ORDER
// );

// foreach ($matches as $match) {

//     $original = $match[0];

//     $proxy =
//         '/kaa/segment/' .
//         $match[1] . '/' .
//         $match[2] . '/' .
//         $match[3] . '/' .
//         $match[4];

//     $playlist = str_replace(
//         $original,
//         $proxy,
//         $playlist
//     );
// }
// return response($playlist)
//     ->header(
//         'Content-Type',
//         'application/vnd.apple.mpegurl'
//     );
// });

// Route::get('/kaa/master/{id}', function ($id) {

//     $response = Http::withHeaders([
//         'Referer' => 'https://kaa.lt/',
//         'Origin' => 'https://kaa.lt',
//         'User-Agent' => 'Mozilla/5.0'
//     ])->get(
//         "https://hls.krussdomi.com/manifest/$id/master.m3u8"
//     );

//     $manifest = $response->body();

//     preg_match_all(
//         '/([a-z0-9]+)\/playlist\.m3u8/i',
//         $manifest,
//         $matches
//     );

//     foreach ($matches[1] as $folder) {

//         $manifest = str_replace(
//             "{$folder}/playlist.m3u8",
//             "/kaa/master/{$id}/{$folder}/playlist.m3u8",
//             $manifest
//         );
//     }
// });




// Route::get(
// '/kaa/segment/{server}/{id}/{folder}/{file}',
// function ($server,$id,$folder,$file) {

//     $url =
//     "https://{$server}/{$id}/{$folder}/{$file}";

//     $response = Http::withHeaders([
//         'Referer' => 'https://krussdomi.com/',
//         'Origin' => 'https://krussdomi.com',
//         'User-Agent' => 'Mozilla/5.0'
//     ])->get($url);

//     return response(
//         $response->body(),
//         200,
//         [
//             'Content-Type' => 'image/jpeg'
//         ]
//     );
// });

// Route::get('/proxy-master', function () {

//     $response = Http::withHeaders([
//         'Referer' => 'https://kaa.lt/',
//         'Origin' => 'https://kaa.lt',
//         'User-Agent' => 'Mozilla/5.0'
//     ])->get(
//         'https://hls.krussdomi.com/manifest/master.m3u8'
//     );

//     $manifest = $response->body();

//     $manifest = preg_replace(
//         '/([a-z0-9]+)\/playlist\.m3u8/i',
//         '/proxy-playlist/$1',
//         $manifest
//     );

//     return response($manifest)
//         ->header(
//             'Content-Type',
//             'application/vnd.apple.mpegurl'
//         );
// });

// Route::get('/proxy-playlist/{folder}', function ($folder) {

// $response = Http::withHeaders([
//     'Referer' => 'https://kaa.lt/',
//     'Origin' => 'https://kaa.lt',
//     'User-Agent' => 'Mozilla/5.0'
// ])->get(
//     "https://hls.krussdomi.com/manifest/$folder/playlist.m3u8"
// );

// $playlist = $response->body();

// preg_match_all(
//     '#//([^/]+)/([^/]+)/([^/]+)/([^\\n]+)#',
//     $playlist,
//     $matches,
//     PREG_SET_ORDER
// );

// foreach ($matches as $m) {

//     $playlist = str_replace(
//         $m[0],
//         "/proxy-segment/{$m[1]}/{$m[2]}/{$m[3]}/{$m[4]}",
//         $playlist
//     );
// }

// return response(
//     $playlist
// )
// ->header(
//     'Content-Type',
//     'application/vnd.apple.mpegurl'
// );
// });

// Route::get(
// '/proxy-segment/{server}/{id}/{folder}/{file}',
// function ($server,$id,$folder,$file) {

//     $url =
//     "https://{$server}/{$id}/{$folder}/{$file}";

//     $response = Http::withHeaders([
//         'Referer' => 'https://krussdomi.com/',
//         'Origin' => 'https://krussdomi.com',
//         'User-Agent' => 'Mozilla/5.0'
//     ])->get($url);
// return response(
//     $response->body()
// );
// });

Route::get('/watch-now/{title}', function ($title) {

    $kaa = new \App\Services\KAAService();

    $keyword = urldecode($title);

    $results = $kaa->search($keyword);

    if (empty($results)) {

        $fallback = preg_replace(
            '/\s+(II|III|IV|V|VI)$/i',
            '',
            $keyword
        );

        $results = $kaa->search($fallback);
    }

    if (empty($results[0]['slug'])) {
        abort(404);
    }

    $animeSlug = $results[0]['slug'];

    $episodes = $kaa->getEpisodes($animeSlug);

    if (empty($episodes['episodes'][0]['slug'])) {

        return redirect(
            '/kaa-anime/' . $animeSlug
        );
    }

    $episodeSlug = $episodes['episodes'][0]['slug'];

    return redirect(
        '/kaa-watch/' .
        $animeSlug . '/' .
        $episodeSlug
    );
});

Route::get('/kaa-anime/{slug}', function ($slug) {

    $target = Cache::remember(
        "kaa_first_episode_{$slug}",
        3600,
        function () use ($slug) {

            $kaa = new KAAService();

            $episodes =
                $kaa->getEpisodes($slug);

            if (
                empty(
                    $episodes['episodes'][0]['slug']
                )
            ) {
                abort(404);
            }

            return
                '/kaa-watch/' .
                $slug . '/' .
                $episodes['episodes'][0]['slug'];
        }
    );

    return redirect($target);
});
Route::get('/kaa-watch/{anime}/{episode}', function ($anime, $episode) {

    $kaa = new \App\Services\KAAService();

    return $kaa->getSource(
        $anime,
        $episode,
        request()->boolean('section')
    );

});

Route::get('/kaa-search', function () {
    return view('kaa-search');
});

Route::post('/kaa-search', function (\Illuminate\Http\Request $request) {

    $kaa = new KAAService();

$results = $kaa->search(
    $request->get('query')
);

    return view(
        'kaa-search',
        compact('results')
    );
});

Route::get('/test-today', function () {

    $kaa = new \App\Services\KAAService();

    dd(
        $kaa->todayReleases()
    );

});

Route::get('/test-airing', function () {

    $kaa = new \App\Services\KAAService();

    dd(
        $kaa->topAiring()
    );

});
Route::get('/test-anime-page', function () {

    $kaa = new KAAService();

    dd(
        $kaa->animePage(2)
    );

});
Route::get('/anime-directory', function () {

    // Browser refresh/direct URL
    if (!request()->has('section')) {
        return redirect('/');
    }

    $page = request('page', 1);

    $data = Http::get(
        "https://kaa.lt/api/anime?page={$page}"
    )->json();

    return view('sections.anime-directory', [
        'animeList' => $data['result'] ?? [],
        'page'      => $page,
        'maxPage'   => $data['maxPage'] ?? 1,
    ]);
});
Route::get('/kaa-cat', function () {

    $start = microtime(true);

    $url = request('url');

    if (!$url) {
        abort(404);
    }

    $headers = [
        'Origin' => 'https://krussdomi.com',
        'Referer' => 'https://krussdomi.com/',
        'Accept' => '*/*',
        'Range' => 'bytes=0-',
        'User-Agent' =>
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36',
    ];

    $path = strtolower(
        parse_url($url, PHP_URL_PATH) ?? ''
    );

    $isPlaylist = str_ends_with($path, '.m3u8');

    if ($isPlaylist) {

        $cacheKey =
            'kaa_playlist_' .
            md5($url);
$body = Cache::rememberForever(
    $cacheKey,
    function () use (
        $url,
        $headers
    ) {

try {

    $response = Http::withHeaders(
        $headers
    )
    ->connectTimeout(5)
    ->timeout(20)
    ->get($url);

    if (!$response->successful()) {
        logger()->error(
            'PLAYLIST_FAILED',
            [
                'url' => $url,
                'status' => $response->status()
            ]
        );

        return '';
    }

    return $response->body();

} catch (\Throwable $e) {

    logger()->error(
        'PLAYLIST_EXCEPTION',
        [
            'url' => $url,
            'message' => $e->getMessage()
        ]
    );

    return '';
}
            }
        );

        logger()->info(
            'KAA CAT FETCH',
            [
                'url' => $url,
                'seconds' =>
                    microtime(true) - $start,
            ]
        );

    } else {

try {

    $response = Http::withHeaders(
        $headers
    )
    ->connectTimeout(5)
    ->timeout(30)
    ->get($url);

    if (!$response->successful()) {

        logger()->error(
            'SEGMENT_FAILED',
            [
                'url' => $url,
                'status' => $response->status()
            ]
        );

        return response(
            '',
            204
        );
    }

    $body = $response->body();

} catch (\Throwable $e) {

    logger()->error(
        'SEGMENT_EXCEPTION',
        [
            'url' => $url,
            'message' => $e->getMessage()
        ]
    );

    return response(
        '',
        204
    );
}

logger()->info(
    'KAA SEGMENT',
    [
        'file' => basename($url),
        'size' => strlen($body),
        'seconds' =>
            microtime(true) - $start,
    ]
);
    }
    if (empty($body)) {

    logger()->warning(
        'EMPTY_BODY',
        [
            'url' => $url
        ]
    );

    return response(
        '',
        204
    );
}
    if (str_contains($body, '#EXTM3U')) {

        $base = dirname($url) . '/';

        $lines = explode(
            "\n",
            $body
        );

        foreach ($lines as &$line) {

            $trim = trim($line);

            if (
                $trim &&
                !str_starts_with(
                    $trim,
                    '#'
                )
            ) {

                if (
                    str_starts_with(
                        $trim,
                        '//'
                    )
                ) {

                    $realUrl =
                        'https:' . $trim;

                } elseif (
                    str_starts_with(
                        $trim,
                        'http'
                    )
                ) {

                    $realUrl = $trim;

                } else {

                    $realUrl =
                        $base . $trim;
                }

                $line =
                    url('/kaa-cat')
                    . '?url='
                    . urlencode(
                        $realUrl
                    );
            }
        }

        $body = implode(
            "\n",
            $lines
        );

        $body = preg_replace_callback(
            '/URI="([^"]+)"/',
            function ($m) use ($base) {

                $audioUrl = $m[1];

                if (
                    str_starts_with(
                        $audioUrl,
                        '//'
                    )
                ) {

                    $audioUrl =
                        'https:' .
                        $audioUrl;

                } elseif (
                    !str_starts_with(
                        $audioUrl,
                        'http'
                    )
                ) {

                    $audioUrl =
                        $base .
                        $audioUrl;
                }

                return 'URI="'
                    . url('/kaa-cat')
                    . '?url='
                    . urlencode(
                        $audioUrl
                    )
                    . '"';
            },
            $body
        );

        return response(
            $body,
            200,
            [
                'Content-Type' =>
                    'application/vnd.apple.mpegurl',
                'Access-Control-Allow-Origin' => '*',
                'Cache-Control' =>
                    'public,max-age=1800',
            ]
        );
    }

    return response(
        $body,
        200,
        [
            'Content-Type' =>
                'application/octet-stream',
            'Access-Control-Allow-Origin' => '*',
            'Cache-Control' =>
                'public,max-age=300',
        ]
    );
});
Route::get(
    '/kaa-manifest/{anime}/{episode}',
    function ($anime, $episode) {

        $service = new \App\Services\KAAService();

        $view = $service->getSource(
            $anime,
            $episode
        );

        $data = $view->getData();

        return response()->json([
            'manifest'   => $data['manifest'],
            'subtitles'  => $data['subtitles'] ?? [],
            'thumbnails' => $data['thumbnails'] ?? null,
        ]);
    }
);


Route::get('/kaa-subtitle', function () {

    $url = request('url');

    logger()->info('SUBTITLE_PROXY', [
        'url' => $url
    ]);

    if (!$url) {
        abort(404);
    }

    $response = Http::withHeaders([
        'Origin'  => 'https://krussdomi.com',
        'Referer' => 'https://krussdomi.com/',
        'User-Agent' => request()->userAgent(),
    ])->get($url);

    if (!$response->successful()) {
        abort($response->status());
    }

    return response(
        $response->body(),
        200,
        [
            'Content-Type' => 'text/plain',
            'Access-Control-Allow-Origin' => '*',
        ]
    );
});

Route::get('/kaa-thumbnail', function () {

    $url = request('url');

    logger()->info('THUMBNAIL_PROXY', [
        'url' => $url
    ]);

    if (!$url) {
        abort(404);
    }

    $response = Http::withHeaders([
        'Origin'  => 'https://krussdomi.com',
        'Referer' => 'https://krussdomi.com/',
        'User-Agent' => request()->userAgent(),
    ])->get($url);

    if (!$response->successful()) {
        abort($response->status());
    }

    return response(
        $response->body(),
        200,
        [
            'Content-Type' => 'text/vtt',
            'Access-Control-Allow-Origin' => '*',
        ]
    );
});


Route::get('/kaa-thumbnail-image', function (Request $request) {
    $url = $request->query('url');
    if (!$url) {
        return response()->json(['error' => 'Missing url parameter'], 400);
    }
    
    try {
        // Validate URL is from allowed domains
        $allowedDomains = [
    'subbl.krussdomi.com',
    'subst.krussdomi.com',
    'krussdomi.com'
];
        $parsedUrl = parse_url($url);
        if (!isset($parsedUrl['host']) || !in_array($parsedUrl['host'], $allowedDomains)) {
            return response()->json(['error' => 'Invalid domain'], 403);
        }
        
        $response = Http::withHeaders([
            'Origin' => 'https://krussdomi.com',
            'Referer' => 'https://krussdomi.com/',
            'User-Agent' => $request->userAgent() ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Accept' => 'image/webp,image/apng,image/*,*/*;q=0.8',
            'Accept-Language' => 'en-US,en;q=0.9',
            'Cache-Control' => 'no-cache',
            'Pragma' => 'no-cache',
        ])->timeout(30)->get($url);

        logger()->info('THUMB_TEST', [
            'url' => $url,
            'status' => $response->status(),
            'type' => $response->header('Content-Type')
        ]);
        
        if (!$response->successful()) {
            return response()->json(['error' => 'Failed to fetch image: ' . $response->status()], $response->status());
        }
        
        $contentType = $response->header('Content-Type');
        if (!$contentType || !str_starts_with($contentType, 'image/')) {
            $contentType = 'image/jpeg';
        }
        
        return response($response->body(), 200)
            ->header('Content-Type', $contentType)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET')
            ->header('Cache-Control', 'public, max-age=86400')
            ->header('Content-Length', strlen($response->body()));
            
    } catch (\Exception $e) {
        \Log::error('Thumbnail image proxy error: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to fetch thumbnail image'], 500);
    }
})->name('kaa.thumbnail.image');

Route::get('/schedule', function () {

    $schedule = Http::get(
        'https://kaa.lt/api/schedule'
    )->json();

    return view('schedule', [
        'schedule' => $schedule
    ]);

});

require __DIR__.'/auth.php';