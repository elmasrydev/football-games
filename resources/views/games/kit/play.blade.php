@extends('layouts.app')

@section('content')
    <div class="container play-container">
        <div class="kit-section">
            <div class="kit-image-container">
                <img id="kit-image" src="{{ asset('storage/' . $challenge->image_path) }}" alt="Mystery Kit Detail"
                    class="kit-display">
                <div id="correct-overlay" class="correct-overlay">
                    <span class="correct-text">MATCH FOUND!</span>
                </div>
            </div>

            <div class="kit-description">
                <p>Examine the fabric, the patterns, and the logos. Which kit is this?</p>
            </div>

            <div class="controls">
                <a href="{{ route('games.kit.play') }}" class="btn btn-outline" title="Get another mystery kit">
                    <span>Try Another Kit</span>
                </a>
            </div>
        </div>

        <div class="interaction-section">
            <div class="question-card">
                <div class="question-header">
                    <h3>The Investigation</h3>
                    <span class="difficulty-badge {{ $challenge->difficulty }}">
                        {{ ucfirst($challenge->difficulty) }}
                    </span>
                </div>
                <div class="question-body">
                    <p>Identify the Team & Year</p>
                    <small>(e.g., Arsenal 2003-04)</small>
                </div>

                <div class="answer-form">
                    <input type="text" id="answer-input" placeholder="Team and Year..." autocomplete="off">
                    <button id="submit-btn" class="btn btn-primary">Check Kit</button>
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

            .kit-section {
                width: 100%;
                text-align: center;
            }

            .kit-image-container {
                position: relative;
                border-radius: 24px;
                overflow: hidden;
                box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
                background: #f0f0f0;
                border: 1px solid var(--glass-border);
                max-width: 600px;
                margin: 0 auto;
                aspect-ratio: 1;
                transition: var(--transition);
            }

            .kit-image-container:hover {
                box-shadow: 0 16px 48px rgba(0, 0, 0, 0.2);
                transform: translateY(-4px);
            }

            .kit-display {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: filter 0.5s ease;
            }

            .correct-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(46, 160, 67, 0.2);
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
                font-size: 3rem;
                text-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
                letter-spacing: 4px;
                transform: rotate(-10deg);
                border: 6px solid white;
                padding: 1rem 2rem;
                animation: stamp 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }

            @keyframes stamp {
                0% {
                    transform: scale(3) rotate(-10deg);
                    opacity: 0;
                }

                100% {
                    transform: scale(1) rotate(-10deg);
                    opacity: 1;
                }
            }

            .kit-description {
                margin-top: 1.5rem;
                color: var(--text-dim);
                font-size: 1rem;
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
                margin-bottom: 0.25rem;
            }

            .question-body small {
                color: var(--text-dim);
                display: block;
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

                .kit-image-container {
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

            document.getElementById('submit-btn').addEventListener('click', checkAnswer);
            document.getElementById('answer-input').addEventListener('keypress', function (e) {
                if (e.key === 'Enter') checkAnswer();
            });

            document.getElementById('hint-btn').addEventListener('click', getHint);

            async function checkAnswer() {
                const answer = document.getElementById('answer-input').value;
                const feedback = document.getElementById('feedback');
                const kitImage = document.getElementById('kit-image');
                const overlay = document.getElementById('correct-overlay');

                if (!answer.trim()) return;

                try {
                    const response = await fetch(`/kits/${challengeId}/check`, {
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

                        // Reveal full image
                        if (data.full_image) {
                            kitImage.src = data.full_image;
                            kitImage.style.objectFit = 'contain';
                        }
                        overlay.style.display = 'flex';

                        document.querySelector('.question-card').style.borderColor = '#27ae60';
                        document.querySelector('.question-card').style.borderStyle = 'solid';
                        document.querySelector('.question-card').style.borderWidth = '2px';
                    }
                } catch (error) {
                    console.error('Error checking answer:', error);
                }
            }

            async function getHint() {
                try {
                    const response = await fetch(`/kits/${challengeId}/hint`, {
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
                const shareableUrl = "/games/kit-detective/" + challengeId;
                window.history.replaceState({ path: shareableUrl }, '', shareableUrl);
            }
        </script>
    @endpush
@endsection