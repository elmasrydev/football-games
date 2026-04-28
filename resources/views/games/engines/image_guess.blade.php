@extends('layouts.app')

@section('content')
    <div class="container play-container">
        <div class="visual-section">
            <div class="puzzle-box">
                @php 
                    $imagePath = $challenge->image_path ?? $challenge->stimulus_data['image_path'] ?? null;
                @endphp
                @if($imagePath)
                    <div class="image-wrapper">
                        <img src="{{ asset('storage/' . $imagePath) }}" alt="Challenge Image" class="game-image {{ $game->slug === 'silhouette' ? 'silhouette-filter' : '' }}">
                    </div>
                @else
                    <div class="placeholder-wrapper">
                        <p>Image not found</p>
                    </div>
                @endif
            </div>

            <div class="word-description">
                <p>{{ $challenge->question ?? $challenge->stimulus_data['question'] ?? 'Can you guess what this is?' }}</p>
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
                    <p>Enter your guess below:</p>
                </div>

                <x-player-answer-form placeholder="Your answer here..." />

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
                background: white; border: 1px solid var(--glass-border);
                box-shadow: var(--shadow); border-radius: 20px; overflow: hidden;
                display: flex; justify-content: center; align-items: center; 
                margin-bottom: 1rem; min-height: 400px;
            }
            .image-wrapper { width: 100%; text-align: center; padding: 20px; }
            .game-image { max-width: 100%; max-height: 600px; border-radius: 12px; }
            
            .silhouette-filter {
                filter: brightness(0) contrast(100%);
            }

            .placeholder-wrapper { padding: 4rem; color: var(--text-dim); }

            .word-description { text-align: center; color: var(--text-dim); font-size: 1.1rem; font-weight: 600; margin-top: 1rem; }
            .controls { margin-top: 1.25rem; display: flex; justify-content: center; gap: 1rem; }
            
            .interaction-section { display: grid; grid-template-columns: 1.5fr 1fr; gap: 2.5rem; align-items: start; }
            .question-card {
                background: white; border-radius: 20px; border: 1px solid var(--glass-border);
                box-shadow: var(--shadow); padding: 2rem; display: flex; flex-direction: column; gap: 1.5rem;
            }
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
                background: white; padding: 1rem; border-radius: 12px; border: 1px solid var(--glass-border); 
                border-left: 4px solid var(--stadium-green); box-shadow: 0 4px 12px rgba(0,0,0,0.03);
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

            document.getElementById('submit-btn').addEventListener('click', () => {
                const answer = document.getElementById('answer-input').value;
                if (!answer) return;

                fetch(`{{ route('challenges.check', $challenge->id) }}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ answer })
                })
                .then(r => r.json())
                .then(data => {
                    const feedback = document.getElementById('feedback');
                    feedback.textContent = data.message;
                    feedback.className = 'feedback ' + (data.correct ? 'correct' : 'wrong');
                    feedback.style.display = 'block';
                    if (data.correct) {
                        document.getElementById('submit-btn').disabled = true;
                        highlightSuccess();
                    }
                });
            });

            document.getElementById('hint-btn').addEventListener('click', () => {
                fetch(`{{ route('challenges.hint', $challenge->id) }}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ shown_hints: shownHints })
                })
                .then(r => r.json()).then(data => {
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
                    feedback.textContent = `The answer was: ${data.answer}`;
                    feedback.className = 'feedback revealed';
                    feedback.style.display = 'block';
                    document.getElementById('answer-input').value = data.answer;
                    document.getElementById('submit-btn').disabled = true;
                    highlightSuccess();
                });
            });

            function highlightSuccess() {
                document.querySelector('.question-card').style.borderColor = '#2ea043';
                document.querySelector('.question-card').style.borderWidth = '2px';
            }

            document.getElementById('clear-btn').addEventListener('click', () => {
                document.getElementById('answer-input').value = '';
                document.getElementById('feedback').style.display = 'none';
            });

            initAutocomplete('answer-input', 'autocomplete-list', '{{ route('search.players') }}');
        </script>
    @endpush
@endsection
