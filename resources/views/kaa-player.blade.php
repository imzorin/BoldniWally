<h1>KAA Player</h1>

<video id="video" controls width="100%"></video>

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

<script>
const video = document.getElementById('video');

if (Hls.isSupported()) {

    const hls = new Hls();

    hls.loadSource('/proxy-master');

    hls.attachMedia(video);
}
</script>