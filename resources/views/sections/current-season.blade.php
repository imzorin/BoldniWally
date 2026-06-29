<div class="row g-2">
@foreach($anime as $item)
<div class="col-6 col-md-4 col-xl-2">
    <div class="anime-card">
        <a href="/anime/{{ $item['mal_id'] }}"
           class="card-link">
            <img
                loading="lazy"
                src="{{ $item['images']['jpg']['image_url'] }}"
                class="card-img-top"
                alt="{{ $item['title'] }}">
            <div class="card-body">
                <div class="card-title">
                    {{ $item['title'] }}
                </div>
                <div class="card-meta">
                    <span class="badge badge-rating">
                        ⭐ {{ $item['score'] }}
                    </span>
                </div>
            </div>
        </a>
    </div>
</div>
@endforeach
</div>