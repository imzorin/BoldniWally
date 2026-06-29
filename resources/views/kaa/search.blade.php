<!DOCTYPE html>
<html>
<head>
    <title>MondigSAnime - Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --mondig-dark: #0a0e1a;
            --mondig-darker: #060a14;
            --mondig-card: #111827;
            --mondig-card-hover: #1a2332;
            --mondig-primary: #3b82f6;
            --mondig-primary-glow: rgba(59, 130, 246, 0.3);
            --mondig-border: #1e2a3a;
            --mondig-text: #e5e7eb;
            --mondig-text-muted: #9ca3af;
        }

        body {
            background: var(--mondig-dark);
            color: var(--mondig-text);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            padding: 2rem 0 4rem 0;
        }

        .search-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* ===== SEARCH HEADER ===== */
        .search-header {
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--mondig-border);
        }

        .search-header .search-title {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #ffffff;
            margin: 0;
        }

        .search-header .search-title .highlight {
            color: var(--mondig-primary);
        }

        .search-header .search-subtitle {
            font-size: 1rem;
            color: var(--mondig-text-muted);
            margin-top: 0.35rem;
        }

        .search-header .search-subtitle .query-display {
            color: #ffffff;
            font-weight: 500;
        }

        .search-header .search-subtitle .count-badge {
            display: inline-block;
            background: var(--mondig-primary);
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.2rem 0.8rem;
            border-radius: 20px;
            margin-left: 0.5rem;
        }

        /* ===== RESULT GRID ===== */
        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.75rem;
        }

        /* ===== ANIME CARD ===== */
        .anime-card {
            background: var(--mondig-card);
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            border: 1px solid transparent;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .anime-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.6), 0 0 0 1px var(--mondig-primary), 0 0 20px var(--mondig-primary-glow);
            border-color: var(--mondig-primary);
            background: var(--mondig-card-hover);
        }

        .anime-card .poster-wrapper {
            position: relative;
            overflow: hidden;
            background: var(--mondig-darker);
            aspect-ratio: 2 / 3;
            flex-shrink: 0;
        }

        .anime-card .poster-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
            display: block;
        }

        .anime-card:hover .poster-wrapper img {
            transform: scale(1.05);
        }

        .anime-card .card-body {
            padding: 1rem 1rem 1.1rem 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .anime-card .card-body .card-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #ffffff;
            line-height: 1.4;
            margin: 0 0 0.3rem 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.6rem;
        }

        .anime-card .card-body .card-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.4rem 0.6rem;
            margin-bottom: 0.7rem;
            font-size: 0.8rem;
            color: var(--mondig-text-muted);
        }

        .anime-card .card-body .card-meta .year {
            color: var(--mondig-text-muted);
        }

        .anime-card .card-body .card-meta .badge-type {
            background: rgba(59, 130, 246, 0.15);
            color: var(--mondig-primary);
            font-size: 0.65rem;
            font-weight: 600;
            padding: 0.15rem 0.65rem;
            border-radius: 12px;
            border: 1px solid rgba(59, 130, 246, 0.2);
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .anime-card .card-body .card-meta .badge-status {
            background: rgba(16, 185, 129, 0.12);
            color: #34d399;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 0.15rem 0.65rem;
            border-radius: 12px;
            border: 1px solid rgba(16, 185, 129, 0.2);
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .anime-card .card-body .card-meta .badge-status.ongoing {
            background: rgba(251, 191, 36, 0.12);
            color: #fbbf24;
            border-color: rgba(251, 191, 36, 0.2);
        }

        .anime-card .card-body .card-meta .badge-status.finished {
            background: rgba(107, 114, 128, 0.15);
            color: #9ca3af;
            border-color: rgba(107, 114, 128, 0.2);
        }

        /* ===== NEW "WATCH NOW" BUTTON ===== */
        .anime-card .card-body .btn-watch {
            margin-top: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            background: linear-gradient(145deg, #2563eb, #3b82f6);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.8rem;
            padding: 0.45rem 1.2rem;
            border-radius: 50px;           /* pill shape */
            border: none;
            text-decoration: none;
            width: fit-content;
            letter-spacing: 0.02em;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.25);
            transition: all 0.25s ease;
            transform: translateY(0);
            position: relative;
        }

        .anime-card .card-body .btn-watch i {
            font-size: 0.7rem;
            color: #ffffff;
            filter: drop-shadow(0 0 2px rgba(255,255,255,0.2));
            transition: transform 0.2s ease;
        }

        .anime-card .card-body .btn-watch:hover {
            background: linear-gradient(145deg, #3b82f6, #60a5fa);
            box-shadow: 0 8px 22px rgba(59, 130, 246, 0.5), 0 0 12px var(--mondig-primary-glow);
            transform: translateY(-3px);
            color: #ffffff;
        }

        .anime-card .card-body .btn-watch:hover i {
            transform: scale(1.05);
        }

        .anime-card .card-body .btn-watch:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        /* ===== RESPONSIVE TWEAKS ===== */
        @media (max-width: 768px) {
            .search-container {
                padding: 0 1rem;
            }

            .search-header .search-title {
                font-size: 1.5rem;
            }

            .results-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 1.25rem;
            }

            .anime-card .card-body .card-title {
                font-size: 0.85rem;
                min-height: 2.2rem;
            }

            .anime-card .card-body .card-meta {
                font-size: 0.7rem;
            }

            .anime-card .card-body .btn-watch {
                font-size: 0.7rem;
                padding: 0.35rem 1rem;
                gap: 0.4rem;
            }
            .anime-card .card-body .btn-watch i {
                font-size: 0.6rem;
            }
        }

        @media (max-width: 480px) {
            .results-grid {
                grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
                gap: 1rem;
            }

            .search-header .search-title {
                font-size: 1.25rem;
            }

            .search-header .search-subtitle {
                font-size: 0.85rem;
            }

            .anime-card .card-body {
                padding: 0.7rem 0.7rem 0.9rem 0.7rem;
            }

            .anime-card .card-body .btn-watch {
                font-size: 0.65rem;
                padding: 0.3rem 0.9rem;
                gap: 0.35rem;
            }
            .anime-card .card-body .btn-watch i {
                font-size: 0.55rem;
            }
        }

        @media (min-width: 1200px) {
            .results-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 2rem;
            }
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--mondig-card);
            border-radius: 20px;
            border: 1px solid var(--mondig-border);
            max-width: 600px;
            margin: 2rem auto;
        }

        .empty-state .empty-icon {
            font-size: 3.5rem;
            color: var(--mondig-text-muted);
            opacity: 0.3;
            margin-bottom: 1rem;
        }

        .empty-state .empty-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.5rem;
        }

        .empty-state .empty-sub {
            color: var(--mondig-text-muted);
            font-size: 1rem;
        }

        /* Scrollbar styling (optional) */
        ::-webkit-scrollbar {
            width: 8px;
            background: var(--mondig-dark);
        }
        ::-webkit-scrollbar-track {
            background: var(--mondig-darker);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--mondig-border);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--mondig-primary);
        }
    </style>
