<div class="row g-2">
@foreach($anime as $item)
<div class="col-3 col-md-2 col-xl-2">
    <div class="anime-card">
        <a href="/kaa-anime/{{ $item['slug'] }}"
           class="card-link">
            <img
                loading="lazy"
                src="https://kaa.lt/image/poster/{{ $item['poster']['hq'] }}.webp"
                class="card-img-top"
                alt="{{ $item['title_en'] ?? $item['title'] }}">
            <div class="card-body">
                <div class="card-title">
                    {{ $item['title_en'] ?? $item['title'] }}
                </div>
                <div class="card-meta d-flex justify-content-between">
                    <span class="badge badge-rating">
                        {{ strtoupper($item['type']) }}
                    </span>
                    <span class="text-secondary">
                        {{ $item['year'] }}
                    </span>
                </div>
            </div>
        </a>
    </div>
</div>
@endforeach
</div>