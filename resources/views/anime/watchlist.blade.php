<!DOCTYPE html>
<html>
<head>

    <title>My Watchlist</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>
<body>

<div class="container mt-4">

    <a href="/" class="btn btn-secondary mb-4">
        Home
    </a>

    <h1 class="mb-4">
        My Watchlist
    </h1>

    @if($watchlist->isEmpty())

        <div class="alert alert-secondary">
            Your watchlist is empty.
        </div>

    @else

        <div class="row">

            @foreach($watchlist as $item)

                <div class="col-md-3 mb-4">

                    <div class="card h-100 shadow-sm">

                        <a href="/anime/{{ $item->anime_id }}">
                            <img
                                loading="lazy"
                                src="{{ $item->image }}"
                                class="card-img-top"
                                alt="{{ $item->title }}">
                        </a>

                        <div class="card-body">

                            <h6>
                                {{ $item->title }}
                            </h6>

                            <form
                                action="/watchlist/{{ $item->id }}"
                                method="POST"
                                class="mb-2">

                                @csrf
                                @method('PATCH')

                                <label class="form-label">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    class="form-select form-select-sm mb-2">

                                    @foreach(\App\Models\Watchlist::STATUSES as $status)

                                        <option
                                            value="{{ $status }}"
                                            @selected($item->status === $status)>

                                            {{ str_replace('_', ' ', ucfirst($status)) }}

                                        </option>

                                    @endforeach

                                </select>

                                <button class="btn btn-sm btn-primary">
                                    Update
                                </button>

                            </form>

                            <form
                                action="/watchlist/{{ $item->id }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger">
                                    Remove
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

</body>
</html>