</head>
<body>

<div class="search-container">

    {{-- SEARCH HEADER --}}
    <div class="search-header">
        <h1 class="search-title">
            Search Results
        </h1>
        <div class="search-subtitle">
            <span class="query-display">“{{ $query }}”</span>
            <span class="count-badge">{{ count($results) }} Anime Found</span>
        </div>
    </div>

    {{-- RESULTS GRID --}}
    <div class="results-grid">

        @forelse($results as $anime)

            <div class="anime-card">

                {{-- POSTER --}}
                <div class="poster-wrapper">
                    <img
                        src="https://kaa.lt/image/poster/{{ $anime['poster']['hq'] ?? $anime['poster']['sm'] }}.webp"
                        alt="{{ $anime['title'] }}"
                        onerror="this.src='https://via.placeholder.com/300x450?text=No+Image'"
                        loading="lazy"
                    >
                </div>

                {{-- BODY --}}
                <div class="card-body">

                    {{-- TITLE --}}
                    <div class="card-title">
                        {{ $anime['title'] }}
                    </div>

                    {{-- META: YEAR + BADGES --}}
                    <div class="card-meta">
                        @if(isset($anime['year']) && $anime['year'])
                            <span class="year">{{ $anime['year'] }}</span>
                        @endif

                        {{-- Type badge (if available) --}}
                        @if(isset($anime['type']) && $anime['type'])
                            <span class="badge-type">{{ $anime['type'] }}</span>
                        @endif

                        {{-- Status badge (if available) --}}
                        @if(isset($anime['status']) && $anime['status'])
                            @php
                                $statusClass = '';
                                if (str_contains(strtolower($anime['status']), 'ongoing') || str_contains(strtolower($anime['status']), 'airing')) {
                                    $statusClass = 'ongoing';
                                } elseif (str_contains(strtolower($anime['status']), 'finished') || str_contains(strtolower($anime['status']), 'completed')) {
                                    $statusClass = 'finished';
                                }
                            @endphp
                            <span class="badge-status {{ $statusClass }}">{{ $anime['status'] }}</span>
                        @endif
                    </div>

                    {{-- ===== NEW WATCH NOW BUTTON (replaces Details) ===== --}}
                    <a
                        href="{{ url('/kaa-anime/' . $anime['slug']) }}"
                        class="btn-watch"
                    >
                        <i class="fas fa-play"></i> Watch Now
                    </a>

                </div>

            </div>

        @empty

            {{-- EMPTY STATE --}}
            <div class="empty-state" style="grid-column: 1 / -1;">
                <div class="empty-icon">
                    <i class="fas fa-search"></i>
                </div>
                <div class="empty-title">No Anime Found</div>
                <div class="empty-sub">Try another keyword.</div>
            </div>

        @endforelse

    </div>

</div>

{{-- Bootstrap JS (optional, for any toggles etc.) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>