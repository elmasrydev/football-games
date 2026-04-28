@props(['challenge', 'game'])

<div class="video-box {{ $game->slug === 'black-and-white' ? 'bw-mode' : '' }}">
    @php 
        $youtubeId = $challenge->youtube_id ?? $challenge->stimulus_data['youtube_id'] ?? null;
        $uploadedVideo = $challenge->uploaded_video ?? $challenge->stimulus_data['uploaded_video'] ?? null;
        $startTime = $challenge->start_time ?? $challenge->stimulus_data['start_time'] ?? 0;
        $endTime = $challenge->end_time ?? $challenge->stimulus_data['end_time'] ?? 0;
    @endphp
    
    @if($youtubeId)
        <div class="video-container">
            <div id="player"></div>
        </div>
    @elseif($uploadedVideo)
        <div class="video-container">
            <video id="local-video" width="100%" height="auto" autoplay muted loop playsinline>
                <source src="{{ asset('storage/' . $uploadedVideo) }}" type="video/mp4">
            </video>
        </div>
    @endif
</div>

<style>
    .video-box {
        background: #000; border: 1px solid var(--glass-border);
        box-shadow: var(--shadow); border-radius: 24px; overflow: hidden;
        position: relative; width: 100%; padding-bottom: 56.25%; height: 0;
        transition: var(--transition); margin-bottom: 1rem;
    }
    .video-container { position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; }
    .bw-mode #player, .bw-mode video, .bw-mode iframe {
        filter: grayscale(100%) contrast(300%) brightness(1.2);
    }
    #player, .video-container iframe, .video-container video {
        display: block; position: absolute; top: -15%; left: -10%; width: 120%; height: 130%; pointer-events: none;
    }
</style>

<script>
    (function() {
        function parseTime(timeStr) {
            if (!timeStr) return 0;
            if (!isNaN(timeStr)) return parseFloat(timeStr);
            const parts = timeStr.split(':');
            if (parts.length === 2) return parseInt(parts[0]) * 60 + parseInt(parts[1]);
            return 0;
        }

        const startTime = parseTime("{{ $startTime }}");
        const endTime = parseTime("{{ $endTime }}");
        const youtubeId = "{{ $youtubeId }}";

        if (youtubeId) {
            if (!window.YT) {
                const tag = document.createElement('script');
                tag.src = "https://www.youtube.com/iframe_api";
                const firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            }

            let player;
            window.onYouTubeIframeAPIReady = function () {
                player = new YT.Player('player', {
                    host: 'https://www.youtube-nocookie.com',
                    height: '100%', width: '100%', videoId: youtubeId,
                    playerVars: {
                        'autoplay': 1, 'controls': 0, 'mute': 1, 'modestbranding': 1,
                        'rel': 0, 'iv_load_policy': 3, 'disablekb': 1,
                        'start': startTime, 'end': endTime > 0 ? endTime : undefined,
                    },
                    events: {
                        'onReady': (event) => {
                            event.target.playVideo();
                            setInterval(() => {
                                if (endTime > 0 && player.getCurrentTime() >= endTime) {
                                    player.seekTo(startTime);
                                }
                            }, 500);
                        },
                        'onStateChange': (event) => {
                            if (event.data === YT.PlayerState.ENDED) {
                                player.seekTo(startTime);
                                player.playVideo();
                            }
                        }
                    }
                });
            }
        }

        const localVideo = document.getElementById('local-video');
        if (localVideo) {
            localVideo.currentTime = startTime;
            localVideo.addEventListener('timeupdate', function () {
                if (endTime > 0 && this.currentTime >= endTime) {
                    this.currentTime = startTime;
                }
            });
        }
    })();
</script>
