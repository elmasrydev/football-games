@extends('layouts.app')

@section('content')
    <div class="container play-container">
        <div class="visual-section">
            <div class="puzzle-box">
                @if($game->slug === 'transfer-chain')
                    <div class="transfer-display">
                        <div class="club-name">{{ $challenge->club_a ?? $challenge->stimulus_data['club_a'] ?? '' }}</div>
                        <div class="transfer-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" /></svg>
                        </div>
                        <div class="club-name">{{ $challenge->club_b ?? $challenge->stimulus_data['club_b'] ?? '' }}</div>
                    </div>
                @elseif($game->slug === 'career-path')
                    @php 
                        $clubs = $challenge->stimulus_data['clubs'] ?? [];
                        $playerImage = $challenge->stimulus_data['player_image'] ?? null;
                    @endphp
                    <div class="career-display">
                        @if($playerImage)
                            <div class="player-avatar">
                                <img src="{{ asset('storage/' . $playerImage) }}" alt="Mystery Player">
                            </div>
                        @endif
                        <div class="club-timeline">
                            @foreach($clubs as $club)
                                <div class="timeline-item">
                                    <span class="timeline-year">{{ $club['year'] }}</span>
                                    <span class="timeline-dot"></span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif($game->slug === 'group-players')
                    @php 
                        $totalPlayers = count($challenge->stimulus_data['players'] ?? []);
                    @endphp
                    <div class="group-display">
                        <h2 class="group-title">{{ $challenge->stimulus_data['title'] ?? 'Mystery Group' }}</h2>
                        <div class="progress-container">
                            <div class="progress-info">
                                <span id="found-count">0</span> / <span>{{ $totalPlayers }}</span> found
                            </div>
                            <div class="progress-bar">
                                <div id="progress-fill" class="progress-fill" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="word-description">
                @if($game->slug === 'transfer-chain')
                    <p>Name a player who played for both clubs!</p>
                @elseif($game->slug === 'career-path')
                    <p>Who played for all these clubs during these years?</p>
                @elseif($game->slug === 'group-players')
                    <p>Can you find all the players in this group?</p>
                @endif
            </div>

            <div class="controls">
                <a href="{{ route('games.play', $game->slug) }}" class="btn btn-outline">
                    Try Another Challenge
                </a>
                <x-bookmark-button :gameId="$game->id" />
            </div>
        </div>

        <div class="interaction-section">
            <div class="question-card">
                <div class="question-header">
                    <h3>🔍 {{ $game->title }}</h3>
                    <span class="difficulty-badge {{ $challenge->difficulty }}">
                        {{ ucfirst($challenge->difficulty) }}
                    </span>
                </div>
                <div class="question-body">
                    <p>Enter a player name:</p>
                </div>

                <x-player-answer-form placeholder="Start typing a player name..." />

                <div id="feedback" class="feedback"></div>
                <div id="found-players" class="found-players-list"></div>
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
                background: white; border: 1px solid var(--glass-border);
                box-shadow: var(--shadow); border-radius: 20px; padding: 3rem;
                display: flex; flex-direction: column; justify-content: center; align-items: center; margin-bottom: 1rem;
            }
            
            /* Transfer Chain Styles */
            .transfer-display { display: flex; align-items: center; gap: 2rem; }
            .club-name { font-size: 2rem; font-weight: 800; color: var(--pitch-dark); text-align: center; }
            .transfer-icon { width: 48px; height: 48px; color: var(--stadium-green); }

            /* Career Path Styles */
            .career-display { display: flex; flex-direction: column; align-items: center; gap: 2rem; }
            .player-avatar img { width: 100px; height: 100px; border-radius: 50%; border: 4px solid var(--stadium-green); }
            .club-timeline { display: flex; gap: 1.5rem; flex-wrap: wrap; justify-content: center; }
            .timeline-item { display: flex; flex-direction: column; align-items: center; gap: 0.5rem; }
            .timeline-year { font-weight: 800; font-size: 1.1rem; color: var(--pitch-dark); }
            .timeline-dot { width: 12px; height: 12px; background: var(--stadium-green); border-radius: 50%; }

            /* Group Challenge Styles */
            .group-display { width: 100%; text-align: center; }
            .group-title { font-size: 2.5rem; font-weight: 900; color: var(--pitch-dark); margin-bottom: 2rem; }
            .progress-container { width: 100%; max-width: 500px; margin: 0 auto; }
            .progress-info { font-weight: 700; margin-bottom: 0.5rem; }
            .progress-bar { width: 100%; height: 12px; background: #e5e7eb; border-radius: 6px; overflow: hidden; }
            .progress-fill { height: 100%; background: var(--stadium-green); transition: width 0.3s ease; }

            .found-players-list { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1rem; }
            .found-chip { background: #d1fae5; color: #065f46; padding: 0.4rem 0.8rem; border-radius: 20px; font-weight: 700; font-size: 0.85rem; }

            .word-description { text-align: center; color: var(--text-dim); font-size: 1.1rem; margin-top: 1rem; }
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
            .question-body p { font-family: 'Outfit', sans-serif; font-size: 1.2rem; font-weight: 700; color: var(--pitch-dark); margin: 0; }
            .feedback { min-height: 1.5rem; font-weight: 700; padding: 0.75rem; border-radius: 10px; display: none; text-align: center; font-size: 0.85rem; margin-top: 1rem; }
            .feedback.correct { display: block; color: #fff; background: linear-gradient(135deg, #2ea043, #238636); }
            .feedback.wrong { display: block; color: #fff; background: linear-gradient(135deg, #da3633, #b62324); }
            .feedback.revealed { display: block; color: #fff; background: linear-gradient(135deg, #6b7280, #374151); }

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
            const isGroup = {{ $game->slug === 'group-players' ? 'true' : 'false' }};
            let shownHints = [];
            let revealedOrders = [];
            const totalToFind = {{ count($challenge->stimulus_data['players'] ?? [0]) }};

            document.getElementById('submit-btn').addEventListener('click', () => {
                const answer = document.getElementById('answer-input').value;
                if (!answer) return;

                fetch(`{{ route('challenges.check', $challenge->id) }}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ answer, revealed_orders: revealedOrders })
                })
                .then(r => r.json())
                .then(data => {
                    const feedback = document.getElementById('feedback');
                    feedback.textContent = data.message;
                    feedback.className = 'feedback ' + (data.correct ? 'correct' : 'wrong');
                    feedback.style.display = 'block';

                    if (data.correct) {
                        if (isGroup && data.matched_sort_order !== undefined) {
                            revealedOrders.push(data.matched_sort_order);
                            updateProgress(answer);
                            document.getElementById('answer-input').value = '';
                            if (revealedOrders.length >= totalToFind) {
                                feedback.textContent = "Congratulations! You found all players!";
                                document.getElementById('submit-btn').disabled = true;
                            }
                        } else {
                            document.getElementById('submit-btn').disabled = true;
                        }
                    }
                });
            });

            function updateProgress(name) {
                const countSpan = document.getElementById('found-count');
                if (countSpan) countSpan.textContent = revealedOrders.length;
                
                const fill = document.getElementById('progress-fill');
                if (fill) fill.style.width = (revealedOrders.length / totalToFind * 100) + '%';

                const chip = document.createElement('div');
                chip.className = 'found-chip';
                chip.textContent = name;
                document.getElementById('found-players').appendChild(chip);
            }

            document.getElementById('hint-btn').addEventListener('click', () => {
                fetch(`{{ route('challenges.hint', $challenge->id) }}`, {
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
                fetch(`{{ route('challenges.reveal', $challenge->id) }}`)
                .then(r => r.json())
                .then(data => {
                    const feedback = document.getElementById('feedback');
                    if (data.answers) {
                        feedback.textContent = `Answers: ${data.answers.join(', ')}`;
                    } else {
                        feedback.textContent = `The answer was: ${data.answer}`;
                        document.getElementById('answer-input').value = data.answer;
                    }
                    feedback.className = 'feedback revealed';
                    feedback.style.display = 'block';
                    document.getElementById('submit-btn').disabled = true;
                });
            });

            document.getElementById('clear-btn').addEventListener('click', () => {
                document.getElementById('answer-input').value = '';
                document.getElementById('feedback').style.display = 'none';
            });

            initAutocomplete('answer-input', 'autocomplete-list', '{{ route('search.players') }}');
        </script>
    @endpush
@endsection
