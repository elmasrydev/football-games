@extends('layouts.app')

@section('content')
    <div class="container play-container">
        <div class="video-section">
            <div class="trophy-video">
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
                <a href="{{ route('games.trophy.play') }}" class="btn btn-outline" title="Get another trophy moment">
                    <span>Try Another Trophy</span>
                </a>
            </div>
        </div>

        <div class="interaction-section">
            <div class="question-card">
                <div class="question-header">
                    <h3>🏆 Trophy Hunter</h3>
                </div>
                <div class="question-body">
                    <p>{{ $video->question }}</p>
                    <small>(e.g., "Champions League 2005" or "World Cup 2010")</small>
                </div>

                <x-player-answer-form placeholder="Competition & Year..." />

                <div id="feedback" class="feedback"></div>
            </div>

            <div class="hints-section">
                <button id="hint-btn" class="btn btn-outline hint-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 18v-3m0 0a8.1 8.1 0 0 0 4.5-1.55c3.3-2.45 3.3-6.45 0-8.9A8.1 8.1 0 0 0 12 3a8.1 8.1 0 0 0-4.5 1.55c-3.3 2.45-3.3 6.45 0 8.9A8.1 8.1 0 0 0 12 15Zm0 3v2m0 0h-3m3 0h3" />
                    </svg>
                    <span>Need a Hint?</span>
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

            .trophy-video {
                border-radius: 24px;
                overflow: hidden;
                box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
                background: #000;
                position: relative;
                width: 100%;
                padding-bottom: 56.25%;
                height: 0;
                border: 3px solid #ffd700;
                transition: var(--transition);
            }

            .trophy-video:hover {
                box-shadow: 0 16px 48px rgba(255, 215, 0, 0.3);
            }

            /* B&W Silhouette filter */
            .trophy-video iframe,
            .trophy-video video {
                display: block;
                position: absolute;
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
                background: linear-gradient(135deg, #fffef0, #fff9e6);
                border-radius: 20px;
                border: 2px solid #ffd700;
                box-shadow: 0 8px 32px rgba(255, 215, 0, 0.15);
                padding: 2rem;
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
                transition: var(--transition);
            }

            .question-header h3 {
                font-family: 'Outfit', sans-serif;
                font-size: 1rem;
                text-transform: uppercase;
                letter-spacing: 2px;
                color: #b8860b;
                margin-bottom: 0.25rem;
            }

            .question-body p {
                font-family: 'Outfit', sans-serif;
                font-size: 1.4rem;
                font-weight: 700;
                color: var(--pitch-dark);
                line-height: 1.3;
            }

            .question-body small {
                color: var(--text-dim);
                display: block;
                margin-top: 0.5rem;
            }

            .answer-form input:focus {
                outline: none;
                border-color: #b8860b;
                background: #fff;
                box-shadow: 0 0 12px rgba(255, 215, 0, 0.3);
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
                color: #000;
                background: linear-gradient(135deg, #ffd700, #ffec8b);
                box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
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
                border-color: #ffd700;
                color: #b8860b;
            }

            #hint-btn:hover {
                background: #ffd700;
                color: #000;
            }

            .hints-display {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .hint-item {
                background: #fffef5;
                padding: 1rem;
                border-radius: 12px;
                border-left: 4px solid #ffd700;
                border-right: 1px solid #ffd700;
                border-top: 1px solid #ffd700;
                border-bottom: 1px solid #ffd700;
                box-shadow: 0 4px 12px rgba(255, 215, 0, 0.1);
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

            document.getElementById('answer-input').addEventListener('input', function () {
                const feedback = document.getElementById('feedback');
                feedback.className = 'feedback';
                feedback.innerText = '';
            });
            document.getElementById('give-up-btn').addEventListener('click', revealAnswer);
            document.getElementById('clear-btn').addEventListener('click', () => clearAutocomplete('answer-input', 'autocomplete-list'));
            document.getElementById('hint-btn').addEventListener('click', () => {
                openHintModal(getHint);
            });

            // YouTube IFrame API
            if (youtubeId) {
                const tag = document.createElement('script');
                tag.src = "https://www.youtube-nocookie.com/iframe_api";
                const firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                let player;
                window.onYouTubeIframeAPIReady = function () {
                    player = new YT.Player('player', {
                        host: 'https://www.youtube-nocookie.com',
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
                            'vq': 'small'
                        },
                        events: {
                            'onReady': onPlayerReady,
                            'onStateChange': onPlayerStateChange
                        }
                    });
                }

                function onPlayerReady(event) {
                    event.target.setPlaybackQuality('small');
                    event.target.playVideo();
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

            async function checkAnswer() {
                const answer = document.getElementById('answer-input').value;
                const feedback = document.getElementById('feedback');

                if (!answer.trim()) return;

                try {
                    const response = await fetch(`/trophies/${videoId}/check`, {
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
                        document.getElementById('give-up-btn').disabled = true;
                        document.getElementById('clear-btn').disabled = true;
                        document.getElementById('answer-input').disabled = true;
                        document.querySelector('.question-card').style.borderColor = '#ffd700';
                        document.querySelector('.question-card').style.boxShadow = '0 0 30px rgba(255, 215, 0, 0.5)';
                    }
                } catch (error) {
                    console.error('Error checking answer:', error);
                }
            }

            async function revealAnswer() {
                if (!confirm('Are you sure you want to Give Up and reveal the answer?')) return;

                const response = await fetch(`/trophies/${videoId}/reveal`);
                const data = await response.json();

                const feedback = document.getElementById('feedback');
                feedback.innerText = `The answer was: ${data.answer}`;
                feedback.className = 'feedback success';
                document.getElementById('answer-input').value = data.answer;

                document.getElementById('submit-btn').disabled = true;
                document.getElementById('give-up-btn').disabled = true;
                document.getElementById('clear-btn').disabled = true;
                document.getElementById('answer-input').disabled = true;

                document.querySelector('.question-card').style.borderColor = '#ffd700';
                document.querySelector('.question-card').style.boxShadow = '0 0 30px rgba(255, 215, 0, 0.5)';
            }

            async function getHint() {
                try {
                    const response = await fetch(`/trophies/${videoId}/hint`, {
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

            if (!window.location.pathname.endsWith('/' + videoId)) {
                const shareableUrl = "/games/trophy-hunter/" + videoId;
                window.history.replaceState({ path: shareableUrl }, '', shareableUrl);
            }
        </script>
    @endpush
@endsection