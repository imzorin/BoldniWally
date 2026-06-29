<div class="container mt-4">

    <a href="/search" class="btn btn-secondary mb-3">
        ← Back
    </a>

    <h1>
    {{ ucwords(str_replace('-', ' ', $anime['slug'])) }}
</h1>

    <p>
        Episodes:
        {{ count($episodes['episodes'] ?? []) }}
    </p>

    <hr>

    <div class="row">

        @foreach($episodes['episodes'] as $ep)

            <div class="col-md-3 mb-3">

                <div class="card h-100 shadow-sm">

                    <div class="card-body">

                        <h5>
                            Episode {{ $ep['episode_number'] }}
                        </h5>

                        <p>
                            {{ $ep['title'] }}
                        </p>
<a
    href="/kaa-watch/{{ $anime['slug'] }}/{{ $ep['slug'] }}"
    class="btn btn-success"
>
    ▶ Watch Episode
</a>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>