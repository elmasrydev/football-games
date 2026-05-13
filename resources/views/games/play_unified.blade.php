@extends('layouts.app')

@php
    $themeColor = $challenge->genre->theme_color ?: '#3b82f6';
@endphp

@section('content')
    <style>
        :root {
            --color-primary:
                {{ $themeColor }}
                !important;
            --color-primary-container:
                {{ $themeColor }}
                20 !important;
            --color-on-primary-container:
                {{ $themeColor }}
                !important;
        }

        body {
            background-attachment: fixed !important;
            background-image:
                radial-gradient(circle at 5% 5%,
                    {{ $themeColor }}
                    15 0%, transparent 35%),
                radial-gradient(circle at 95% 95%,
                    {{ $themeColor }}
                    15 0%, transparent 35%),
                radial-gradient(circle at 50% 50%,
                    {{ $themeColor }}
                    05 0%, transparent 60%) !important;
        }

        nav {
            border-bottom-color:
                {{ $themeColor }}
                30 !important;
            background-color: color-mix(in srgb, var(--color-surface),
                    {{ $themeColor }}
                    5%) !important;
            backdrop-blur: 20px !important;
        }

        .glass-card {
            border-color:
                {{ $themeColor }}
                40 !important;
            background-color:
                {{ $themeColor }}
                33 !important;
            backdrop-filter: blur(24px) !important;
        }

        .dark .glass-card {
            background-color:
                {{ $themeColor }}
                4D !important;
        }

        .neon-border-theme {
            border-color:
                {{ $themeColor }}
                60 !important;
            box-shadow: 0 0 30px
                {{ $themeColor }}
                30 !important;
        }

        /* Update selection color to match theme */
        ::selection {
            background-color:
                {{ $themeColor }}
                40 !important;
            color: inherit !important;
        }

        /* Transition for theme switching */
        * {
            transition: border-color 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                background-color 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                color 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 space-y-6 pb-20" style="--genre-theme: {{ $themeColor }};">

        <!-- Header & Navigation -->
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 py-4">
            <div class="space-y-4">
                <div class="flex flex-wrap items-center gap-3">
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[var(--genre-theme)]/10 border border-[var(--genre-theme)]/20 text-[var(--genre-theme)] text-[10px] font-display font-black uppercase tracking-[0.2em]">
                        {{ $game->localized_title }}
                    </span>
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary/10 border border-secondary/20 text-secondary text-[10px] font-display font-black uppercase tracking-[0.2em]">
                        <span class="text-sm">{{ $challenge->genre->icon ?? '🧩' }}</span>
                        {{ $challenge->genre->getLocalizedNameAttribute() }}
                    </span>
                </div>
                <h1
                    class="text-3xl sm:text-4xl font-display font-black uppercase tracking-tight text-on-background line-clamp-1">
                    {{ $challenge->title ?? $game->localized_title }}
                </h1>
            </div>

            <!-- Level Navigation -->
            <div
                class="glass-card flex items-center justify-between p-2 rounded-2xl border-outline-variant/20 min-w-[320px]">
                @if($currentLevel > 1)
                    <a href="{{ route('games.play', ['slug' => $game->slug, 'genre' => $selectedGenre?->slug, 'level' => $currentLevel - 1]) }}"
                        class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors active:scale-90">
                        <span class="material-symbols-outlined rtl:rotate-180">arrow_back</span>
                    </a>
                @else
                    <div
                        class="w-10 h-10 rounded-xl bg-primary/5 flex items-center justify-center text-on-surface-variant/30 cursor-not-allowed">
                        <span class="material-symbols-outlined rtl:rotate-180">arrow_back</span>
                    </div>
                @endif

                <div class="flex items-center gap-3 px-4">
                    <span
                        class="text-[10px] font-display font-black uppercase tracking-widest text-on-surface-variant opacity-60">{{ __('Level') }}</span>
                    <input type="number" id="level-input" value="{{ $currentLevel }}" min="1" max="{{ $totalChallenges }}"
                        onchange="goToLevel(this.value)"
                        class="w-16 bg-primary/10 border border-outline-variant/30 rounded-lg text-center font-display font-black text-primary py-1 focus:outline-none focus:border-primary transition-all">
                    <span
                        class="text-[10px] font-display font-black uppercase tracking-widest text-on-surface-variant opacity-60">{{ __('of') }}
                        {{ $totalChallenges }}</span>
                </div>

                @if($currentLevel < $totalChallenges)
                    <a href="{{ route('games.play', ['slug' => $game->slug, 'genre' => $selectedGenre?->slug, 'level' => $currentLevel + 1]) }}"
                        class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors active:scale-90">
                        <span class="material-symbols-outlined rtl:rotate-180">arrow_forward</span>
                    </a>
                @else
                    <div
                        class="w-10 h-10 rounded-xl bg-primary/5 flex items-center justify-center text-on-surface-variant/30 cursor-not-allowed">
                        <span class="material-symbols-outlined rtl:rotate-180">arrow_forward</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Genre Switcher -->
        @if($genres->count() > 1)
            <div class="flex items-center gap-3 overflow-x-auto pb-4 scrollbar-none">
                <a href="{{ route('games.play', ['slug' => $game->slug]) }}"
                    class="flex-none flex items-center gap-2 px-6 py-3 rounded-full font-display font-bold text-xs uppercase tracking-widest transition-all {{ !$selectedGenre ? 'bg-[var(--genre-theme)] text-on-primary shadow-lg shadow-[var(--genre-theme)]/20' : 'glass-card text-on-surface-variant hover:text-[var(--genre-theme)]' }}">
                    <span class="text-lg">🌐</span>
                    {{ __('All') }}
                </a>
                @foreach($genres as $genre)
                    @php
                        $gTheme = $genre->theme_color ?: '#3b82f6';
                    @endphp
                    <a href="{{ route('games.play', ['slug' => $game->slug, 'genre' => $genre->slug]) }}"
                        class="flex-none flex items-center gap-2 px-6 py-3 rounded-full font-display font-bold text-xs uppercase tracking-widest transition-all {{ $selectedGenre && $selectedGenre->id === $genre->id ? 'text-on-primary shadow-lg shadow-[var(--genre-theme)]/20' : 'glass-card text-on-surface-variant hover:text-primary' }}"
                        style="{{ $selectedGenre && $selectedGenre->id === $genre->id ? 'background: ' . $gTheme . ';' : '' }}">
                        <span class="text-lg">{{ $genre->icon ?? '🧩' }}</span>
                        {{ $genre->getLocalizedNameAttribute() }}
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Game Arena -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Main Column (Puzzle & Answer) -->
            <div class="lg:col-span-8 xl:col-span-9 space-y-8">
                <!-- Puzzle Area -->
                <div class="glass-card rounded-[2.5rem] overflow-hidden relative border-outline-variant/10 shadow-2xl">
                    {{-- Dynamic Stimulus Block --}}
                    @if($game->slug !== 'terminology-trivia')
                        <div
                            class="{{ $challenge->stimulus_type === 'video' ? 'aspect-video' : '' }} flex items-center justify-center p-2">
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
                                <div class="text-center p-12">
                                    <span class="material-symbols-outlined text-6xl text-on-surface-variant/20 mb-4">error</span>
                                    <p class="text-on-surface-variant font-display font-bold uppercase tracking-widest">
                                        {{ __('Content not available') }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Overlay Actions -->
                    @if($game->slug !== 'terminology-trivia')
                        <div class="absolute top-6 end-6 z-20 flex flex-col gap-3">
                            <button
                                class="w-12 h-12 rounded-full glass-card flex items-center justify-center text-on-surface-variant hover:text-[var(--genre-theme)] shadow-lg hover:scale-110 transition-all active:scale-90"
                                onclick="toggleBookmark({{ $game->id }})" data-id="{{ $game->id }}">
                                <span class="material-symbols-outlined transition-colors">bookmark</span>
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Answer Block -->
                <div
                    class="glass-card rounded-[2.5rem] p-6 sm:p-8 border-[var(--genre-theme)]/20 shadow-xl relative overflow-hidden bg-gradient-to-b from-[var(--genre-theme)]/5 to-transparent">
                    <!-- Cyber Background Detail -->
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-[var(--genre-theme)]/5 rounded-full blur-3xl -mr-32 -mt-32">
                    </div>

                    <div class="relative z-10 space-y-6 max-w-3xl mx-auto">
                        @if($game->slug === 'terminology-trivia')
                            <div class="absolute top-0 end-0">
                                <button
                                    class="w-10 h-10 rounded-full glass-card flex items-center justify-center text-on-surface-variant hover:text-[var(--genre-theme)] shadow-lg hover:scale-110 transition-all active:scale-90"
                                    onclick="toggleBookmark({{ $game->id }})" data-id="{{ $game->id }}">
                                    <span class="material-symbols-outlined transition-colors">bookmark</span>
                                </button>
                            </div>
                        @endif
                        <div class="text-center space-y-1">
                            <span
                                class="text-[9px] font-display font-black text-[var(--genre-theme)] uppercase tracking-[0.4em] block">{{ __('Interaction') }}</span>
                            <h2 class="text-2xl font-display font-black uppercase tracking-tight">{{ __('Your Answer') }}
                            </h2>
                        </div>

                        {{-- Dynamic Interaction Block --}}
                        <div id="interaction-root" class="w-full">
                            @if($game->slug === 'group-players')
                                <x-games.interaction.group :challenge="$challenge" :game="$game" />
                            @else
                                <x-games.interaction.standard :challenge="$challenge" :game="$game" />
                            @endif
                        </div>

                        @if($game->slug === 'anagram-arena' || $game->slug === 'vowel-void')
                            <div class="mt-6 p-6 rounded-3xl bg-primary/5 border border-primary/10 text-center">
                                <span
                                    class="text-[9px] font-display font-black text-on-surface-variant/40 uppercase tracking-[0.4em] block mb-3">{{ __('Word Structure') }}</span>
                                <div class="flex flex-wrap justify-center gap-4 text-2xl font-display font-black text-[var(--genre-theme)] tracking-[0.3em]"
                                    dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                    @php
                                        $answer = $challenge->answer;
                                        $words = explode(' ', $answer);
                                    @endphp
                                    @foreach($words as $word)
                                        <div class="flex gap-1">
                                            @php
                                                $len = mb_strlen($word);
                                            @endphp
                                            @for($i = 0; $i < $len; $i++)
                                                <span class="border-b-4 border-[var(--genre-theme)]/30 w-6 pb-1 inline-block">ـ</span>
                                            @endfor
                                        </div>
                                        @if(!$loop->last)
                                            <span class="text-on-surface-variant/30">/</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div
                            class="pt-6 border-t border-outline-variant/10 flex flex-wrap items-center justify-center gap-6">
                            <button id="give-up-btn"
                                class="text-on-surface-variant hover:text-error font-display font-bold text-xs uppercase tracking-[0.2em] transition-colors flex items-center gap-2">
                                <span class="text-lg">👁️</span>
                                {{ __('Reveal Answer') }}
                            </button>
                        </div>
                    </div>

                    <!-- Feedback Area -->
                    <div id="feedback" class="mt-6 hidden"></div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="lg:col-span-4 xl:col-span-3 space-y-6">
                <!-- How to Play Area -->
                @if($game->localized_how_to_play)
                    <div
                        class="glass-card rounded-[2rem] overflow-hidden flex flex-col border-[var(--genre-theme)]/10 bg-gradient-to-br from-[var(--genre-theme)]/5 to-transparent">
                        <div
                            class="p-4 bg-[var(--genre-theme)]/5 border-b border-[var(--genre-theme)]/10 flex items-center gap-3">
                            <span class="text-xl">📖</span>
                            <h3 class="text-xs font-display font-black text-on-surface uppercase tracking-widest">
                                {{ __('How to Play') }}</h3>
                        </div>
                        <div class="p-6">
                            <div
                                class="prose prose-xs dark:prose-invert text-on-surface-variant font-sans font-medium leading-relaxed opacity-80">
                                {!! nl2br(e($game->localized_how_to_play)) !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Hints Area -->
                <div class="glass-card rounded-[2rem] overflow-hidden flex flex-col border-outline-variant/10">
                    <div class="p-4 bg-secondary/5 border-b border-secondary/10 flex items-center gap-3">
                        <span class="text-xl">💡</span>
                        <h3 class="text-xs font-display font-black text-on-surface uppercase tracking-widest">
                            {{ __('Hints & Rescue') }}</h3>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="text-center space-y-4">
                            <p class="text-xs text-on-surface-variant font-medium leading-relaxed opacity-70">
                                {{ __('Stuck on this level? Reveal a hint one by one.') }}
                            </p>
                            <button id="hint-btn"
                                class="w-full py-4 bg-[var(--genre-theme)] text-on-primary rounded-2xl font-display font-black uppercase tracking-widest text-xs hover:brightness-110 transition-all shadow-lg shadow-[var(--genre-theme)]/20 active:scale-95">
                                {{ __('Unlock Hint') }}
                            </button>
                        </div>

                        <!-- Hints List -->
                        <div id="hints-display" class="space-y-4 pt-4 border-t border-outline-variant/10">
                            <!-- Hints will be appended here -->
                        </div>
                    </div>
                </div>

                <!-- Ad/Promo Spot -->
                <div
                    class="glass-card rounded-[2rem] p-6 border-[var(--genre-theme)]/10 bg-gradient-to-br from-[var(--genre-theme)]/5 to-transparent">
                    <span
                        class="text-[9px] font-display font-black bg-[var(--genre-theme)] text-on-primary px-2 py-0.5 rounded-full uppercase tracking-widest mb-3 inline-block">{{ __('Pro Benefit') }}</span>
                    <h4 class="text-sm font-display font-black text-on-surface leading-tight uppercase mb-2">
                        {{ __('Infinite Hints with Gamesiano Pro') }}</h4>
                    <p class="text-[10px] text-on-surface-variant mb-4 opacity-60">
                        {{ __('Never get stuck again. Get unlimited hints and no ads.') }}</p>
                    <button
                        class="w-full py-2.5 bg-white/5 hover:bg-white/10 text-white font-display font-bold rounded-xl uppercase tracking-widest text-[9px] transition-all border border-white/10">
                        {{ __('Upgrade Now') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const challengeId = {{ $challenge->id }};
            const csrfToken = '{{ csrf_token() }}';
            const currentLevel = {{ $currentLevel }};
            const totalChallenges = {{ $totalChallenges }};

            const prevLevelUrl = '{{ $currentLevel > 1 ? route('games.play', ['slug' => $game->slug, 'genre' => $selectedGenre?->slug, 'level' => $currentLevel - 1]) : '#' }}';

            let shownHints = [];

            function goToLevel(level) {
                const url = new URL(window.location.href);
                url.searchParams.set('level', level);
                window.location.href = url.toString();
            }

            function showFeedback(message, isCorrect, showNext = false) {
                const feedback = document.getElementById('feedback');
                if (!feedback) return;

                let content = `<span>${message}</span>`;

                if (showNext && currentLevel > 1) {
                    content = `
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 w-full">
                            <span>${message}</span>
                            <a href="${prevLevelUrl}" class="flex items-center gap-2 px-6 py-2 bg-[var(--genre-theme)] text-on-primary rounded-xl font-display font-black uppercase tracking-widest text-[10px] hover:brightness-110 transition-all shadow-lg shadow-[var(--genre-theme)]/20 active:scale-95">
                                {{ __('Next Level') }}
                                <span class="material-symbols-outlined text-sm rtl:rotate-180">arrow_back</span>
                            </a>
                        </div>
                    `;
                }

                feedback.innerHTML = content;
                feedback.classList.remove('hidden', 'correct', 'wrong', 'revealed');
                feedback.className = 'p-4 rounded-xl font-display font-bold text-sm uppercase tracking-wide transition-all feedback ' +
                    (isCorrect ? 'bg-tertiary/10 text-tertiary border border-tertiary/20' : 'bg-error/10 text-error border border-error/20');
                feedback.style.display = 'block';
            }
            window.showFeedback = showFeedback;

            document.addEventListener('DOMContentLoaded', () => {
                const answerInput = document.getElementById('answer-input');
                if (answerInput) {
                    const answerType = answerInput.dataset.answerType;
                    if (answerType && ['player', 'club', 'stadium', 'actor', 'movie', 'term'].includes(answerType)) {
                        const searchUrlTemplate = @json(route('search.unified', ['type' => '__TYPE__']));
                        const searchUrl = searchUrlTemplate.replace('__TYPE__', answerType);
                        if (typeof initAutocomplete === 'function') {
                            initAutocomplete('answer-input', 'autocomplete-list', searchUrl);
                        }
                    }
                }

                if (typeof updateBookmarkUI === 'function') {
                    updateBookmarkUI({{ $game->id }});
                }
            });

            const submitBtn = document.getElementById('submit-btn');
            const answerInput = document.getElementById('answer-input');

            if (submitBtn) {
                submitBtn.addEventListener('click', () => {
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
                            showFeedback(data.message, data.correct, data.correct);

                            if (data.stats && typeof window.updateHUD === 'function') {
                                window.updateHUD(data.stats);
                            }

                            if (data.correct) {
                                if (window.updateProgress && data.matched_sort_order !== undefined) {
                                    window.updateProgress(answer, data.matched_sort_order);
                                    answerInput.value = '';
                                } else {
                                    submitBtn.disabled = true;
                                    submitBtn.classList.add('opacity-50');
                                    if (window.highlightSuccess) window.highlightSuccess();
                                }
                            }
                        });
                });
            }

            const hintBtn = document.getElementById('hint-btn');
            if (hintBtn) {
                hintBtn.addEventListener('click', () => {
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
                                hintDiv.className = 'glass-card p-4 rounded-2xl border-secondary/20 flex items-start gap-4 animate-in slide-in-from-top-4 duration-500 shadow-xl';
                                hintDiv.innerHTML = `
                                <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                                    <span class="text-sm">🎯</span>
                                </div>
                                <div>
                                    <span class="text-[8px] font-display font-black text-secondary uppercase tracking-widest block mb-1">{{ __('Hint') }} ${shownHints.length}</span>
                                    <p class="text-[11px] font-medium text-on-surface leading-relaxed">${data.hint}</p>
                                </div>
                            `;
                                document.getElementById('hints-display').prepend(hintDiv);
                            } else {
                                alert(data.message);
                            }
                        });
                });
            }

            const giveUpBtn = document.getElementById('give-up-btn');
            if (giveUpBtn) {
                giveUpBtn.addEventListener('click', () => {
                    fetch(`{{ route('challenges.reveal', ['challenge' => $challenge->id]) }}`)
                        .then(r => r.json())
                        .then(data => {
                            let msg = '';
                            if (data.answers) {
                                msg = `{{ __('Answers:') }} ${data.answers.join(', ')}`;
                            } else {
                                msg = `{{ __('The answer was:') }} ${data.answer}`;
                                if (answerInput) answerInput.value = data.answer;
                            }

                            showFeedback(msg, true, true);
                            if (submitBtn) submitBtn.disabled = true;
                            if (window.highlightSuccess) window.highlightSuccess();
                        });
                });
            }

            function highlightSuccess() {
                const img = document.getElementById('challenge-image');
                if (img) {
                    img.classList.remove('silhouette-filter');
                    const revealSrc = img.dataset.reveal;
                    if (revealSrc) img.src = revealSrc;
                }

                const arena = document.querySelector('.glass-card');
                if (arena) {
                    arena.classList.add('neon-border-theme');
                }
            }
            window.highlightSuccess = highlightSuccess;

            const clearBtn = document.getElementById('clear-btn');
            if (clearBtn) {
                clearBtn.addEventListener('click', () => {
                    if (typeof clearAutocomplete === 'function') {
                        clearAutocomplete('answer-input', 'autocomplete-list');
                    }
                    const feedback = document.getElementById('feedback');
                    if (feedback) {
                        feedback.classList.add('hidden');
                        feedback.style.display = 'none';
                    }
                });
            }
        </script>
    @endpush
@endsection