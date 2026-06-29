<!DOCTYPE html>
<html>
<head>

    <title>{{ ucfirst($genre) }} Anime</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>
<body>

<div class="container mt-4">

    <a href="/" class="btn btn-secondary mb-4">
        ← Home
    </a>

    <h1 class="mb-4">
        🎭 {{ ucfirst($genre) }} Anime
    </h1>

    <div class="row">

        @foreach($anime as $item)

            <div class="col-md-2 mb-4">

                <a href="/anime/{{ $item['mal_id'] }}"
                   class="text-decoration-none text-dark">

                    <div class="card h-100 shadow-sm">

                        <img
                            loading="lazy"
                            src="{{ $item['images']['jpg']['image_url'] }}"
                            class="card-img-top">

                        <div class="card-body">

                            <h6>
                                {{ $item['title'] }}
                            </h6>

                        </div>

                    </div>

                </a>

            </div>

        @endforeach

    </div>

</div>

</body>
</html>