<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AniWaveService
{
    protected string $baseUrl = 'https://aniwaves.ru';

public function search(string $title)
{
    $response = Http::withHeaders([
        'User-Agent' => 'Mozilla/5.0',
        'X-Requested-With' => 'XMLHttpRequest',
        'Accept' => 'application/json, text/javascript, */*; q=0.01',
        'Referer' => 'https://aniwaves.ru/',
    ])->get(
        'https://aniwaves.ru/ajax/anime/search',
        [
            'keyword' => $title
        ]
    );

    $data = $response->json();

    $html = $data['result']['html'] ?? '';

    preg_match(
        '/href="\/watch\/([^"]+)"/',
        $html,
        $matches
    );

    return [
        'status' => $response->status(),
        'slug' => $matches[1] ?? null,
        'html_found' => !empty($html)
    ];
}

}