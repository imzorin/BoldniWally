{{-- ========================= --}}
{{-- TOP PAGINATION --}}
{{-- ========================= --}}

@if($page > 1)
<div class="pagination-custom mb-2">
    @if($page > 1)
        <a href="#"
           class="btn btn-outline-secondary anime-page"
           data-page="{{ $page - 1 }}"
           data-section="anime-directory"
           data-url="/anime-directory">
            <i class="bi bi-chevron-left"></i>
            Prev
        </a>
    @endif

    @for($i = max(1, $page - 2); $i <= min($maxPage, $page + 2); $i++)
        @if($i == $page)
            <span class="btn btn-primary">
                {{ $i }}
            </span>
        @else
            <a href="#"
               class="btn btn-outline-primary anime-page"
               data-page="{{ $i }}"
               data-section="anime-directory"
               data-url="{{ url('/anime-directory') }}">
                {{ $i }}
            </a>
        @endif
    @endfor

    @if($page < $maxPage)
        <a href="#"
           class="btn btn-outline-secondary anime-page"
           data-page="{{ $page + 1 }}"
           data-section="anime-directory"
           data-url="{{ url('/anime-directory') }}">
            Next
            <i class="bi bi-chevron-right"></i>
        </a>
    @endif
</div>
@endif

{{-- ========================= --}}
{{-- ANIME GRID --}}
{{-- ========================= --}}

<div class="row g-2">
@foreach($animeList as $item)
<div class="col-3 col-md-2 col-xl-2 d-flex">
    <div class="anime-card w-100">
        <a href="/kaa-anime/{{ $item['slug'] }}"
           class="card-link">
            <img
                loading="lazy"
                src="https://kaa.lt/image/poster/{{ $item['poster']['hq'] ?? $item['poster']['sm'] }}.webp"
                class="card-img-top"
                alt="{{ $item['title_en'] ?? $item['title'] }}">
            <div class="card-body">
                <div class="card-title">
                    {{ $item['title_en'] ?? $item['title'] }}
                </div>
                <div class="card-meta">
                    <span class="badge badge-type">
                        {{ strtoupper($item['type'] ?? 'TV') }}
                    </span>
                    <span class="badge badge-year">
                        {{ $item['year'] ?? '----' }}
                    </span>
                </div>
            </div>
        </a>
    </div>
</div>
@endforeach
</div>

{{-- ========================= --}}
{{-- BOTTOM PAGINATION --}}
{{-- ========================= --}}

<div class="pagination-custom mt-2">
    @if($page > 1)
        <a href="#"
           class="btn btn-outline-secondary anime-page"
           data-page="{{ $page - 1 }}"
           data-section="anime-directory"
           data-url="{{ url('/anime-directory') }}">
            <i class="bi bi-chevron-left"></i>
            Prev
        </a>
    @endif

    @for($i = max(1, $page - 2); $i <= min($maxPage, $page + 2); $i++)
        @if($i == $page)
            <span class="btn btn-primary">
                {{ $i }}
            </span>
        @else
            <a href="#"
               class="btn btn-outline-primary anime-page"
               data-page="{{ $i }}"
               data-section="anime-directory"
               data-url="{{ url('/anime-directory') }}">
                {{ $i }}
            </a>
        @endif
    @endfor

    @if($page < $maxPage)
        <a href="#"
           class="btn btn-outline-secondary anime-page"
           data-page="{{ $page + 1 }}"
           data-section="anime-directory"
           data-url="{{ url('/anime-directory') }}">
            Next
            <i class="bi bi-chevron-right"></i>
        </a>
    @endif
</div>

<style>
/* ============================================================
   UNIFIED ANIME CARD STYLES - MATCHES HOME PAGE
   Applies to ALL anime listing pages
   Desktop remains unchanged
   ============================================================ */

