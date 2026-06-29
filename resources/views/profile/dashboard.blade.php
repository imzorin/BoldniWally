<!DOCTYPE html>
<html>
<head>

    <title>Profile Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>
<body>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="mb-0">
            Profile Dashboard
        </h1>

        <a href="/" class="btn btn-secondary">
            Home
        </a>

    </div>

    <div class="card mb-4">

        <div class="card-body">

            <h2 class="h4">
                {{ $user->name }}
            </h2>

            <p class="mb-1">
                <strong>Email:</strong> {{ $user->email }}
            </p>

            <p class="mb-0">
                <strong>Join Date:</strong> {{ $user->created_at?->format('F j, Y') ?? 'Unknown' }}
            </p>

        </div>

    </div>

    <div class="row mb-4">

        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="h6 text-muted">Favorites</h3>
                    <p class="display-6 mb-0">{{ $favoritesCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="h6 text-muted">Reviews</h3>
                    <p class="display-6 mb-0">{{ $reviewsCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="h6 text-muted">Watchlist</h3>
                    <p class="display-6 mb-0">{{ $watchlistCount }}</p>
                </div>
            </div>
        </div>

    </div>

    <div class="card mb-4">

        <div class="card-body">

            <h2 class="h4 mb-3">
                Watchlist Breakdown
            </h2>

            <div class="row">

                <div class="col-md-3 mb-2">
                    <strong>Plan To Watch:</strong> {{ $watchlistBreakdown['plan_to_watch'] }}
                </div>

                <div class="col-md-3 mb-2">
                    <strong>Watching:</strong> {{ $watchlistBreakdown['watching'] }}
                </div>

                <div class="col-md-3 mb-2">
                    <strong>Completed:</strong> {{ $watchlistBreakdown['completed'] }}
                </div>

                <div class="col-md-3 mb-2">
                    <strong>Dropped:</strong> {{ $watchlistBreakdown['dropped'] }}
                </div>

            </div>

        </div>

    </div>

    <div class="card mb-4">

        <div class="card-body">

            <h2 class="h4 mb-3">
                Latest Reviews
            </h2>

            @forelse($recentReviews as $review)

                <div class="border-bottom pb-3 mb-3">
                    <h3 class="h6 mb-1">
                        {{ $review->anime_title }}
                    </h3>

                    <p class="mb-1">
                        Rating: {{ $review->rating }}/5
                    </p>

                    <p class="mb-0">
                        {{ $review->review }}
                    </p>
                </div>

            @empty

                <p class="mb-0 text-muted">
                    No reviews yet.
                </p>

            @endforelse

        </div>

    </div>

    <div class="card mb-4">

        <div class="card-body">

            <h2 class="h4 mb-3">
                Recent Favorites
            </h2>

            <div class="row">

                @forelse($recentFavorites as $favorite)

                    <div class="col-md-2 mb-3">
                        <a href="/anime/{{ $favorite->anime_id }}" class="text-decoration-none text-dark">
                            <img
                                src="{{ $favorite->image }}"
                                class="img-fluid rounded mb-2"
                                alt="{{ $favorite->title }}">
                            <small>{{ $favorite->title }}</small>
                        </a>
                    </div>

                @empty

                    <p class="mb-0 text-muted">
                        No favorites yet.
                    </p>

                @endforelse

            </div>

        </div>

    </div>

    <div class="card mb-4">

        <div class="card-body">

            <h2 class="h4 mb-3">
                Recent Watchlist Entries
            </h2>

            <div class="row">

                @forelse($recentWatchlist as $item)

                    <div class="col-md-2 mb-3">
                        <a href="/anime/{{ $item->anime_id }}" class="text-decoration-none text-dark">
                            <img
                                src="{{ $item->image }}"
                                class="img-fluid rounded mb-2"
                                alt="{{ $item->title }}">
                            <small class="d-block">{{ $item->title }}</small>
                            <small class="text-muted">
                                {{ str_replace('_', ' ', ucfirst($item->status)) }}
                            </small>
                        </a>
                    </div>

                @empty

                    <p class="mb-0 text-muted">
                        No watchlist entries yet.
                    </p>

                @endforelse

            </div>

        </div>

    </div>

</div>

</body>
</html>
