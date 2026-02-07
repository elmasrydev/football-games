@extends('layouts.app')

@section('content')
    <div class="container play-container">
        <div class="silhouette-section">
            <div class="silhouette-image-container">
                <img id="silhouette-image" src="{{ asset('storage/' . $challenge->image_path) }}"
                    alt="Mystery Player Silhouette" class="silhouette-display">
                <div id="correct-overlay" class="correct-overlay">
                    <span class="correct-text">🎯 CORRECT!</span>
                </div>
            </div>

            <div class="silhouette-description">
                <span class="difficulty-badge {{ $challenge->difficulty }}">
                    {{ ucfirst($challenge->difficulty) }}
                </span>
                <p>Who is this legendary player?</p>
            </div>

            <div class="controls">
                <a href="{{ route('games.silhouette.play') }}" class="btn btn-outline" title="Get another silhouette">
                    <span>Try Another Player</span>
                </a>
            </div>
        </div>

        <div class="interaction-section">
            <div class="question-card">
                <div class="question-header">
                    <h3>🔍 Guess the Player</h3>
                </div>
                <div class="question-body">
                    <p>Name this football legend</p>
                    <small>Look at the pose, the stance, the silhouette...</small>
                </div>

                <div class="answer-form">
                    <div class="autocomplete-wrapper">
                        <input type="text" id="answer-input" placeholder="Player name..." autocomplete="off">
                        <div id="autocomplete-list" class="autocomplete-items"></div>
                    </div>
                    <button id="submit-btn" class="btn btn-primary">Guess</button>
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

            .silhouette-section {
                width: 100%;
                text-align: center;
            }

            .silhouette-image-container {
                position: relative;
                border-radius: 24px;
                overflow: hidden;
                box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
                background: linear-gradient(135deg, #1a1a2e, #16213e);
                border: 3px solid #4a4a6a;
                max-width: 500px;
                margin: 0 auto;
                aspect-ratio: 1;
                transition: var(--transition);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .silhouette-image-container:hover {
                box-shadow: 0 16px 48px rgba(0, 0, 0, 0.3);
                transform: translateY(-4px);
            }

            .silhouette-display {
                max-width: 90%;
                max-height: 90%;
                object-fit: contain;
                transition: all 0.5s ease;
            }

            .correct-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(46, 160, 67, 0.3);
                display: none;
                align-items: center;
                justify-content: center;
                z-index: 10;
                pointer-events: none;
            }

            .correct-text {
                color: white;
                font-family: 'Outfit', sans-serif;
                font-weight: 900;
                font-size: 2.5rem;
                text-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
                letter-spacing: 4px;
                animation: pulse 0.5s ease-in-out infinite alternate;
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                }

                100% {
                    transform: scale(1.05);
                }
            }

            .silhouette-description {
                margin-top: 1.5rem;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
            }

            .silhouette-description p {
                color: var(--text-dim);
                font-size: 1rem;
            }

            .difficulty-badge {
                padding: 0.3rem 0.75rem;
                border-radius: 12px;
                font-size: 0.7rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .difficulty-badge.easy {
                background: #d4edda;
                color: #155724;
            }

            .difficulty-badge.medium {
                background: #fff3cd;
                color: #856404;
            }

            .difficulty-badge.hard {
                background: #f8d7da;
                color: #721c24;
            }

            .interaction-section {
                display: grid;
                grid-template-columns: 1.5fr 1fr;
                gap: 2.5rem;
                align-items: start;
            }

            .question-card {
                background: linear-gradient(135deg, #1a1a2e, #16213e);
                border-radius: 20px;
                border: 2px solid #4a4a6a;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
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
                color: #9ca3af;
                margin: 0;
            }

            .question-body p {
                font-family: 'Outfit', sans-serif;
                font-size: 1.4rem;
                font-weight: 700;
                color: #fff;
                line-height: 1.3;
                margin-bottom: 0.25rem;
            }

            .question-body small {
                color: #6b7280;
                display: block;
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
                background: #0f0f23;
                border: 1px solid #4a4a6a;
                border-radius: 10px;
                font-size: 1rem;
                color: #fff;
                font-family: inherit;
                transition: var(--transition);
            }

            .answer-form input:focus {
                outline: none;
                border-color: var(--stadium-green);
                background: #1a1a2e;
                box-shadow: 0 0 12px rgba(63, 185, 80, 0.2);
            }

            .answer-form input::placeholder {
                color: #6b7280;
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
                box-shadow: 0 4px 12px rgba(46, 160, 67, 0.3);
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
                border-color: #4a4a6a;
                color: #9ca3af;
                background: #1a1a2e;
            }

            #hint-btn:hover {
                background: #4a4a6a;
                color: #fff;
            }

            .hints-display {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .hint-item {
                background: #1a1a2e;
                padding: 1rem;
                border-radius: 12px;
                border-left: 4px solid var(--stadium-green);
                border-right: 1px solid #4a4a6a;
                border-top: 1px solid #4a4a6a;
                border-bottom: 1px solid #4a4a6a;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                animation: slideIn 0.3s ease-out;
                font-size: 0.9rem;
                color: #d1d5db;
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

                .silhouette-image-container {
                    max-width: 100%;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            const challengeId = {{ $challenge->id }};
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const shownHints = [];

            // Initialize global autocomplete
            initAutocomplete('answer-input', 'autocomplete-list', '{{ route('career.players.search') }}');

            document.getElementById('submit-btn').addEventListener('click', checkAnswer);
            document.getElementById('answer-input').addEventListener('keypress', function (e) {
                if (e.key === 'Enter') checkAnswer();
            });
            document.getElementById('reveal-btn').addEventListener('click', revealAnswer);
            document.getElementById('hint-btn').addEventListener('click', getHint);

            async function checkAnswer() {
                const answer = document.getElementById('answer-input').value;
                const feedback = document.getElementById('feedback');
                const silhouetteImage = document.getElementById('silhouette-image');
                const overlay = document.getElementById('correct-overlay');

                if (!answer.trim()) return;

                try {
                    const response = await fetch(`/silhouettes/${challengeId}/check`, {
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

                        // Reveal full image if available
                        if (data.reveal_image) {
                            silhouetteImage.src = data.reveal_image;
                        }
                        overlay.style.display = 'flex';

                        highlightSuccess();
                    }
                } catch (error) {
                    console.error('Error checking answer:', error);
                }
            }

            async function revealAnswer() {
                if (!confirm('Are you sure you want to reveal the answer?')) return;

                const response = await fetch(`/silhouettes/${challengeId}/reveal`);
                const data = await response.json();

                const feedback = document.getElementById('feedback');
                feedback.innerText = `The answer was: ${data.answer}`;
                feedback.className = 'feedback success';
                document.getElementById('answer-input').value = data.answer;

                const silhouetteImage = document.getElementById('silhouette-image');
                const overlay = document.getElementById('correct-overlay');

                if (data.reveal_image) {
                    silhouetteImage.src = data.reveal_image;
                }
                overlay.style.display = 'flex';

                document.getElementById('submit-btn').disabled = true;
                document.getElementById('reveal-btn').disabled = true;
                document.getElementById('answer-input').disabled = true;
                highlightSuccess();
            }

            function highlightSuccess() {
                document.querySelector('.question-card').style.borderColor = '#2ea043';
                document.querySelector('.silhouette-image-container').style.borderColor = '#2ea043';
                document.querySelector('.question-card').style.borderStyle = 'solid';
                document.querySelector('.question-card').style.borderWidth = '2px';
            }

            async function getHint() {
                try {
                    const response = await fetch(`/silhouettes/${challengeId}/hint`, {
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

            if (!window.location.pathname.endsWith('/' + challengeId)) {
                const shareableUrl = "/games/guess-silhouette/" + challengeId;
                window.history.replaceState({ path: shareableUrl }, '', shareableUrl);
            }
        </script>
    @endpush
@endsection