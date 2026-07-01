<!-- Top Statistics Cards - Premium Streaming Style -->
@auth
<div class="row g-2 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-content">
                <span class="stat-label">Favorites</span>
                <span class="stat-number">{{ $favoritesCount }}</span>
                <span class="stat-subtitle">Saved Anime</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-content">
                <span class="stat-label">Watchlist</span>
                <span class="stat-number">{{ $watchlistCount }}</span>
                <span class="stat-subtitle">Plan to Watch</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-content">
                <span class="stat-label">Reviews</span>
                <span class="stat-number">{{ $reviewsCount }}</span>
                <span class="stat-subtitle">Total Reviews</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-content">
                <span class="stat-label">Continue Watching</span>
                <span class="stat-number">{{ $currentlyWatchingCount }}</span>
                <span class="stat-subtitle">In Progress</span>
            </div>
        </div>
    </div>
</div>

<!-- Continue Watching -->
@if(isset($continueWatching) && $continueWatching->count())
<div class="mb-3">
    <h5 class="section-title">Continue Watching</h5>
    <div class="row g-2">
        @foreach($continueWatching as $item)
        <div class="col-md-6 col-lg-4">
            <a href="/watch/{{ $item->anime_id }}?episode={{ $item->episode_number }}" class="continue-card">
                <img src="https://kaa.lt/image/poster/{{ $item->poster ?? '' }}.webp" 
                     class="continue-thumb" 
                     alt="{{ $item->anime_title }}"
                     loading="lazy"
                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'64\' height=\'96\'%3E%3Crect width=\'64\' height=\'96\' fill=\'%232a2a2e\'/%3E%3C/svg%3E'">
                <div class="continue-info">
                    <div class="continue-title">{{ $item->anime_title }}</div>
                    <div class="continue-episode">Episode {{ $item->episode_number }}</div>
                    <span class="btn-resume"><i class="bi bi-play-fill"></i> Resume</span>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Recently Watched -->
@if(isset($recentlyWatched) && $recentlyWatched->count())
<div class="mb-3">
    <h5 class="section-title">Recently Watched</h5>
    <div class="row g-2">
        @foreach($recentlyWatched as $item)
        <div class="col-12">
            <a href="/watch/{{ $item->anime_id }}?episode={{ $item->episode_number }}" class="recent-item">
                <span class="recent-title">{{ $item->anime_title }}</span>
                <span>
                    <span class="recent-meta">Episode {{ $item->episode_number }}</span>
                    <span class="recent-time ms-3"><i class="bi bi-clock"></i> {{ $item->updated_at->diffForHumans() }}</span>
                </span>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif
@endauth

<!-- Latest Updates -->
<h5 class="section-title">Latest Updates</h5>

<!-- Top Pagination - Only show on Page 2 and above -->
@if($page > 1)
<div class="pagination-wrapper pagination-top mb-3">
    <div class="pagination-container">
        @if($page > 1)
        <a href="/?page={{ $page - 1 }}" class="pagination-btn pagination-prev">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Prev
        </a>
        @endif
        <span class="pagination-btn pagination-current">Page {{ $page }}</span>
        @if($hasNext)
        <a href="/?page={{ $page + 1 }}" class="pagination-btn pagination-next">
            Next
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        @endif
    </div>
</div>
@endif

<!-- Anime Grid -->
<div class="row g-2">
    @foreach($trending as $anime)
    <div class="col-3 col-md-2 col-xl-2">
        <div class="anime-card">
            <a href="/kaa-anime/{{ $anime['slug'] }}" class="card-link">
                <img src="https://kaa.lt/image/poster/{{ $anime['poster'] }}.webp" 
                     class="card-img-top" 
                     alt="{{ $anime['title'] }}"
                     loading="lazy"
                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'200\' height=\'300\'%3E%3Crect width=\'200\' height=\'300\' fill=\'%232a2a2e\'/%3E%3C/svg%3E'">
                <div class="card-body">
                    <div class="card-title">{{ $anime['title'] }}</div>
                    <div class="card-meta">
                        <span class="badge badge-type">{{ $anime['type'] }}</span>
                        <span class="badge badge-episode">EP {{ $anime['episode'] }}</span>
                        @if(isset($anime['rating']) && $anime['rating'])
                        <span class="badge badge-rating"><i class="bi bi-star-fill"></i> {{ $anime['rating'] }}</span>
                        @endif
                    </div>
                </div>
            </a>
        </div>
    </div>
    @endforeach
</div>

