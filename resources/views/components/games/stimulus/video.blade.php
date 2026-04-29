@props(['challenge', 'game'])

<div class="video-shell">
    @php 
        $youtubeId = $challenge->youtube_id ?? $challenge->stimulus_data['youtube_id'] ?? null;
        $uploadedVideo = $challenge->uploaded_video ?? $challenge->stimulus_data['uploaded_video'] ?? null;
        $startTime = $challenge->start_time ?? $challenge->stimulus_data['start_time'] ?? 0;
        $endTime = $challenge->end_time ?? $challenge->stimulus_data['end_time'] ?? 0;
    @endphp

    <div class="video-stage-meta">
        <span class="stimulus-tag">{{ __('Challenge Mode') }}</span>
        <strong>{{ $game->localized_title }}</strong>
    </div>
    
    <div class="video-box {{ $game->slug === 'black-and-white' ? 'bw-mode' : '' }}">
        <div class="video-frame"></div>
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

    <div class="video-footer-note">
        {{ __('Watch a short video ad to unlock the next clue for this challenge.') }}
    </div>
</div>

<style>
    .video-shell {
        display: grid;
        gap: 0.9rem;
    }

    .video-stage-meta {
        display: grid;
        gap: 0.35rem;
        padding-inline: 0.2rem;
    }

    .stimulus-tag {
        display: inline-flex;
        width: fit-content;
        padding: 0.42rem 0.75rem;
        border-radius: 999px;
        background: rgba(var(--surface-rgb), 0.75);
        border: 1px solid var(--border-soft);
        color: var(--text-soft);
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        backdrop-filter: blur(10px);
    }

    .video-stage-meta strong {
        color: var(--text);
        font-family: var(--font-display);
        font-size: clamp(1.05rem, 2vw, 1.35rem);
        line-height: 1.1;
        letter-spacing: -0.03em;
    }

    .video-box {
        background:
            radial-gradient(circle at top right, rgba(59, 130, 246, 0.18), transparent 24%),
            #000;
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-soft);
        border-radius: 28px;
        overflow: hidden;
        position: relative;
        width: 100%;
        padding-bottom: 56.25%;
        height: 0;
        transition: 0.2s ease;
    }

    .video-frame {
        position: absolute;
        inset: 0.8rem;
        border-radius: 22px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        pointer-events: none;
        z-index: 2;
    }

    .video-container { position: absolute; top: 0.8rem; left: 0.8rem; width: calc(100% - 1.6rem); height: calc(100% - 1.6rem); overflow: hidden; border-radius: 22px; }
    .bw-mode #player, .bw-mode video, .bw-mode iframe {
        filter: grayscale(100%) contrast(300%) brightness(1.2);
    }
    #player, .video-container iframe, .video-container video {
        display: block; position: absolute; top: -15%; left: -10%; width: 120%; height: 130%; pointer-events: none;
    }

    .video-footer-note {
        color: var(--text-soft);
        font-size: 0.88rem;
        font-weight: 600;
        line-height: 1.5;
        padding-inline: 0.2rem;
    }

    @media (max-width: 640px) {
        .video-container {
            top: 0.65rem;
            left: 0.65rem;
            width: calc(100% - 1.3rem);
            height: calc(100% - 1.3rem);
        }

        .video-frame {
            inset: 0.65rem;
        }
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
