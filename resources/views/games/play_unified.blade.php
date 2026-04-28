@extends('layouts.app')

@section('content')
    <div class="container play-container">
        {{-- Genre Switcher --}}
        @if($genres->count() > 1)
            <div class="genre-switcher">
                <a href="{{ route('games.play', ['slug' => $game->slug]) }}" 
                   class="genre-tab {{ !$selectedGenre ? 'active' : '' }}">
                    <span class="genre-icon">✨</span>
                    <span class="genre-name">All</span>
                </a>
                @foreach($genres as $genre)
                    <a href="{{ route('games.play', ['slug' => $game->slug, 'genre' => $genre->slug]) }}" 
                       class="genre-tab {{ $selectedGenre && $selectedGenre->id === $genre->id ? 'active' : '' }}">
                        <span class="genre-icon">{{ $genre->icon }}</span>
                        <span class="genre-name">{{ $genre->name_en }}</span>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Navigation Bar --}}
        <div class="game-navigation">
            <div class="nav-controls">
                @if($currentLevel > 1)
                    <a href="{{ route('games.play', ['slug' => $game->slug, 'genre' => $selectedGenre?->slug, 'level' => $currentLevel - 1]) }}" class="nav-btn prev">
                        ← Previous
                    </a>
                @else
                    <span class="nav-btn disabled">← Previous</span>
                @endif

                <div class="level-indicator">
                    <span>Challenge</span>
                    <input type="number" id="level-input" value="{{ $currentLevel }}" min="1" max="{{ $totalChallenges }}" 
                           onchange="goToLevel(this.value)">
                    <span class="level-total">of {{ $totalChallenges }}</span>
                </div>

                @if($currentLevel < $totalChallenges)
                    <a href="{{ route('games.play', ['slug' => $game->slug, 'genre' => $selectedGenre?->slug, 'level' => $currentLevel + 1]) }}" class="nav-btn next">
                        Next →
                    </a>
                @else
                    <span class="nav-btn disabled">Next →</span>
                @endif
            </div>
        </div>

        <div class="challenge-context">
            <span class="genre-badge">
                {{ $challenge->genre->icon }} {{ $challenge->genre->name_en }}
            </span>
        </div>

        <div class="visual-section">
            {{-- Dynamic Stimulus Block --}}
            @if($challenge->stimulus_type === 'image')
                <x-games.stimulus.image :challenge="$challenge" :game="$game" />
            @elseif($challenge->stimulus_type === 'video')
                <x-games.stimulus.video :challenge="$challenge" :game="$game" />
            @elseif($challenge->stimulus_type === 'text')
                <x-games.stimulus.text :challenge="$challenge" :game="$game" />
            @elseif($challenge->stimulus_type === 'scrambled_text')
                <x-games.stimulus.scrambled :challenge="$challenge" :game="$game" />
            @elseif($challenge->stimulus_type === 'sequence')
                <x-games.stimulus.sequence :challenge="$challenge" :game="$game" />
            @else
                <div class="visual-box">
                    <p>Challenge content not available for type: {{ $challenge->stimulus_type }}</p>
                </div>
            @endif

            <div class="controls">
                <a href="{{ route('games.play', $game->slug) }}" class="btn btn-outline">
                    Try Another Challenge
                </a>
                <x-bookmark-button :gameId="$game->id" />
            </div>
        </div>

        <div class="interaction-section">
            {{-- Dynamic Interaction Block --}}
            @if($game->slug === 'group-players')
                <x-games.interaction.group :challenge="$challenge" :game="$game" />
            @else
                <x-games.interaction.standard :challenge="$challenge" :game="$game" />
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            .play-container { display: flex; flex-direction: column; gap: 1.5rem; }
            .game-navigation { 
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.3);
                border-radius: 16px; 
                padding: 1rem 2rem; 
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
                margin-bottom: 1rem;
                display: flex;
                justify-content: center;
            }
            
            .genre-switcher {
                display: flex;
                gap: 0.8rem;
                justify-content: center;
                margin-bottom: 0.5rem;
                padding: 0.5rem;
                background: rgba(255, 255, 255, 0.4);
                border-radius: 14px;
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .genre-tab {
                display: flex;
                align-items: center;
                gap: 0.6rem;
                padding: 0.6rem 1.2rem;
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                text-decoration: none;
                color: #4a5568;
                font-weight: 700;
                transition: all 0.3s ease;
                box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            }

            .genre-tab:hover {
                transform: translateY(-2px);
                border-color: var(--stadium-green);
                color: var(--stadium-green);
            }

            .genre-tab.active {
                background: var(--stadium-green);
                border-color: var(--stadium-green);
                color: white;
                box-shadow: 0 4px 12px rgba(46, 160, 67, 0.2);
            }

            .genre-icon {
                font-size: 1.2rem;
            }

            .challenge-context {
                display: flex;
                justify-content: center;
                margin-top: -0.5rem;
                margin-bottom: 1rem;
            }

            .genre-badge {
                background: #f1f5f9;
                color: #475569;
                padding: 0.4rem 1rem;
                border-radius: 50px;
                font-size: 0.85rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                border: 1px solid #e2e8f0;
                box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            }
            .nav-controls { display: flex; justify-content: space-between; align-items: center; width: 100%; max-width: 800px; }
            .nav-btn { 
                padding: 0.6rem 1.2rem; border-radius: 10px; font-weight: 700; color: #4a5568; 
                text-decoration: none; border: 1px solid #e2e8f0; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                display: flex; align-items: center; gap: 0.5rem;
                background: white;
            }
            .nav-btn:hover:not(.disabled) { 
                background: var(--stadium-green); 
                border-color: var(--stadium-green); 
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(46, 160, 67, 0.2);
            }
            .nav-btn.disabled { opacity: 0.3; cursor: not-allowed; background: #f7fafc; }
            
            .level-indicator { 
                display: flex; align-items: center; gap: 0.8rem; 
                font-size: 1.1rem; font-weight: 800; color: #2d3748;
                background: #f1f5f9; padding: 0.4rem 1.2rem; border-radius: 50px;
            }
            #level-input { 
                width: 70px; padding: 0.3rem; border-radius: 8px; border: 2px solid transparent;
                text-align: center; font-weight: 900; color: var(--stadium-green);
                background: white; transition: all 0.2s;
            }
            #level-input:focus { border-color: var(--stadium-green); outline: none; box-shadow: 0 0 0 3px rgba(46, 160, 67, 0.1); }
            .level-total { opacity: 0.6; font-weight: 600; font-size: 0.95rem; }

            .visual-section { width: 100%; }
            .interaction-section { display: grid; grid-template-columns: 1.5fr 1fr; gap: 2.5rem; align-items: start; }
            .controls { margin-top: 2rem; display: flex; justify-content: center; gap: 1rem; }
            
            @media (max-width: 900px) { .interaction-section { grid-template-columns: 1fr; } }
        </style>
    @endpush

    @push('scripts')
        <script>
            const challengeId = {{ $challenge->id }};
            const csrfToken = '{{ csrf_token() }}';
            let shownHints = [];

            // Level jump logic
            function goToLevel(level) {
                const url = new URL(window.location.href);
                url.searchParams.set('level', level);
                window.location.href = url.toString();
            }

            // 1. Initialize Autocomplete
            const answerInput = document.getElementById('answer-input');
            if (answerInput) {
                const answerType = answerInput.dataset.answerType;
                if (answerType && ['player', 'club', 'stadium', 'actor', 'movie'].includes(answerType)) {
                    const searchUrl = `{{ url('/search') }}/${answerType}`;
                    initAutocomplete('answer-input', 'autocomplete-list', searchUrl);
                }
            }

            // 2. Standard Interaction Logic
            document.getElementById('submit-btn').addEventListener('click', () => {
                const answerInput = document.getElementById('answer-input');
                const answer = answerInput.value;
                if (!answer) return;

                const revealedOrders = window.revealedOrders || [];

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
                        if (window.updateProgress && data.matched_sort_order !== undefined) {
                            window.updateProgress(answer, data.matched_sort_order);
                            answerInput.value = '';
                        } else {
                            document.getElementById('submit-btn').disabled = true;
                            if (window.highlightSuccess) window.highlightSuccess();
                        }
                    }
                });
            });

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
                    if (window.highlightSuccess) window.highlightSuccess();
                });
            });

            function highlightSuccess() {
                const card = document.querySelector('.question-card');
                if (card) {
                    card.style.borderColor = '#2ea043';
                    card.style.borderWidth = '2px';
                    card.style.boxShadow = '0 0 20px rgba(46, 160, 67, 0.2)';
                }

                // Reveal image logic
                const img = document.getElementById('challenge-image');
                if (img) {
                    img.classList.remove('silhouette-filter');
                    const revealSrc = img.dataset.reveal;
                    if (revealSrc) {
                        img.src = revealSrc;
                    }
                }
            }
            window.highlightSuccess = highlightSuccess;

            document.getElementById('clear-btn').addEventListener('click', () => {
                document.getElementById('answer-input').value = '';
                document.getElementById('feedback').style.display = 'none';
            });
        </script>
    @endpush
@endsection
