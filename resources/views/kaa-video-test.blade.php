<!DOCTYPE html>
<html>
<head>

    <title>KAA Video Test</title>

    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

</head>
<body>

<h1>Naruto Episode 1 Test</h1>

<video
    id="video"
    controls
    width="100%"
></video>

<script>

const video = document.getElementById('video');
const manifest = "/kaa/master/64d7164244c6d04c12f3fdbb/playlist.m3u8";

if (Hls.isSupported()) {

    const hls = new Hls();

    hls.loadSource(manifest);

    hls.attachMedia(video);

} else {

    video.src = manifest;

}

</script>

</body>
</html>