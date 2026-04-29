@extends('layouts.app')

@section('content')
    <div class="container play-container">
        {{-- Genre Switcher --}}
        @if($genres->count() > 1)
            <div class="genre-switcher">
                <a href="{{ route('games.play', ['slug' => $game->slug]) }}" 
                   class="genre-tab {{ !$selectedGenre ? 'active' : '' }}">
                    <span class="genre-icon">✨</span>
                    <span class="genre-name">{{ __('All') }}</span>
                </a>
                @foreach($genres as $genre)
                    <a href="{{ route('games.play', ['slug' => $game->slug, 'genre' => $genre->slug]) }}" 
                       class="genre-tab {{ $selectedGenre && $selectedGenre->id === $genre->id ? 'active' : '' }}">
                        <span class="genre-icon">{{ $genre->icon }}</span>
                        <span class="genre-name">{{ $genre->localized_name }}</span>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Navigation Bar --}}
        <div class="game-navigation panel">
            <div class="nav-controls">
                @if($currentLevel > 1)
                    <a href="{{ route('games.play', ['slug' => $game->slug, 'genre' => $selectedGenre?->slug, 'level' => $currentLevel - 1]) }}" class="nav-btn prev">
                        ← {{ __('Previous') }}
                    </a>
                @else
                    <span class="nav-btn disabled">← {{ __('Previous') }}</span>
                @endif

                <div class="level-indicator">
                    <span>{{ __('Challenge') }}</span>
                    <input type="number" id="level-input" value="{{ $currentLevel }}" min="1" max="{{ $totalChallenges }}" 
                           onchange="goToLevel(this.value)">
                    <span class="level-total">{{ __('of') }} {{ $totalChallenges }}</span>
                </div>

                @if($currentLevel < $totalChallenges)
                    <a href="{{ route('games.play', ['slug' => $game->slug, 'genre' => $selectedGenre?->slug, 'level' => $currentLevel + 1]) }}" class="nav-btn next">
                        {{ __('Next') }} →
                    </a>
                @else
                    <span class="nav-btn disabled">{{ __('Next') }} →</span>
                @endif
            </div>
        </div>

        <div class="challenge-context panel">
            <div class="challenge-context-main">
                <span class="badge">{{ app()->getLocale() === 'ar' ? $game->localized_title : strtoupper($game->localized_title) }}</span>
                <h1>{{ $game->localized_title }}</h1>
                <p>{{ $game->localized_description }}</p>
            </div>
            <div class="challenge-context-side">
                <span class="genre-badge">
                    {{ $challenge->genre->icon }} {{ $challenge->genre->localized_name }}
                </span>
                <span class="level-badge">{{ __('Level') }} {{ $currentLevel }} {{ __('of') }} {{ $totalChallenges }}</span>
            </div>
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
                    <p>{{ __('Challenge content not available for type:') }} {{ $challenge->stimulus_type }}</p>
                </div>
            @endif

            <div class="controls">
                <a href="{{ route('games.play', ['slug' => $game->slug]) }}" class="btn btn-outline">
                    {{ __('Try Another Challenge') }}
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
            .play-container {
                display: flex;
                flex-direction: column;
                gap: 1.25rem;
            }

            .game-navigation { 
                padding: 1rem 1.2rem; 
                display: flex;
                justify-content: center;
            }
            
            .genre-switcher {
                display: flex;
                gap: 0.75rem;
                justify-content: flex-start;
                flex-wrap: wrap;
                padding: 0.5rem;
                background: rgba(var(--surface-rgb), 0.35);
                border-radius: 22px;
                border: 1px solid var(--border-soft);
                backdrop-filter: blur(16px);
                overflow-x: auto;
                scrollbar-width: none;
            }

            .genre-switcher::-webkit-scrollbar { display: none; }

            .genre-tab {
                display: flex;
                align-items: center;
                gap: 0.6rem;
                padding: 0.6rem 1.2rem;
                background: rgba(var(--surface-rgb), 0.58);
                border: 1px solid var(--border-soft);
                border-radius: 999px;
                text-decoration: none;
                color: var(--text-muted);
                font-weight: 700;
                transition: all 0.25s ease;
            }

            .genre-tab:hover {
                transform: translateY(-2px);
                border-color: rgba(59, 130, 246, 0.3);
                color: var(--text);
            }

            .genre-tab.active {
                background: linear-gradient(135deg, var(--accent), var(--accent-strong));
                border-color: transparent;
                color: white;
                box-shadow: 0 12px 28px rgba(37, 99, 235, 0.24);
            }

            .genre-icon {
                font-size: 1.2rem;
            }

            .challenge-context {
                display: grid;
                grid-template-columns: minmax(0, 1fr) auto;
                gap: 1rem;
                align-items: end;
                padding: 1.3rem 1.4rem;
                background: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(16, 185, 129, 0.08)), var(--surface);
            }

            .challenge-context-main h1 {
                font-family: var(--font-display);
                font-size: clamp(1.7rem, 4vw, 2.6rem);
                line-height: 1;
                letter-spacing: -0.04em;
                margin: 0.8rem 0 0.55rem;
            }

            .challenge-context-main p {
                color: var(--text-muted);
                max-width: 62ch;
            }

            .challenge-context-side {
                display: grid;
                gap: 0.65rem;
                justify-items: end;
            }

            .genre-badge {
                background: rgba(var(--surface-rgb), 0.65);
                color: var(--text-muted);
                padding: 0.4rem 1rem;
                border-radius: 50px;
                font-size: 0.85rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                border: 1px solid var(--border-soft);
            }

            .level-badge {
                display: inline-flex;
                align-items: center;
                padding: 0.45rem 0.9rem;
                border-radius: 999px;
                background: rgba(59, 130, 246, 0.1);
                color: var(--accent-strong);
                font-size: 0.82rem;
                font-weight: 800;
                letter-spacing: 0.05em;
                text-transform: uppercase;
            }

            .nav-controls {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                max-width: 920px;
                gap: 1rem;
            }

            .nav-btn { 
                padding: 0.75rem 1rem;
                border-radius: 16px;
                font-weight: 800;
                color: var(--text-muted); 
                text-decoration: none;
                border: 1px solid var(--border-soft);
                transition: all 0.25s ease;
                display: flex; align-items: center; gap: 0.5rem;
                background: rgba(var(--surface-rgb), 0.56);
            }

            .nav-btn:hover:not(.disabled) { 
                background: rgba(59, 130, 246, 0.12);
                border-color: rgba(59, 130, 246, 0.32);
                color: white;
                transform: translateY(-2px);
                color: var(--text);
            }

            .nav-btn.disabled {
                opacity: 0.45;
                cursor: not-allowed;
                background: rgba(var(--surface-rgb), 0.3);
            }
            
            .level-indicator { 
                display: flex;
                align-items: center;
                gap: 0.8rem; 
                font-size: 1.02rem;
                font-weight: 800;
                color: var(--text);
                background: rgba(var(--surface-rgb), 0.6);
                padding: 0.5rem 1.2rem;
                border-radius: 999px;
                border: 1px solid var(--border-soft);
            }

            #level-input { 
                width: 70px;
                padding: 0.35rem;
                border-radius: 12px;
                border: 1px solid var(--border-strong);
                text-align: center;
                font-weight: 900;
                color: var(--accent-strong);
                background: var(--surface-strong);
                transition: all 0.2s;
            }

            #level-input:focus {
                border-color: rgba(59, 130, 246, 0.42);
                outline: none;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
            }

            .level-total {
                opacity: 0.75;
                font-weight: 700;
                font-size: 0.95rem;
                color: var(--text-soft);
            }

            .visual-section { width: 100%; }

            .interaction-section {
                display: grid;
                grid-template-columns: minmax(0, 1.45fr) minmax(300px, 0.8fr);
                gap: 1.5rem;
                align-items: start;
            }

            .controls {
                margin-top: 1rem;
                display: flex;
                justify-content: center;
                gap: 1rem;
                flex-wrap: wrap;
            }

            .controls .btn,
            .controls .bookmark-btn {
                min-height: 3.1rem;
            }
            
            @media (max-width: 900px) {
                .interaction-section {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 760px) {
                .play-container {
                    gap: 1rem;
                }

                .genre-switcher {
                    flex-wrap: nowrap;
                    padding: 0.45rem;
                }

                .genre-tab {
                    flex: 0 0 auto;
                    padding: 0.65rem 1rem;
                }

                .game-navigation {
                    padding: 0.85rem;
                }

                .challenge-context {
                    grid-template-columns: 1fr;
                    padding: 1rem;
                }

                .challenge-context-side {
                    justify-items: start;
                }

                .challenge-context-main h1 {
                    font-size: clamp(1.45rem, 7vw, 2rem);
                    margin: 0.7rem 0 0.45rem;
                }

                .challenge-context-main p {
                    font-size: 0.95rem;
                }

                .nav-controls {
                    flex-direction: column;
                    align-items: stretch;
                    gap: 0.75rem;
                }

                .level-indicator {
                    justify-content: center;
                    flex-wrap: wrap;
                    width: 100%;
                    border-radius: 20px;
                    padding: 0.8rem 0.9rem;
                }

                .nav-btn {
                    justify-content: center;
                    width: 100%;
                }

                #level-input {
                    width: 84px;
                    min-height: 2.6rem;
                }

                .controls {
                    flex-direction: column-reverse;
                    align-items: stretch;
                    gap: 0.75rem;
                }

                .controls .bookmark-btn,
                .controls .btn {
                    width: 100%;
                    justify-content: center;
                    border-radius: 18px;
                }

                .controls .bookmark-btn {
                    height: auto;
                }
            }

            @media (max-width: 520px) {
                .genre-name {
                    font-size: 0.9rem;
                }

                .genre-icon {
                    font-size: 1rem;
                }

                .level-indicator {
                    gap: 0.6rem;
                    font-size: 0.96rem;
                }

                .visual-section {
                    width: 100%;
                }
            }
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
                    const searchUrlTemplate = @json(route('search.unified', ['type' => '__TYPE__']));
                    const searchUrl = searchUrlTemplate.replace('__TYPE__', answerType);
                    initAutocomplete('answer-input', 'autocomplete-list', searchUrl);
                }
            }

            // 2. Standard Interaction Logic
            document.getElementById('submit-btn').addEventListener('click', () => {
                const answerInput = document.getElementById('answer-input');
                const answer = answerInput.value;
                if (!answer) return;

                const revealedOrders = window.revealedOrders || [];

                fetch(`{{ route('challenges.check', ['challenge' => $challenge->id]) }}`, {
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
                fetch(`{{ route('challenges.hint', ['challenge' => $challenge->id]) }}`, {
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
                fetch(`{{ route('challenges.reveal', ['challenge' => $challenge->id]) }}`)
                .then(r => r.json())
                .then(data => {
                    const feedback = document.getElementById('feedback');
                    if (data.answers) {
                        feedback.textContent = `{{ __('Answers:') }} ${data.answers.join(', ')}`;
                    } else {
                        feedback.textContent = `{{ __('The answer was:') }} ${data.answer}`;
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
                clearAutocomplete('answer-input', 'autocomplete-list');
                document.getElementById('feedback').style.display = 'none';
            });
        </script>
    @endpush
@endsection
