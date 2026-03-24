@extends('layouts.app')

@section('content')
    <div class="container play-container">
        <div class="group-section">
            <div class="group-header">
                <h2>{{ $challenge->title }}</h2>
                <span class="difficulty-badge {{ $challenge->difficulty }}">
                    {{ ucfirst($challenge->difficulty) }}
                </span>
            </div>

            <div class="group-image-container">
                <img src="{{ asset('storage/' . $challenge->image) }}" alt="{{ $challenge->title }}" class="group-image">
            </div>

            <div class="answer-slots" id="answer-slots">
                @foreach(range(1, $challenge->players_count) as $i)
                    <div class="player-slot" data-order="{{ $i-1 }}" id="slot-{{ $i-1 }}">
                        <div class="slot-number">{{ $i }}</div>
                        <div class="slot-content">?</div>
                    </div>
                @endforeach
            </div>

            <div class="controls">
                <a href="{{ route('games.group.play') }}" class="btn btn-outline">
                    Try Another Challenge
                </a>
            </div>
        </div>

        <div class="interaction-section">
            <div class="question-card">
                <div class="question-header">
                    <h3>Who are these players?</h3>
                </div>
                <div class="question-body">
                    <p>There are {{ $challenge->players_count }} players to find. Type a name to reveal them!</p>
                </div>

                <x-player-answer-form placeholder="Type player name..." />

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
                <div id="hints-display" class="hints-display"></div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            :root {
                --group-primary: #10b981;
                --group-secondary: #34d399;
                --group-accent: #059669;
                --group-gradient: linear-gradient(135deg, #10b981, #3b82f6);
            }

            .group-header h2 {
                font-family: 'Outfit', sans-serif;
                font-size: 1.75rem;
                font-weight: 700;
                color: var(--pitch-dark);
                margin: 0;
                background: var(--group-gradient);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .group-image-container {
                width: 100%;
                margin: 2rem 0;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                background: #f8fafc;
                border: 1px solid var(--glass-border);
            }

            .group-image {
                width: 100%;
                height: auto;
                display: block;
                max-height: 500px;
                object-fit: contain;
            }

            .answer-slots {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .player-slot {
                background: white;
                border: 2px dashed #cbd5e1;
                border-radius: 16px;
                padding: 1.5rem 1rem;
                text-align: center;
                transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0.75rem;
                position: relative;
            }

            .player-slot.revealed {
                border-style: solid;
                border-color: var(--group-primary);
                box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
                transform: scale(1.05);
            }

            .slot-number {
                width: 28px;
                height: 28px;
                background: #f1f5f9;
                color: #64748b;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.75rem;
                font-weight: 700;
            }

            .revealed .slot-number {
                background: var(--group-primary);
                color: white;
            }

            .slot-content {
                font-family: 'Outfit', sans-serif;
                font-size: 1.1rem;
                font-weight: 700;
                color: #94a3b8;
            }

            .revealed .slot-content {
                color: var(--pitch-dark);
            }

            .interaction-section {
                display: grid;
                grid-template-columns: 1.5fr 1fr;
                gap: 2.5rem;
            }

            .feedback {
                min-height: 1.5rem;
                font-weight: 700;
                padding: 0.75rem;
                border-radius: 10px;
                display: none;
                text-align: center;
            }

            .feedback.success { display: block; color: #fff; background: var(--group-primary); }
            .feedback.error { display: block; color: #fff; background: #ef4444; }

            .hint-item {
                background: white; padding: 1rem; border-radius: 12px; border-left: 4px solid var(--group-primary);
                margin-bottom: 0.75rem; box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            }

            @media (max-width: 900px) {
                .interaction-section { grid-template-columns: 1fr; }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            const challengeId = {{ $challenge->id }};
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const revealedOrders = [];
            const shownHints = [];

            initAutocomplete('answer-input', 'autocomplete-list', '{{ route('group.players.search') }}');

            document.getElementById('submit-btn').addEventListener('click', checkAnswer);
            document.getElementById('answer-input').addEventListener('keypress', (e) => {
                if (e.key === 'Enter') checkAnswer();
            });

            document.getElementById('give-up-btn').addEventListener('click', revealAll);
            document.getElementById('hint-btn').addEventListener('click', () => openHintModal(getHint));
            document.getElementById('clear-btn').addEventListener('click', () => clearAutocomplete('answer-input', 'autocomplete-list'));

            async function checkAnswer() {
                const answer = document.getElementById('answer-input').value;
                const feedback = document.getElementById('feedback');

                if (!answer.trim()) return;

                const response = await fetch(`/group/${challengeId}/check`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ answer, revealed_orders: revealedOrders })
                });

                const data = await response.json();
                feedback.innerText = data.message;
                feedback.className = 'feedback ' + (data.correct ? 'success' : 'error');

                if (data.correct) {
                    revealPlayer(data.sort_order, data.player_name);
                    document.getElementById('answer-input').value = '';
                    
                    if (revealedOrders.length === {{ $challenge->players_count }}) {
                        gameWon();
                    }
                }
            }

            function revealPlayer(order, name) {
                if (revealedOrders.includes(order)) return;
                
                revealedOrders.push(order);
                const slot = document.getElementById(`slot-${order}`);
                slot.classList.add('revealed');
                slot.querySelector('.slot-content').innerText = name;
                
                // Success animation
                slot.style.animation = 'popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
            }

            async function revealAll() {
                if (!confirm('Are you sure you want to reveal all players?')) return;

                const response = await fetch(`/group/${challengeId}/reveal`);
                const data = await response.json();

                data.players.forEach(p => revealPlayer(p.sort_order, p.name));
                
                document.getElementById('submit-btn').disabled = true;
                document.getElementById('answer-input').disabled = true;
                document.getElementById('give-up-btn').disabled = true;
                document.getElementById('hint-btn').disabled = true;
            }

            async function getHint() {
                const response = await fetch(`/group/${challengeId}/hint`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
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
                }
            }

            function gameWon() {
                const feedback = document.getElementById('feedback');
                feedback.innerText = "AMAZING! You found all players!";
                feedback.className = 'feedback success';
                document.getElementById('answer-input').disabled = true;
                document.getElementById('submit-btn').disabled = true;
                document.getElementById('hint-btn').disabled = true;
                
                // Celebrate!
                confetti(); // Assuming confetti is available in the layout or we add it
            }

            @keyframes popIn {
                0% { transform: scale(0.9); opacity: 0; }
                100% { transform: scale(1.05); opacity: 1; }
            }
        </script>
    @endpush
@endsection
