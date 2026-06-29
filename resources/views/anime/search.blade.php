<!DOCTYPE html>
<html>
<head>

    <title>Search Results</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>
<body>

<div class="container mt-4">

    <a href="/" class="btn btn-secondary mb-4">
        ← Back
    </a>

    <h2 class="mb-4">
        Results for "{{ $query }}"
    </h2>

    <div class="row">

        @forelse($results as $anime)

            <div class="col-md-2 mb-4">

                <a href="/anime/{{ $anime['mal_id'] }}"
                   class="text-decoration-none text-dark">

                    <div class="card h-100">

                        <img
                            src="{{ $anime['images']['jpg']['image_url'] }}"
                            class="card-img-top">

                        <div class="card-body">

                            <h6>
                                {{ $anime['title'] }}
                            </h6>

                        </div>

                    </div>

                </a>

            </div>

        @empty

            <h4>No results found.</h4>

        @endforelse

    </div>

</div>

</body>
</html>