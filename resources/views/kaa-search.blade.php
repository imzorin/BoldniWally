<form method="POST" action="/kaa-search">
    @csrf

    <input
        type="text"
        name="query"
        placeholder="Search Anime">

    <button>
        Search
    </button>
</form>

@if(!empty($results))

    <hr>

    @foreach($results as $anime)

        <div>

            <h3>
                {{ $anime['title'] }}
            </h3>

            <a href="/kaa-anime/{{ $anime['slug'] }}">
                Open
            </a>

        </div>

    @endforeach

@endif