<!-- Bottom Pagination - Always visible -->
<div class="pagination-wrapper mt-4">
    <div class="pagination-container">
        @if($page > 1)
        <a href="/?page={{ $page - 1 }}" class="pagination-btn pagination-prev">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Prev
        </a>
        @endif
        <span class="pagination-btn pagination-current">Page {{ $page }}</span>
        @if($hasNext)
        <a href="/?page={{ $page + 1 }}" class="pagination-btn pagination-next">
            Next
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        @endif
    </div>
</div>

<style>
/* ===== PREMIUM STAT CARDS ===== */

.stat-card {
    background: rgba(26, 26, 46, 0.75);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(42, 53, 85, 0.6);
    border-radius: 12px;
    padding: 0.75rem 1rem;
    height: 100%;
    min-height: 70px;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    cursor: default;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, #3b82f6, #8b5cf6);
    opacity: 0.6;
    border-radius: 12px 12px 0 0;
}

.stat-card:hover {
    transform: translateY(-2px);
    border-color: rgba(59, 130, 246, 0.3);
    box-shadow: 0 8px 30px rgba(59, 130, 246, 0.08), 0 4px 15px rgba(0, 0, 0, 0.3);
    background: rgba(30, 30, 52, 0.85);
}

.stat-card:hover::before {
    opacity: 1;
    box-shadow: 0 0 40px rgba(59, 130, 246, 0.15);
}

.stat-content {
    display: flex;
    flex-direction: column;
    width: 100%;
    gap: 0.1rem;
}

.stat-label {
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: rgba(255, 255, 255, 0.4);
    order: 1;
}

.stat-number {
    font-size: 1.6rem;
    font-weight: 700;
    color: #ffffff;
    line-height: 1.2;
    order: 2;
    letter-spacing: -0.02em;
}

.stat-subtitle {
    font-size: 0.7rem;
    color: rgba(255, 255, 255, 0.3);
    font-weight: 400;
    order: 3;
    margin-top: -0.05rem;
}

/* Stat card gradients for each card - subtle accent on hover */
.stat-card:nth-child(1):hover {
    border-color: rgba(236, 72, 153, 0.3);
    box-shadow: 0 8px 30px rgba(236, 72, 153, 0.08), 0 4px 15px rgba(0, 0, 0, 0.3);
}
.stat-card:nth-child(1):hover::before {
    background: linear-gradient(90deg, #ec4899, #f472b6);
}

.stat-card:nth-child(2):hover {
    border-color: rgba(59, 130, 246, 0.3);
    box-shadow: 0 8px 30px rgba(59, 130, 246, 0.08), 0 4px 15px rgba(0, 0, 0, 0.3);
}
.stat-card:nth-child(2):hover::before {
    background: linear-gradient(90deg, #3b82f6, #60a5fa);
}

.stat-card:nth-child(3):hover {
    border-color: rgba(251, 191, 36, 0.3);
    box-shadow: 0 8px 30px rgba(251, 191, 36, 0.08), 0 4px 15px rgba(0, 0, 0, 0.3);
}
.stat-card:nth-child(3):hover::before {
    background: linear-gradient(90deg, #fbbf24, #f59e0b);
}

.stat-card:nth-child(4):hover {
    border-color: rgba(52, 211, 153, 0.3);
    box-shadow: 0 8px 30px rgba(52, 211, 153, 0.08), 0 4px 15px rgba(0, 0, 0, 0.3);
}
.stat-card:nth-child(4):hover::before {
    background: linear-gradient(90deg, #34d399, #10b981);
}

/* Reduced spacing for smaller screens */
@media (max-width: 768px) {
    .stat-card {
        min-height: 60px;
        padding: 0.6rem 0.85rem;
        border-radius: 10px;
    }
    
    .stat-number {
        font-size: 1.3rem;
    }
    
    .stat-label {
        font-size: 0.55rem;
    }
    
    .stat-subtitle {
        font-size: 0.6rem;
    }
}

@media (max-width: 576px) {
    .stat-card {
        min-height: 55px;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
    }
    
    .stat-number {
        font-size: 1.1rem;
    }
    
    .stat-label {
        font-size: 0.5rem;
    }
    
    .stat-subtitle {
        font-size: 0.55rem;
    }
}

/* Smooth animation on mount */
@keyframes statFadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card {
    animation: statFadeIn 0.4s ease-out forwards;
}

.stat-card:nth-child(2) {
    animation-delay: 0.05s;
}
.stat-card:nth-child(3) {
    animation-delay: 0.1s;
}
.stat-card:nth-child(4) {
    animation-delay: 0.15s;
}

/* ===== END PREMIUM STAT CARDS ===== */

/* ===== PAGINATION STYLES ===== */

.pagination-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.pagination-wrapper.pagination-top {
    margin-bottom: 0.75rem;
}

.pagination-container {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.03);
    padding: 0.5rem;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.06);
    backdrop-filter: blur(10px);
}

.pagination-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.6rem 1.2rem;
    min-height: 42px;
    min-width: 42px;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    background: #1a1a2e;
    color: #ffffff;
    border: 1px solid rgba(59, 130, 246, 0.2);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    letter-spacing: 0.3px;
    position: relative;
    user-select: none;
    white-space: nowrap;
}

.pagination-btn svg {
    flex-shrink: 0;
    transition: transform 0.2s ease;
    stroke: #ffffff;
}

.pagination-btn:hover {
    background: #1a1a2e;
    color: #ffffff;
    border-color: rgba(59, 130, 246, 0.5);
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.15);
    transform: translateY(-1px);
    text-decoration: none;
}

