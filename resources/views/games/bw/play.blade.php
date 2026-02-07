@extends('layouts.app')

@section('content')
    <div class="container play-container">
        <div class="video-section">
            <div class="bw-video">
                @if($video->youtube_id)
                    <div id="player"></div>
                @elseif($video->uploaded_video)
                    <video id="local-video" width="100%" height="450" autoplay muted loop>
                        <source src="{{ asset('storage/' . $video->uploaded_video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
            </div>

            <div class="controls">
                <a href="{{ route('games.bw.play', $game) }}" class="btn btn-outline" title="Get another random video">
                    <span>Try Another Video</span>
                </a>
            </div>
        </div>

        <div class="interaction-section">
            <div class="question-card">
                <div class="question-header">
                    <h3>The Question</h3>
                </div>
                <div class="question-body">
                    <p>{{ $video->question }}</p>
                </div>

                <div class="answer-form">
                    <div class="autocomplete-wrapper">
                        <input type="text" id="answer-input" placeholder="Write your answer here..." autocomplete="off">
                        <div id="autocomplete-list" class="autocomplete-items"></div>
                    </div>
                    <button id="submit-btn" class="btn btn-primary">Check Answer</button>
                    <button id="reveal-btn" class="btn btn-outline" style="border-color: #ef4444; color: #ef4444;">Reveal
                        Answer</button>
                </div>

                <div id="feedback" class="feedback"></div>
            </div>

            <div class="hints-section">
                <button id="hint-btn" class="btn btn-outline">
                    <span>Get a Hint</span>
                </button>
                <div id="hints-display" class="hints-display">
                    <!-- Hints will appear here -->
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .play-container {
                display: flex;
                flex-direction: column;
                gap: 2rem;
            }

            .video-section {
                width: 100%;
            }

            .bw-video {
                border-radius: 24px;
                overflow: hidden;
                box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
                background: #000;
                position: relative;
                width: 100%;
                /* 16:9 Aspect Ratio */
                padding-bottom: 56.25%;
                height: 0;
                border: 1px solid var(--glass-border);
                transition: var(--transition);
            }

            .bw-video:hover {
                box-shadow: 0 16px 48px rgba(0, 0, 0, 0.2);
            }

            /* Silhouette filter from user requirement */
            .bw-video iframe,
            .bw-video video {
                display: block;
                position: absolute;
                /* Scale and offset to clip out YouTube UI (title, logo, etc.) */
                top: -15%;
                left: -10%;
                width: 120%;
                height: 130%;

                filter: grayscale(100%) contrast(500%) brightness(1.1);
                vertical-align: middle;
                pointer-events: none;
            }

            .interaction-section {
                display: grid;
                grid-template-columns: 1.5fr 1fr;
                gap: 2.5rem;
                align-items: start;
            }

            .question-card {
                background: white;
                border-radius: 20px;
                border: 1px solid var(--glass-border);
                box-shadow: var(--shadow);
                padding: 2rem;
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
                transition: var(--transition);
            }

            .question-header h3 {
                font-family: 'Outfit', sans-serif;
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 2px;
                color: var(--stadium-green);
                margin-bottom: 0.25rem;
            }

            .question-body p {
                font-family: 'Outfit', sans-serif;
                font-size: 1.4rem;
                font-weight: 700;
                color: var(--pitch-dark);
                line-height: 1.3;
            }

            .answer-form {
                display: flex;
                gap: 0.75rem;
                flex-wrap: wrap;
            }

            .answer-form input {
                flex: 1;
                min-width: 200px;
                padding: 1rem;
                background: #f8faf9;
                border: 1px solid var(--glass-border);
                border-radius: 10px;
                font-size: 1rem;
                color: var(--text-main);
                font-family: inherit;
                transition: var(--transition);
            }

            .answer-form input:focus {
                outline: none;
                border-color: var(--stadium-green);
                background: #fff;
                box-shadow: 0 0 12px rgba(63, 185, 80, 0.1);
            }

            .feedback {
                min-height: 1.5rem;
                font-weight: 700;
                padding: 0.75rem;
                border-radius: 10px;
                display: none;
                text-align: center;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                font-size: 0.85rem;
                animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }

            @keyframes popIn {
                0% {
                    transform: scale(0.95);
                    opacity: 0;
                }

                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            .feedback.success {
                display: block;
                color: #fff;
                background: linear-gradient(135deg, #2ea043, #238636);
                box-shadow: 0 4px 12px rgba(46, 160, 67, 0.2);
            }

            .feedback.error {
                display: block;
                color: #fff;
                background: linear-gradient(135deg, #da3633, #b62324);
                box-shadow: 0 4px 12px rgba(218, 54, 51, 0.2);
            }

            .hints-section {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            #hint-btn {
                width: 100%;
                padding: 1rem;
            }

            .hints-display {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .hint-item {
                background: white;
                padding: 1rem;
                border-radius: 12px;
                border-left: 4px solid var(--stadium-green);
                border-right: 1px solid var(--glass-border);
                border-top: 1px solid var(--glass-border);
                border-bottom: 1px solid var(--glass-border);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
                animation: slideIn 0.3s ease-out;
                font-size: 0.9rem;
                color: var(--text-main);
            }

            .controls {
                margin-top: 1rem;
                display: flex;
                justify-content: center;
            }

            @keyframes slideIn {
                from {
                    transform: translateY(5px);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            @media (max-width: 900px) {
                .interaction-section {
                    grid-template-columns: 1fr;
                }

                .question-body p {
                    font-size: 1.25rem;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            const videoId = {{ $video->id }};
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const shownHints = [];

            // Conditionally initialize global autocomplete for player-centric games
            const playerCentricGames = ['celebration-station', 'trophy-hunter', 'black-and-white'];
            if (playerCentricGames.includes('{{ $game->slug }}')) {
                initAutocomplete('answer-input', 'autocomplete-list', '{{ route('career.players.search') }}');
            }

            function parseTime(timeStr) {
                if (!timeStr) return 0;
                if (!isNaN(timeStr)) return parseFloat(timeStr);

                const parts = timeStr.split(':');
                if (parts.length === 2) {
                    return parseInt(parts[0]) * 60 + parseInt(parts[1]);
                }
                return 0;
            }

            const startTime = parseTime("{{ $video->start_time }}");
            const endTime = parseTime("{{ $video->end_time }}");
            const youtubeId = "{{ $video->youtube_id }}";

            document.getElementById('submit-btn').addEventListener('click', checkAnswer);
            document.getElementById('answer-input').addEventListener('keypress', function (e) {
                if (e.key === 'Enter') checkAnswer();
            });
            document.getElementById('reveal-btn').addEventListener('click', revealAnswer);
            document.getElementById('hint-btn').addEventListener('click', getHint);

            // YouTube IFrame API
            if (youtubeId) {
                const tag = document.createElement('script');
                tag.src = "https://www.youtube.com/iframe_api";
                const firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                let player;
                window.onYouTubeIframeAPIReady = function () {
                    player = new YT.Player('player', {
                        height: '450',
                        width: '100%',
                        videoId: youtubeId,
                        playerVars: {
                            'autoplay': 1,
                            'controls': 0,
                            'mute': 1,
                            'modestbranding': 1,
                            'rel': 0,
                            'iv_load_policy': 3,
                            'disablekb': 1,
                            'start': startTime,
                            'end': endTime > 0 ? endTime : undefined,
                            'vq': 'small' // Hint for low quality
                        },
                        events: {
                            'onReady': onPlayerReady,
                            'onStateChange': onPlayerStateChange
                        }
                    });
                }

                function onPlayerReady(event) {
                    // Force small quality (360p)
                    event.target.setPlaybackQuality('small');
                    event.target.playVideo();

                    // Interval to check for end time and loop
                    setInterval(() => {
                        const currentTime = player.getCurrentTime();
                        if (endTime > 0 && currentTime >= endTime) {
                            player.seekTo(startTime);
                        }
                    }, 500);
                }

                function onPlayerStateChange(event) {
                    if (event.data === YT.PlayerState.ENDED) {
                        player.seekTo(startTime);
                        player.playVideo();
                    }
                }
            }

            // Local Video Looping
            const localVideo = document.getElementById('local-video');
            if (localVideo) {
                localVideo.currentTime = startTime;
                localVideo.addEventListener('timeupdate', function () {
                    if (endTime > 0 && this.currentTime >= endTime) {
                        this.currentTime = startTime;
                    }
                });
            }

            async function checkAnswer() {
                const answer = document.getElementById('answer-input').value;
                const feedback = document.getElementById('feedback');

                if (!answer.trim()) return;

                try {
                    const response = await fetch(`/videos/${videoId}/check`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ answer })
                    });

                    const data = await response.json();

                    feedback.innerText = data.message;
                    feedback.className = 'feedback ' + (data.correct ? 'success' : 'error');

                    if (data.correct) {
                        document.getElementById('submit-btn').disabled = true;
                        document.getElementById('reveal-btn').disabled = true;
                        document.getElementById('answer-input').disabled = true;
                        highlightSuccess();
                    }
                } catch (error) {
                    console.error('Error checking answer:', error);
                }
            }

            async function revealAnswer() {
                if (!confirm('Are you sure you want to reveal the answer?')) return;

                const response = await fetch(`/videos/${videoId}/reveal`);
                const data = await response.json();

                const feedback = document.getElementById('feedback');
                feedback.innerText = `The answer was: ${data.answer}`;
                feedback.className = 'feedback success';
                document.getElementById('answer-input').value = data.answer;

                document.getElementById('submit-btn').disabled = true;
                document.getElementById('reveal-btn').disabled = true;
                document.getElementById('answer-input').disabled = true;
                highlightSuccess();
            }

            function highlightSuccess() {
                document.querySelector('.question-card').style.borderColor = '#27ae60';
                document.querySelector('.question-card').style.borderStyle = 'solid';
                document.querySelector('.question-card').style.borderWidth = '2px';
            }

            async function getHint() {
                try {
                    const response = await fetch(`/videos/${videoId}/hint`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ shown_hints: shownHints })
                    });

                    const data = await response.json();

                    if (data.hint) {
                        shownHints.push(data.id);
                        const hintDiv = document.createElement('div');
                        hintDiv.className = 'hint-item';
                        hintDiv.innerHTML = `<strong>Hint ${shownHints.length}:</strong> ${data.hint}`;
                        document.getElementById('hints-display').appendChild(hintDiv);
                    } else {
                        alert(data.message);
                        document.getElementById('hint-btn').disabled = true;
                    }
                } catch (error) {
                    console.error('Error getting hint:', error);
                }
            }

            // Update URL to be shareable if it's currently just the general game URL
            if (!window.location.pathname.endsWith('/' + videoId)) {
                const shareableUrl = "{{ route('games.bw.play', ['game' => $game, 'video' => $video]) }}";
                window.history.replaceState({ path: shareableUrl }, '', shareableUrl);
            }
        </script>
    @endpush
@endsection