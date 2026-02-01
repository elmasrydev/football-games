@extends('layouts.app')

@section('content')
    <div class="container play-container">
        <div class="stadium-section">
            <div class="stadium-image">
                <img src="{{ asset('storage/' . $challenge->image_path) }}" alt="Mystery Stadium">
            </div>

            <div class="stadium-description">
                <p>{{ $challenge->description }}</p>
            </div>

            <div class="controls">
                <a href="{{ route('games.stadium.play') }}" class="btn btn-outline">
                    Try Another Stadium
                </a>
            </div>
        </div>

        <div class="interaction-section">
            <div class="question-card">
                <div class="question-header">
                    <h3>The Challenge</h3>
                    <span class="difficulty-badge {{ $challenge->difficulty }}">
                        {{ ucfirst($challenge->difficulty) }}
                    </span>
                </div>
                <div class="question-body">
                    <p>Which stadium is this?</p>
                </div>

                <div class="answer-form">
                    <input type="text" id="answer-input" placeholder="Type stadium name..." autocomplete="off">
                    <button id="submit-btn" class="btn btn-primary">Check Answer</button>
                </div>

                <div id="feedback" class="feedback"></div>
            </div>

            <div class="hints-section">
                <button id="hint-btn" class="btn btn-outline">Get a Hint</button>
                <div id="hints-display" class="hints-display"></div>
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

            .stadium-section {
                margin-bottom: 1rem;
            }

            .stadium-image {
                border-radius: 24px;
                overflow: hidden;
                box-shadow: var(--shadow);
                border: 1px solid var(--glass-border);
                transition: var(--transition);
                max-width: 800px;
                margin: 0 auto;
                background: #000;
            }

            .stadium-image:hover {
                box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
            }

            .stadium-image img {
                width: 100%;
                max-height: 500px;
                object-fit: cover;
                display: block;
            }

            .stadium-description {
                margin-top: 1.25rem;
                text-align: center;
                color: var(--text-dim);
                font-size: 0.95rem;
                line-height: 1.6;
            }

            .controls {
                margin-top: 1.25rem;
                display: flex;
                justify-content: center;
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

            .question-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .question-header h3 {
                font-family: 'Outfit', sans-serif;
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 2px;
                color: var(--stadium-green);
                margin: 0;
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

            .question-body p {
                font-family: 'Outfit', sans-serif;
                font-size: 1.4rem;
                font-weight: 700;
                color: var(--pitch-dark);
                line-height: 1.3;
                margin: 0;
            }

            .answer-form {
                display: flex;
                gap: 0.75rem;
            }

            .answer-form input {
                flex: 1;
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
            const stadiumId = {{ $challenge->id }};
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const shownHints = [];

            document.getElementById('submit-btn').addEventListener('click', checkAnswer);
            document.getElementById('answer-input').addEventListener('keypress', (e) => {
                if (e.key === 'Enter') checkAnswer();
            });
            document.getElementById('hint-btn').addEventListener('click', getHint);

            async function checkAnswer() {
                const answer = document.getElementById('answer-input').value;
                const feedback = document.getElementById('feedback');

                if (!answer.trim()) return;

                const response = await fetch(`/stadiums/${stadiumId}/check`, {
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
                    document.getElementById('answer-input').disabled = true;
                    highlightSuccess();
                }
            }

            async function getHint() {
                const response = await fetch(`/stadiums/${stadiumId}/hint`, {
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
            }

            function highlightSuccess() {
                document.querySelector('.question-card').style.borderColor = '#2ea043';
                document.querySelector('.question-card').style.borderStyle = 'solid';
                document.querySelector('.question-card').style.borderWidth = '2px';
            }

            // Update URL for shareability
            if (!window.location.pathname.endsWith('/' + stadiumId)) {
                const shareableUrl = `/games/stadium-spotter/${stadiumId}`;
                window.history.replaceState({ path: shareableUrl }, '', shareableUrl);
            }
        </script>
    @endpush
@endsection