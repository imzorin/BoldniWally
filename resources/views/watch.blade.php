<!DOCTYPE html>
<html>
<head>
    <title>{{ $anime }} - {{ $episode }}</title>

    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
</head>
<body>

<h1>{{ $anime }}</h1>
<h3>{{ $episode }}</h3>

<video
    id="video"
    controls
    width="100%">
</video>

<script>

const video = document.getElementById('video');

const manifest = '{{ $manifest }}';

console.log('Manifest:', manifest);

if (Hls.isSupported()) {

    const hls = new Hls({
        debug: true
    });

    hls.on(Hls.Events.ERROR, function (event, data) {
        console.log('HLS ERROR:', data);
    });

    hls.on(Hls.Events.MANIFEST_LOADED, function () {
        console.log('MANIFEST LOADED');
    });

    hls.on(Hls.Events.MEDIA_ATTACHED, function () {
        console.log('MEDIA ATTACHED');
    });

    hls.attachMedia(video);

    hls.on(Hls.Events.MEDIA_ATTACHED, function () {
        hls.loadSource(manifest);
    });

} else {

    video.src = manifest;

}

</script>

</body>
</html>