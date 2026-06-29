<!DOCTYPE html>
<html>
<head>
    <title>KAA Test Player</title>
</head>
<body>

<h1>KAA Test Player</h1>

<video controls width="100%" id="video"></video>

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

<script>
const video = document.getElementById('video');

if (Hls.isSupported()) {

    const hls = new Hls();

hls.loadSource('/proxy-master');

    hls.attachMedia(video);

    hls.on(Hls.Events.MANIFEST_PARSED, function () {
        video.play();
    });

} else {

    video.src = '{{ $manifest }}';

}
</script>

</body>
</html>