.pagination-btn:active {
    transform: translateY(0px) scale(0.96);
}

.pagination-prev:hover svg {
    transform: translateX(-2px);
}

.pagination-next:hover svg {
    transform: translateX(2px);
}

.pagination-current {
    background: #3b82f6;
    color: #ffffff;
    font-weight: 600;
    padding: 0.6rem 1.4rem;
    border: none;
    box-shadow: 0 0 25px rgba(59, 130, 246, 0.3), 0 0 60px rgba(59, 130, 246, 0.1);
    cursor: default;
    position: relative;
    min-width: 100px;
    letter-spacing: 0.5px;
}

.pagination-current::before {
    content: '';
    position: absolute;
    inset: -1px;
    border-radius: 8px;
    padding: 1px;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), transparent);
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
}

.pagination-current::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 8px;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.pagination-current:hover {
    transform: none;
    background: #3b82f6;
    box-shadow: 0 0 35px rgba(59, 130, 246, 0.4), 0 0 80px rgba(59, 130, 246, 0.15);
    color: #ffffff;
}

.pagination-current:hover::after {
    opacity: 1;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .pagination-container {
        gap: 0.35rem;
        padding: 0.4rem;
        border-radius: 10px;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .pagination-btn {
        padding: 0.5rem 0.9rem;
        min-height: 38px;
        min-width: 38px;
        font-size: 0.8rem;
        gap: 0.35rem;
    }
    
    .pagination-btn svg {
        width: 14px;
        height: 14px;
    }
    
    .pagination-current {
        padding: 0.5rem 1rem;
        min-width: 80px;
        font-size: 0.8rem;
    }
}

@media (max-width: 400px) {
    .pagination-container {
        gap: 0.25rem;
        padding: 0.3rem;
    }
    
    .pagination-btn {
        padding: 0.4rem 0.7rem;
        min-height: 34px;
        min-width: 34px;
        font-size: 0.75rem;
        gap: 0.25rem;
    }
    
    .pagination-btn svg {
        width: 12px;
        height: 12px;
    }
    
    .pagination-current {
        padding: 0.4rem 0.8rem;
        min-width: 70px;
        font-size: 0.75rem;
    }
}

/* Subtle animation on mount */
@keyframes paginationFadeIn {
    from {
        opacity: 0;
        transform: translateY(8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.pagination-wrapper {
    animation: paginationFadeIn 0.4s ease-out;
}

/* ===== END PAGINATION STYLES ===== */

/* ============================================================
   IMPROVED ANIME CARDS - MOBILE ONLY
   Target: .anime-card inside .row.g-2
   Desktop: Unchanged
   ============================================================ */

/* ----- Mobile Base Overrides (applies to all mobile) ----- */
@media (max-width: 991.98px) {
    /* 1. Grid: 2 cards per row on small phones, 3 on larger tablets */
    .row.g-2 .col-3.col-md-2.col-xl-2 {
        flex: 0 0 50%;          /* 2 cards per row */
        max-width: 50%;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    /* Slightly larger gap between cards */
    .row.g-2 {
        margin-left: -0.5rem;
        margin-right: -0.5rem;
        row-gap: 1rem;          /* vertical gap between rows */
    }

    /* 2. Card itself: more padding, consistent height, better touch */
    .anime-card {
        background: rgba(26, 26, 46, 0.6);
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height: 100%;           /* maintain consistent height */
        display: flex;
        flex-direction: column;
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.04);
        padding: 0;             /* we handle padding inside */
    }

    /* 3. Poster: slightly larger, keep aspect ratio */
    .anime-card .card-img-top {
        width: 100%;
        height: auto;
        aspect-ratio: 2 / 3;    /* typical poster ratio */
        object-fit: cover;
        border-radius: 12px 12px 0 0;
        display: block;
        background: #1a1a2e;
    }

    /* 4. Card body: more padding, better spacing */
    .anime-card .card-body {
        padding: 0.75rem 0.6rem 0.7rem;
        flex: 1 1 auto;
        display: flex;
        flex-direction: column;
        gap: 0.45rem;           /* space between title and badges */
    }

    /* 5. Title: 2-line clamp, no overflow, consistent height */
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
        min-height: 2.2em;      /* reserve space for 2 lines */
        max-height: 2.6em;
        word-break: break-word;
        margin: 0;
        letter-spacing: 0.01em;
    }

    /* 6. Card meta/badges: more breathing room */
    .anime-card .card-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.4rem 0.35rem;
        margin-top: auto;       /* push badges to bottom */
        padding-top: 0.1rem;
    }

    /* 7. Badge styling: readable, not cramped */
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
        font-size: 0.55rem;     /* slightly smaller but readable */
        padding: 0.2rem 0.5rem;
    }

    /* type badge (TV) */
    .anime-card .badge-type {
        background: rgba(59, 130, 246, 0.25);
        color: #93c5fd;
    }

    /* episode badge */
    .anime-card .badge-episode {
        background: rgba(168, 85, 247, 0.2);
        color: #c4b5fd;
    }

    /* rating badge (PG-13, etc.) */
    .anime-card .badge-rating {
        background: rgba(251, 191, 36, 0.15);
        color: #fcd34d;
        gap: 0.15rem;
    }

    .anime-card .badge-rating i {
        font-size: 0.5rem;
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

    /* 9. Hover effects: keep desktop style, but on mobile we just add subtle press feedback */
    .anime-card:active {
        transform: scale(0.97);
        transition: transform 0.1s ease;
    }

    /* small elevation on hover (desktop-like) but without animation on mobile */
    .anime-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
        border-color: rgba(59, 130, 246, 0.2);
    }

    /* 10. Fix any overflow or cut-off */
    .anime-card .card-body,
    .anime-card .card-title,
    .anime-card .card-meta {
        overflow: visible;
    }

    /* 11. Extra padding for very small screens */
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

    /* 12. For larger tablets (>= 600px) we can show 3 cards per row */
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

/* ----- Ensure desktop is completely untouched ----- */
@media (min-width: 992px) {
    /* Force reset any mobile overrides */
    .row.g-2 .col-3.col-md-2.col-xl-2 {
        flex: 0 0 16.6667%;
        max-width: 16.6667%;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    .anime-card {
        /* keep original desktop styles (we don't override) */
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

    .anime-card .badge-episode {
        background: rgba(168, 85, 247, 0.2);
        color: #c4b5fd;
    }

    .anime-card .badge-rating {
        background: rgba(251, 191, 36, 0.15);
        color: #fcd34d;
        gap: 0.15rem;
    }

    .anime-card .badge-rating i {
        font-size: 0.5rem;
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

    /* remove any mobile touch effects */
    .anime-card:active {
        transform: none;
    }

    .row.g-2 {
        margin-left: -0.5rem;
        margin-right: -0.5rem;
        row-gap: 0.5rem;
    }
}

/* ===== Additional micro-adjustments for consistency ===== */
/* Ensure the card-link fills the card on all sizes */
.anime-card .card-link {
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%;
    text-decoration: none;
    color: inherit;
}

/* Fix any potential clipping on the poster */
.anime-card .card-img-top {
    display: block;
    width: 100%;
    height: auto;
    aspect-ratio: 2 / 3;
    object-fit: cover;
    background: #1a1a2e;
}

/* Keep badges from wrapping awkwardly */
.anime-card .card-meta {
    flex-wrap: wrap;
    align-items: center;
}

/* Ensure title doesn't overflow on any screen */
.anime-card .card-title {
    word-break: break-word;
    overflow-wrap: break-word;
    hyphens: auto;
}

/* Remove any default margin/padding that breaks layout */
.anime-card .card-body,
.anime-card .card-title,
.anime-card .card-meta {
    margin: 0;
}

/* Star icon in rating badge stays inline */
.anime-card .badge-rating i {
    font-size: 0.55rem;
    margin-right: 0.05rem;
}

/* Consistent border-radius on card */
.anime-card {
    border-radius: 12px;
    overflow: hidden;
}

/* ===== END ===== */
</style>