@extends('layouts.app')

@section('content')
    <div class="container play-container">
        <div class="career-section">
            <div class="career-header">
                <h2>Career Path Challenge</h2>
                <span class="difficulty-badge {{ $challenge->difficulty }}">
                    {{ ucfirst($challenge->difficulty) }}
                </span>
            </div>

            <div class="career-chain" id="career-chain">
                <!-- Clubs will be revealed here progressively -->
            </div>

            <div class="reveal-controls">
                <button id="reveal-btn" class="btn btn-accent">
                    <span class="icon">👆</span> Reveal Next Club
                </button>
                <span class="clubs-counter" id="clubs-counter">0 / {{ count($challenge->careerClubs) }} clubs
                    revealed</span>
            </div>

            <div class="controls">
                <a href="{{ route('games.career.play') }}" class="btn btn-outline">
                    Try Another Player
                </a>
            </div>
        </div>

        <div class="interaction-section">
            <div class="question-card">
                <div class="question-header">
                    <h3>Who Is This Player?</h3>
                </div>
                <div class="question-body">
                    <p>Guess the player from their career history!</p>
                </div>

                <div class="answer-form">
                    <input type="text" id="answer-input" placeholder="Type player name..." autocomplete="off">
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
            :root {
                --career-primary: #6366f1;
                --career-secondary: #818cf8;
                --career-accent: #4f46e5;
                --career-gradient: linear-gradient(135deg, #6366f1, #8b5cf6);
            }

            .play-container {
                display: flex;
                flex-direction: column;
                gap: 2rem;
            }

            .career-section {
                margin-bottom: 1rem;
            }

            .career-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 2rem;
            }

            .career-header h2 {
                font-family: 'Outfit', sans-serif;
                font-size: 1.75rem;
                font-weight: 700;
                color: var(--pitch-dark);
                margin: 0;
                background: var(--career-gradient);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .career-chain {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                min-height: 150px;
                padding: 2rem;
                background: linear-gradient(135deg, #f8f9ff, #f0f1ff);
                border-radius: 24px;
                border: 2px dashed var(--career-secondary);
            }

            .club-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
                padding: 1rem;
                background: white;
                border-radius: 16px;
                box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
                animation: clubAppear 0.5s ease-out;
                min-width: 100px;
            }

            @keyframes clubAppear {
                0% {
                    transform: scale(0) rotate(-10deg);
                    opacity: 0;
                }

                50% {
                    transform: scale(1.1) rotate(5deg);
                }

                100% {
                    transform: scale(1) rotate(0deg);
                    opacity: 1;
                }
            }

            .club-logo {
                width: 60px;
                height: 60px;
                object-fit: contain;
                filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
            }

            .club-name {
                font-family: 'Outfit', sans-serif;
                font-size: 0.8rem;
                font-weight: 600;
                color: var(--pitch-dark);
                text-align: center;
                max-width: 90px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .club-year {
                font-size: 0.7rem;
                color: var(--career-primary);
                font-weight: 700;
                padding: 0.2rem 0.5rem;
                background: #ede9fe;
                border-radius: 8px;
            }

            .chain-arrow {
                font-size: 1.5rem;
                color: var(--career-secondary);
                animation: arrowPulse 1.5s ease-in-out infinite;
            }

            @keyframes arrowPulse {

                0%,
                100% {
                    opacity: 0.5;
                    transform: translateX(0);
                }

                50% {
                    opacity: 1;
                    transform: translateX(3px);
                }
            }

            .reveal-controls {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 1.5rem;
                margin-top: 1.5rem;
            }

            .btn-accent {
                background: var(--career-gradient);
                color: white;
                border: none;
                padding: 1rem 2rem;
                font-size: 1rem;
                font-weight: 600;
                border-radius: 12px;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            }

            .btn-accent:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
            }

            .btn-accent:disabled {
                opacity: 0.5;
                cursor: not-allowed;
                transform: none;
            }

            .btn-accent .icon {
                margin-right: 0.5rem;
            }

            .clubs-counter {
                font-size: 0.9rem;
                color: var(--text-dim);
                font-weight: 500;
            }

            .controls {
                margin-top: 1.5rem;
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
                color: var(--career-primary);
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
                border-color: var(--career-primary);
                background: #fff;
                box-shadow: 0 0 12px rgba(99, 102, 241, 0.1);
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
                border-left: 4px solid var(--career-primary);
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

            .empty-chain-message {
                color: var(--text-dim);
                font-size: 1rem;
                text-align: center;
            }

            @media (max-width: 900px) {
                .interaction-section {
                    grid-template-columns: 1fr;
                }

                .question-body p {
                    font-size: 1.25rem;
                }

                .career-chain {
                    padding: 1rem;
                }

                .club-item {
                    min-width: 80px;
                    padding: 0.75rem;
                }

                .club-logo {
                    width: 45px;
                    height: 45px;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            const challengeId = {{ $challenge->id }};
            const totalClubs = {{ count($challenge->careerClubs) }};
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const shownHints = [];
            let revealedCount = 0;

            document.getElementById('submit-btn').addEventListener('click', checkAnswer);
            document.getElementById('answer-input').addEventListener('keypress', (e) => {
                if (e.key === 'Enter') checkAnswer();
            });
            document.getElementById('hint-btn').addEventListener('click', getHint);
            document.getElementById('reveal-btn').addEventListener('click', revealNextClub);

            // Initialize with empty message
            updateChainDisplay();

            async function revealNextClub() {
                if (revealedCount >= totalClubs) return;

                const response = await fetch(`/career/${challengeId}/next-club`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ revealed_count: revealedCount })
                });

                const data = await response.json();

                if (data.club) {
                    addClubToChain(data.club);
                    revealedCount = data.revealed_count;
                    updateCounter();

                    if (revealedCount >= totalClubs) {
                        document.getElementById('reveal-btn').disabled = true;
                        document.getElementById('reveal-btn').innerHTML = '✅ All Clubs Revealed';
                    }
                } else {
                    alert(data.message);
                }
            }

            function addClubToChain(club) {
                const chain = document.getElementById('career-chain');

                // Remove empty message if present
                const emptyMsg = chain.querySelector('.empty-chain-message');
                if (emptyMsg) emptyMsg.remove();

                // Add arrow if not the first club
                if (revealedCount > 0) {
                    const arrow = document.createElement('span');
                    arrow.className = 'chain-arrow';
                    arrow.innerHTML = '→';
                    chain.appendChild(arrow);
                }

                // Add club item
                const clubDiv = document.createElement('div');
                clubDiv.className = 'club-item';
                clubDiv.innerHTML = `
                            <img src="${club.logo_url}" alt="${club.name}" class="club-logo" onerror="this.src='https://via.placeholder.com/60?text=Club'">
                            <span class="club-name" title="${club.name}">${club.name}</span>
                            <span class="club-year">${club.year}</span>
                        `;
                chain.appendChild(clubDiv);
            }

            function updateChainDisplay() {
                const chain = document.getElementById('career-chain');
                if (revealedCount === 0) {
                    chain.innerHTML = '<p class="empty-chain-message">Click "Reveal Next Club" to start revealing the career path!</p>';
                }
            }

            function updateCounter() {
                document.getElementById('clubs-counter').textContent = `${revealedCount} / ${totalClubs} clubs revealed`;
            }

            async function checkAnswer() {
                const answer = document.getElementById('answer-input').value;
                const feedback = document.getElementById('feedback');

                if (!answer.trim()) return;

                const response = await fetch(`/career/${challengeId}/check`, {
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
                    document.getElementById('reveal-btn').disabled = true;
                    highlightSuccess();
                }
            }

            async function getHint() {
                const response = await fetch(`/career/${challengeId}/hint`, {
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
            if (!window.location.pathname.endsWith('/' + challengeId)) {
                const shareableUrl = `/games/career/${challengeId}`;
                window.history.replaceState({ path: shareableUrl }, '', shareableUrl);
            }
        </script>
    @endpush
@endsection