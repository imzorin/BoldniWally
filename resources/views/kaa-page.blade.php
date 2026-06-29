<h1>KAA Latest Update Test</h1>

<div style="
display:grid;
grid-template-columns:repeat(4,1fr);
gap:20px;
">

@foreach($anime as $item)

<div style="
border:1px solid #ddd;
padding:10px;
">

    <img
        src="https://kaa.lt/image/poster/{{ $item['poster']['hq'] ?? '' }}.webp"
        style="
        width:100%;
        height:250px;
        object-fit:cover;
        "
    >

    <h4>
        {{ $item['title'] ?? '' }}
    </h4>

    <p>
        Episode {{ $item['episode_number'] ?? '?' }}
    </p>

</div>

@endforeach

</div>

<div style="margin-top:30px">

@if($page > 1)
<a href="?page={{ $page - 1 }}">
    ← Prev
</a>
@endif

<span style="margin:0 20px">
    Page {{ $page }}
</span>

@if($hasNext)
<a href="?page={{ $page + 1 }}">
    Next →
</a>
@endif

</div>