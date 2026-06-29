<!DOCTYPE html>
<html>
<head>

    <title>{{ $anime['title'] }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>
<body>

<div class="container-fluid">

    <div class="row vh-100">

        <div class="col-md-3 bg-dark text-white p-3">

            <h4>
                Episodes
            </h4>

            <hr>

            @foreach($episodes as $episode)

                <div class="mb-2 {{ (request()->get('episode', 1) == $episode['mal_id']) ? 'bg-primary rounded p-1' : '' }}">

                    <a href="/watch/{{ $anime['mal_id'] }}?episode={{ $episode['mal_id'] }}" class="text-white text-decoration-none">
                        Episode {{ $episode['mal_id'] }}
                    </a>
                    <br>

                    <small>
                        {{ $episode['title'] }}
                    </small>

                </div>

            @endforeach

        </div>

        <div class="col-md-9 p-4">

            <a
                href="/anime/{{ $anime['mal_id'] }}"
                class="btn btn-secondary mb-3">

                ← Back to Details

            </a>

            <h2>
                {{ $anime['title'] }}
            </h2>

            @php
                $currentEpisodeNum = request()->get('episode', 1);
                $currentEpisodeData = collect($episodes)->firstWhere('mal_id', $currentEpisodeNum);
                $totalEpisodes = count($episodes);
            @endphp

            <div class="mb-3">
                <span class="badge bg-info text-dark fs-6">
                    🎬 Episode {{ $currentEpisodeNum }}: {{ $currentEpisodeData['title'] ?? 'Untitled Episode' }}
                </span>
            </div>

<div class="border rounded mb-3 overflow-hidden" style="height:500px;">
@if(!empty($playerUrl))
    <iframe
        src="{{ $playerUrl }}"
        class="w-100 h-100"
        frameborder="0"
        allowfullscreen>
    </iframe>
@else
    <div class="alert alert-warning m-3">
        Video source not available.
    </div>
@endif
</div>

            <div class="d-flex justify-content-between gap-2 mb-4">
                @if($currentEpisodeNum > 1)
                    <a href="/watch/{{ $anime['mal_id'] }}?episode={{ $currentEpisodeNum - 1 }}" 
                       class="btn btn-outline-primary">
                        ← Previous Episode
                    </a>
                @else
                    <button class="btn btn-outline-secondary" disabled>
                        ← Previous Episode
                    </button>
                @endif

                <div class="text-center">
                    <span class="badge bg-secondary fs-6 p-2">
                        Episode {{ $currentEpisodeNum }} of {{ $totalEpisodes }}
                    </span>
                </div>

                @if($currentEpisodeNum < $totalEpisodes)
                    <a href="/watch/{{ $anime['mal_id'] }}?episode={{ $currentEpisodeNum + 1 }}" 
                       class="btn btn-outline-primary">
                        Next Episode →
                    </a>
                @else
                    <button class="btn btn-outline-secondary" disabled>
                        Next Episode →
                    </button>
                @endif
            </div>

            <div class="card">
                <div class="card-header">
                    <strong>Episode Information</strong>
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        Episode {{ $currentEpisodeNum }}: {{ $currentEpisodeData['title'] ?? 'Untitled Episode' }}
                    </h5>
                    @if(isset($currentEpisodeData['synopsis']) && $currentEpisodeData['synopsis'])
                        <p class="card-text">
                            {{ $currentEpisodeData['synopsis'] }}
                        </p>
                    @else
                        <p class="card-text text-muted">
                            No synopsis available for this episode.
                        </p>
                    @endif
                    @if(isset($currentEpisodeData['aired']) && $currentEpisodeData['aired'])
                        <small class="text-muted">
                            Originally aired: {{ $currentEpisodeData['aired'] }}
                        </small>
                    @endif
                </div>
            </div>

        </div>

    </div>

</div>

</body>
</html>