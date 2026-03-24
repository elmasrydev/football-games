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
                    <div class="player-slot" data-order="{{ $i }}" id="slot-{{ $i }}">
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
                --glass-bg: rgba(255, 255, 255, 0.7);
            }

            .play-container {
                padding-top: 2rem;
                padding-bottom: 4rem;
                gap: 3rem;
            }

            .group-section {
                margin-bottom: 2rem;
            }

            .group-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 2.5rem;
            }

            .group-header h2 {
                font-family: 'Outfit', sans-serif;
                font-size: 2rem;
                font-weight: 800;
                color: var(--pitch-dark);
                margin: 0;
                background: var(--group-gradient);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .group-image-container {
                width: 100%;
                margin: 0 0 3rem 0;
                border-radius: 24px;
                overflow: hidden;
                box-shadow: 0 20px 40px rgba(0,0,0,0.08);
                background: #f8fafc;
                border: 1px solid var(--glass-border);
                transition: transform 0.3s ease;
            }

            .group-image-container:hover {
                transform: translateY(-5px);
            }

            .group-image {
                width: 100%;
                height: auto;
                display: block;
                max-height: 600px;
                object-fit: contain;
            }

            .answer-slots {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 1.5rem;
                margin-bottom: 3rem;
            }

            .player-slot {
                background: var(--glass-bg);
                backdrop-filter: blur(10px);
                border: 2px dashed #cbd5e1;
                border-radius: 20px;
                padding: 1.75rem 1rem;
                text-align: center;
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0.75rem;
                position: relative;
            }

            .player-slot.revealed {
                background: white;
                border-style: solid;
                border-color: var(--group-primary);
                box-shadow: 0 10px 20px rgba(16, 185, 129, 0.12);
                transform: scale(1.05);
            }

            .slot-number {
                width: 32px;
                height: 32px;
                background: #f1f5f9;
                color: #64748b;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.8rem;
                font-weight: 800;
                transition: all 0.3s ease;
            }

            .revealed .slot-number {
                background: var(--group-primary);
                color: white;
                transform: rotate(360deg);
            }

            .slot-content {
                font-family: 'Outfit', sans-serif;
                font-size: 1.15rem;
                font-weight: 700;
                color: #94a3b8;
                word-break: break-word;
            }

            .revealed .slot-content {
                color: var(--pitch-dark);
            }

            .interaction-section {
                display: grid;
                grid-template-columns: 1.4fr 1fr;
                gap: 3rem;
                align-items: start;
            }

            .question-card {
                background: white;
                border-radius: 24px;
                border: 1px solid var(--glass-border);
                box-shadow: var(--shadow-lg);
                padding: 2.5rem;
                display: flex;
                flex-direction: column;
                gap: 2rem;
            }

            .question-header h3 {
                font-family: 'Outfit', sans-serif;
                font-size: 0.85rem;
                text-transform: uppercase;
                letter-spacing: 2px;
                color: var(--group-primary);
                margin: 0;
            }

            .question-body p {
                font-family: 'Outfit', sans-serif;
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--pitch-dark);
                margin: 0;
                line-height: 1.3;
            }

            /* Form Styling Overrides */
            .answer-form {
                gap: 1.5rem;
            }

            .answer-form input {
                padding: 1.25rem !important;
                font-size: 1.1rem !important;
                border-radius: 14px !important;
                box-shadow: inset 0 2px 4px rgba(0,0,0,0.02) !important;
            }

            .form-actions {
                gap: 1rem !important;
            }

            .form-actions .btn {
                padding: 0.8rem 1.5rem !important;
                font-weight: 700 !important;
                border-radius: 12px !important;
            }

            .feedback {
                min-height: 3.5rem;
                font-weight: 800;
                padding: 1rem 1.5rem;
                border-radius: 16px;
                display: none;
                text-align: center;
                font-size: 1.1rem;
                align-items: center;
                justify-content: center;
                animation: slideUpFade 0.4s ease-out;
            }

            @keyframes slideUpFade {
                from { transform: translateY(10px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }

            .feedback.success { 
                display: flex; 
                background: linear-gradient(135deg, #059669, #10b981);
                color: white;
                box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
            }

            .feedback.error { 
                display: flex; 
                background: linear-gradient(135deg, #dc2626, #ef4444);
                color: white;
                box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
            }

            .hints-section {
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
            }

            #hint-btn {
                width: 100%;
                padding: 1.25rem;
                font-weight: 700;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.75rem;
                background: white;
                border: 2px solid var(--group-primary);
                color: var(--group-primary);
                transition: all 0.3s ease;
            }

            #hint-btn:hover:not(:disabled) {
                background: var(--group-primary);
                color: white;
                box-shadow: 0 8px 16px rgba(16, 185, 129, 0.2);
            }

            #hint-btn svg {
                width: 20px;
                height: 20px;
            }

            .hints-display {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .hint-item {
                background: white;
                padding: 1.25rem;
                border-radius: 16px;
                border-left: 5px solid var(--group-primary);
                box-shadow: 0 4px 12px rgba(0,0,0,0.05);
                font-size: 1rem;
                line-height: 1.5;
                animation: playerAppear 0.4s ease-out;
            }

            .controls {
                margin-top: 3rem;
                display: flex;
                justify-content: center;
            }

            @media (max-width: 1024px) {
                .interaction-section {
                    grid-template-columns: 1fr;
                    gap: 2rem;
                }
            }

            @media (max-width: 640px) {
                .answer-slots {
                    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
                    gap: 1rem;
                }
                .group-header h2 {
                    font-size: 1.5rem;
                }
            }

            @keyframes playerAppear {
                from { transform: translateX(-10px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }

            @keyframes popIn {
                0% { transform: scale(0.9); opacity: 0; }
                100% { transform: scale(1.05); opacity: 1; }
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
                if (typeof confetti === 'function') confetti();
            }
        </script>
    @endpush
@endsection
