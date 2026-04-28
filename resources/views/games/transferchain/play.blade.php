@extends('layouts.app')

@section('content')
    <div class="container play-container">
        <div class="word-section">
            <div class="puzzle-box">
                <div class="transfer-chain-display">
                    <div class="club-node">
                        <span class="club-name">{{ $challenge->club_a }}</span>
                    </div>
                    <div class="transfer-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                    </div>
                    <div class="player-node-placeholder">
                        <span>?</span>
                    </div>
                    <div class="transfer-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                    </div>
                    <div class="club-node">
                        <span class="club-name">{{ $challenge->club_b }}</span>
                    </div>
                </div>
            </div>

            <div class="word-description">
                <p>Name a player who has played for both clubs!</p>
            </div>

            <div class="controls">
                <a href="{{ route('games.transferchain.play') }}" class="btn btn-outline">
                    Try Another Chain
                </a>
                <x-bookmark-button :gameId="$game->id" />
            </div>
        </div>

        <div class="interaction-section">
            <div class="question-card">
                <div class="question-header">
                    <h3>🤝 Transfer Connection</h3>
                    <span class="difficulty-badge {{ $challenge->difficulty }}">
                        {{ ucfirst($challenge->difficulty) }}
                    </span>
                </div>
                <div class="question-body">
                    <p>Who links these clubs?</p>
                </div>

                <x-player-answer-form placeholder="Player name..." />

                <div id="feedback" class="feedback"></div>
            </div>

            <div class="hints-section">
                <button id="hint-btn" class="btn btn-outline hint-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-3m0 0a8.1 8.1 0 0 0 4.5-1.55c3.3-2.45 3.3-6.45 0-8.9A8.1 8.1 0 0 0 12 3a8.1 8.1 0 0 0-4.5 1.55c-3.3 2.45-3.3 6.45 0 8.9A8.1 8.1 0 0 0 12 15Zm0 3v2m0 0h-3m3 0h3" /></svg>
                    <span>Need a Hint?</span>
                </button>
                <div id="hints-display" class="hints-display"></div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .play-container { display: flex; flex-direction: column; gap: 2rem; }
            .puzzle-box {
                background: white; border: 1px solid var(--glass-border); box-shadow: var(--shadow);
                border-radius: 20px; padding: 3rem; display: flex; justify-content: center; align-items: center; margin-bottom: 1rem;
            }
            .transfer-chain-display { display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; justify-content: center; }
            .club-node { background: #fff; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); min-width: 150px; text-align: center; }
            .club-name { color: var(--stadium-blue); font-weight: 800; font-size: 1.2rem; }
            .transfer-arrow { color: var(--text-dim); width: 32px; }
            .player-node-placeholder {
                width: 60px; height: 60px; background: var(--stadium-green); color: white;
                display: flex; justify-content: center; align-items: center;
                font-size: 2rem; font-weight: 900; border-radius: 50%; box-shadow: 0 0 15px var(--stadium-green);
            }
            
            .word-description { text-align: center; color: var(--text-dim); font-size: 0.95rem; line-height: 1.6; margin-top: 1rem; }
            .controls { margin-top: 1.25rem; display: flex; justify-content: center; gap: 1rem; }
            
            .interaction-section { display: grid; grid-template-columns: 1.5fr 1fr; gap: 2.5rem; align-items: start; }
            .question-card {
                background: white; border-radius: 20px; border: 1px solid var(--glass-border);
                box-shadow: var(--shadow); padding: 2rem; display: flex; flex-direction: column; gap: 1.5rem;
            }
            .question-header { display: flex; justify-content: space-between; align-items: center; }
            .question-header h3 { font-family: 'Outfit', sans-serif; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: var(--stadium-green); margin: 0; }
            .difficulty-badge { padding: 0.3rem 0.75rem; border-radius: 12px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
            .difficulty-badge.easy { background: #d4edda; color: #155724; }
            .difficulty-badge.medium { background: #fff3cd; color: #856404; }
            .difficulty-badge.hard { background: #f8d7da; color: #721c24; }
            .question-body p { font-family: 'Outfit', sans-serif; font-size: 1.4rem; font-weight: 700; color: var(--pitch-dark); margin: 0; }
            .feedback { min-height: 1.5rem; font-weight: 700; padding: 0.75rem; border-radius: 10px; display: none; text-align: center; font-size: 0.85rem; }
            .feedback.correct { display: block; color: #fff; background: linear-gradient(135deg, #2ea043, #238636); }
            .feedback.wrong { display: block; color: #fff; background: linear-gradient(135deg, #da3633, #b62324); }

            .hints-section { display: flex; flex-direction: column; gap: 1rem; }
            #hint-btn { width: 100%; padding: 1rem; }
            .hint-item {
                background: white; padding: 1rem; border-radius: 12px; border-left: 4px solid var(--stadium-green);
                border: 1px solid var(--glass-border); border-left-width: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);
                font-size: 0.9rem; color: var(--text-main); margin-bottom: 0.5rem;
            }

            @media (max-width: 900px) { .interaction-section { grid-template-columns: 1fr; } }
        </style>
    @endpush

    @push('scripts')
        <script>
            const challengeId = {{ $challenge->id }};
            const csrfToken = '{{ csrf_token() }}';
            let shownHints = [];

            // Initialize Autocomplete
            initAutocomplete('answer-input', 'autocomplete-list', '{{ route('group.players.search') }}');

            document.getElementById('submit-btn').addEventListener('click', () => {
                const answer = input.value;
                if (!answer) return;

                fetch(`/transfer-chain/${challengeId}/check`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ answer })
                })
                .then(r => r.json())
                .then(data => {
                    const feedback = document.getElementById('feedback');
                    feedback.textContent = data.message;
                    feedback.className = 'feedback ' + (data.correct ? 'correct' : 'wrong');
                    if (data.correct) {
                        feedback.style.display = 'block';
                        document.getElementById('submit-btn').disabled = true;
                    }
                });
            });

            document.getElementById('hint-btn').addEventListener('click', () => {
                fetch(`/transfer-chain/${challengeId}/hint`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ shown_hints: shownHints })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.hint) {
                        shownHints.push(data.id);
                        const hintDiv = document.createElement('div');
                        hintDiv.className = 'hint-item';
                        hintDiv.innerHTML = `<p>💡 ${data.hint}</p>`;
                        document.getElementById('hints-display').appendChild(hintDiv);
                    } else {
                        alert(data.message);
                    }
                });
            });

            document.getElementById('give-up-btn').addEventListener('click', () => {
                fetch(`/transfer-chain/${challengeId}/reveal`)
                .then(r => r.json())
                .then(data => {
                    const feedback = document.getElementById('feedback');
                    const allAnswers = data.answers.join(', ');
                    feedback.textContent = `Possible answers: ${allAnswers}`;
                    feedback.className = 'feedback revealed';
                    feedback.style.display = 'block';
                    input.value = data.answers[0];
                    document.getElementById('submit-btn').disabled = true;
                });
            });

            document.getElementById('clear-btn').addEventListener('click', () => {
                clearAutocomplete('answer-input', 'autocomplete-list');
                document.getElementById('feedback').style.display = 'none';
            });
        </script>
    @endpush
@endsection
