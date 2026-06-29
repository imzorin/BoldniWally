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
@endif

{{-- ========================= --}}
{{-- ANIME GRID --}}
{{-- ========================= --}}

<div class="row g-2">
@foreach($animeList as $item)
<div class="col-6 col-md-4 col-xl-2 d-flex">
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
                <div class="card-meta d-flex justify-content-between">
                    <span class="badge badge-rating">
                        {{ strtoupper($item['type'] ?? 'TV') }}
                    </span>
                    <span class="text-secondary">
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