/* ----- Mobile Base Overrides (applies to all mobile) ----- */
@media (max-width: 991.98px) {
    /* 1. Grid: 2 cards per row on all mobile devices */
    .row.g-2 .col-3.col-md-2.col-xl-2 {
        flex: 0 0 50%;
        max-width: 50%;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    /* Larger gap between cards for breathing room */
    .row.g-2 {
        margin-left: -0.5rem;
        margin-right: -0.5rem;
        row-gap: 1rem;
    }

    /* 2. Enhanced card design - matches Home page exactly */
    .anime-card {
        background: rgba(26, 26, 46, 0.7);
        border-radius: 14px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.06);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    /* 3. Poster - matches Home page */
    .anime-card .card-img-top {
        width: 100%;
        height: auto;
        aspect-ratio: 2 / 3;
        object-fit: cover;
        border-radius: 14px 14px 0 0;
        display: block;
        background: #1a1a2e;
    }

    /* 4. Card body - matches Home page spacing */
    .anime-card .card-body {
        padding: 0.75rem 0.6rem 0.7rem;
        flex: 1 1 auto;
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }

    /* 5. Title - 2-line clamp, matches Home page */
    .anime-card .card-title {
        font-size: 0.85rem;
        font-weight: 600;
        line-height: 1.3;
        color: #f1f5f9;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 2.2em;
        max-height: 2.6em;
        word-break: break-word;
        margin: 0;
        letter-spacing: 0.01em;
    }

    /* 6. Card meta/badges - matches Home page */
    .anime-card .card-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.4rem 0.35rem;
        margin-top: auto;
        padding-top: 0.1rem;
    }

    /* 7. Badge styling - matches Home page exactly */
    .anime-card .badge {
        font-size: 0.6rem;
        font-weight: 500;
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
        letter-spacing: 0.02em;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 0.2rem;
        background: rgba(59, 130, 246, 0.2);
        color: #e2e8f0;
        border: 1px solid rgba(255, 255, 255, 0.06);
        line-height: 1.2;
        text-transform: uppercase;
        font-size: 0.55rem;
        padding: 0.2rem 0.5rem;
    }

    /* Type badge (TV, Movie, etc.) */
    .anime-card .badge-type {
        background: rgba(59, 130, 246, 0.25);
        color: #93c5fd;
    }

    /* Year badge */
    .anime-card .badge-year {
        background: rgba(168, 85, 247, 0.2);
        color: #c4b5fd;
    }

    /* 8. Touch: entire card is clickable, increase tap area */
    .anime-card .card-link {
        display: flex;
        flex-direction: column;
        height: 100%;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
    }

    /* 9. Press feedback on mobile - subtle scale */
    .anime-card:active {
        transform: scale(0.97);
        transition: transform 0.1s ease;
    }

    /* 10. Hover effects - matches Home page (desktop only) */
    .anime-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
        border-color: rgba(59, 130, 246, 0.2);
    }

    /* 11. Prevent overflow issues */
    .anime-card .card-body,
    .anime-card .card-title,
    .anime-card .card-meta {
        overflow: visible;
    }

    /* 12. Extra small screens - matches Home page */
    @media (max-width: 480px) {
        .row.g-2 .col-3.col-md-2.col-xl-2 {
            flex: 0 0 50%;
            max-width: 50%;
            padding-left: 0.35rem;
            padding-right: 0.35rem;
        }

        .row.g-2 {
            margin-left: -0.35rem;
            margin-right: -0.35rem;
            row-gap: 0.85rem;
        }

        .anime-card .card-body {
            padding: 0.6rem 0.45rem 0.6rem;
            gap: 0.35rem;
        }

        .anime-card .card-title {
            font-size: 0.75rem;
            min-height: 2em;
            max-height: 2.4em;
        }

        .anime-card .badge {
            font-size: 0.5rem;
            padding: 0.15rem 0.4rem;
        }

        .anime-card .card-meta {
            gap: 0.25rem;
        }
    }

    /* 13. For larger tablets - optional 3 cards per row */
    @media (min-width: 600px) and (max-width: 991.98px) {
        .row.g-2 .col-3.col-md-2.col-xl-2 {
            flex: 0 0 33.333%;
            max-width: 33.333%;
        }

        .anime-card .card-title {
            font-size: 0.9rem;
        }

        .anime-card .badge {
            font-size: 0.6rem;
            padding: 0.25rem 0.55rem;
        }
    }
}

/* ----- Desktop - Completely untouched ----- */
@media (min-width: 992px) {
    /* Force reset any mobile overrides */
    .row.g-2 .col-3.col-md-2.col-xl-2 {
        flex: 0 0 16.6667%;
        max-width: 16.6667%;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    .anime-card {
        background: rgba(26, 26, 46, 0.6);
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .anime-card .card-body {
        padding: 0.5rem 0.4rem 0.6rem;
        flex: 1 1 auto;
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .anime-card .card-title {
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1.2;
        color: #f1f5f9;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 2.2em;
        margin: 0;
        word-break: break-word;
    }

    .anime-card .card-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.2rem 0.25rem;
        margin-top: auto;
    }

    .anime-card .badge {
        font-size: 0.55rem;
        font-weight: 500;
        padding: 0.15rem 0.4rem;
        border-radius: 20px;
        letter-spacing: 0.02em;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 0.15rem;
        background: rgba(59, 130, 246, 0.2);
        color: #e2e8f0;
        border: 1px solid rgba(255, 255, 255, 0.06);
        line-height: 1.2;
        text-transform: uppercase;
    }

    .anime-card .badge-type {
        background: rgba(59, 130, 246, 0.25);
        color: #93c5fd;
    }

    .anime-card .badge-year {
        background: rgba(168, 85, 247, 0.2);
        color: #c4b5fd;
    }

    .anime-card .card-link {
        display: flex;
        flex-direction: column;
        height: 100%;
        text-decoration: none;
        color: inherit;
    }

    .anime-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
        border-color: rgba(59, 130, 246, 0.2);
    }

    /* Remove mobile touch effects on desktop */
    .anime-card:active {
        transform: none;
    }

    .row.g-2 {
        margin-left: -0.5rem;
        margin-right: -0.5rem;
        row-gap: 0.5rem;
    }
}

/* ===== Global card fixes - applies to all sizes ===== */
.anime-card .card-link {
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%;
    text-decoration: none;
    color: inherit;
}

.anime-card .card-img-top {
    display: block;
    width: 100%;
    height: auto;
    aspect-ratio: 2 / 3;
    object-fit: cover;
    background: #1a1a2e;
}

.anime-card .card-meta {
    flex-wrap: wrap;
    align-items: center;
}

.anime-card .card-title {
    word-break: break-word;
    overflow-wrap: break-word;
    hyphens: auto;
}

.anime-card .card-body,
.anime-card .card-title,
.anime-card .card-meta {
    margin: 0;
}

.anime-card {
    border-radius: 12px;
    overflow: hidden;
}

/* Pagination Custom - consistent with design */
.pagination-custom {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.pagination-custom .btn {
    min-width: 40px;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

@media (max-width: 576px) {
    .pagination-custom .btn {
        min-width: 35px;
        padding: 0.4rem 0.6rem;
        font-size: 0.8rem;
    }
}

/* ===== END ===== */
</style>