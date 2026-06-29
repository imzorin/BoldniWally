<!DOCTYPE html>
<html>
<head>

    <title>My Favorites</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>
<body>

<div class="container mt-4">

    <a href="/" class="btn btn-secondary mb-4">
        ← Home
    </a>

    <h1 class="mb-4">
        ❤️ My Favorites
    </h1>

    <div class="row">

        @foreach($favorites as $favorite)

            <div class="col-md-2 mb-4">

                <div class="card h-100 shadow-sm">

                    <img
                        loading="lazy"
                        src="{{ $favorite->image }}"
                        class="card-img-top">

                    <div class="card-body">

                        <h6>
                            {{ $favorite->title }}
                        </h6>
<form
    action="/favorites/{{ $favorite->id }}"
    method="POST">

    @csrf
    @method('DELETE')

    <button
        class="btn btn-sm btn-danger mt-2">

        Remove

    </button>

</form>
                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>

</body>
</html>