@extends('layouts.app')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-8 space-y-6 pb-20">
    
    <!-- Header & Navigation -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 py-4">
        <div class="space-y-4">
            <div class="flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 text-primary text-[10px] font-display font-black uppercase tracking-[0.2em]">
                    {{ $game->localized_title }}
                </span>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary/10 border border-secondary/20 text-secondary text-[10px] font-display font-black uppercase tracking-[0.2em]">
                    <span class="text-sm">{{ $challenge->genre->icon ?? '🧩' }}</span>
                    {{ $challenge->genre->getLocalizedNameAttribute() }}
                </span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-display font-black uppercase tracking-tight text-on-background line-clamp-1">
                {{ $challenge->title ?? $game->localized_title }}
            </h1>
        </div>

        <!-- Level Navigation -->
        <div class="glass-card flex items-center justify-between p-2 rounded-2xl border-outline-variant/20 min-w-[320px]">
            @if($currentLevel > 1)
                <a href="{{ route('games.play', ['slug' => $game->slug, 'genre' => $selectedGenre?->slug, 'level' => $currentLevel - 1]) }}" 
                   class="w-10 h-10 rounded-xl bg-surface-variant/50 flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors active:scale-90">
                    <span class="material-symbols-outlined rtl:rotate-180">arrow_back</span>
                </a>
            @else
                <div class="w-10 h-10 rounded-xl bg-surface-variant/20 flex items-center justify-center text-on-surface-variant/30 cursor-not-allowed">
                    <span class="material-symbols-outlined rtl:rotate-180">arrow_back</span>
                </div>
            @endif

            <div class="flex items-center gap-3 px-4">
                <span class="text-[10px] font-display font-black uppercase tracking-widest text-on-surface-variant opacity-60">{{ __('Level') }}</span>
                <input type="number" id="level-input" value="{{ $currentLevel }}" min="1" max="{{ $totalChallenges }}" 
                       onchange="goToLevel(this.value)"
                       class="w-16 bg-surface-variant/50 border border-outline-variant/30 rounded-lg text-center font-display font-black text-primary py-1 focus:outline-none focus:border-primary transition-all">
                <span class="text-[10px] font-display font-black uppercase tracking-widest text-on-surface-variant opacity-60">{{ __('of') }} {{ $totalChallenges }}</span>
            </div>

            @if($currentLevel < $totalChallenges)
                <a href="{{ route('games.play', ['slug' => $game->slug, 'genre' => $selectedGenre?->slug, 'level' => $currentLevel + 1]) }}" 
                   class="w-10 h-10 rounded-xl bg-surface-variant/50 flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors active:scale-90">
                    <span class="material-symbols-outlined rtl:rotate-180">arrow_forward</span>
                </a>
            @else
                <div class="w-10 h-10 rounded-xl bg-surface-variant/20 flex items-center justify-center text-on-surface-variant/30 cursor-not-allowed">
                    <span class="material-symbols-outlined rtl:rotate-180">arrow_forward</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Genre Switcher -->
    @if($genres->count() > 1)
        <div class="flex items-center gap-3 overflow-x-auto pb-4 scrollbar-none">
            <a href="{{ route('games.play', ['slug' => $game->slug]) }}" 
               class="flex-none flex items-center gap-2 px-6 py-3 rounded-full font-display font-bold text-xs uppercase tracking-widest transition-all {{ !$selectedGenre ? 'bg-primary text-on-primary shadow-lg shadow-primary/20' : 'glass-card text-on-surface-variant hover:text-primary' }}">
                <span class="text-lg">🌐</span>
                {{ __('All') }}
            </a>
            @foreach($genres as $genre)
                <a href="{{ route('games.play', ['slug' => $game->slug, 'genre' => $genre->slug]) }}" 
                   class="flex-none flex items-center gap-2 px-6 py-3 rounded-full font-display font-bold text-xs uppercase tracking-widest transition-all {{ $selectedGenre && $selectedGenre->id === $genre->id ? 'bg-primary text-on-primary shadow-lg shadow-primary/20' : 'glass-card text-on-surface-variant hover:text-primary' }}">
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
                <div class="{{ $challenge->stimulus_type === 'video' ? 'aspect-video' : '' }} flex items-center justify-center p-2">
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
                            <p class="text-on-surface-variant font-display font-bold uppercase tracking-widest">{{ __('Content not available') }}</p>
                        </div>
                    @endif
                </div>

                <!-- Overlay Actions -->
                <div class="absolute top-6 end-6 z-20 flex flex-col gap-3">
                    <button class="w-12 h-12 rounded-full glass-card flex items-center justify-center text-on-surface-variant hover:text-primary shadow-lg hover:scale-110 transition-all active:scale-90"
                            onclick="toggleBookmark({{ $game->id }})" 
                            data-id="{{ $game->id }}">
                        <span class="material-symbols-outlined transition-colors">bookmark</span>
                    </button>
                </div>
            </div>

            <!-- Answer Block (Directly below puzzle) -->
            <div class="glass-card rounded-[2.5rem] p-6 sm:p-8 border-primary/20 shadow-xl relative overflow-hidden bg-gradient-to-b from-surface-variant/5 to-transparent">
                <!-- Cyber Background Detail -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
                
                <div class="relative z-10 space-y-6 max-w-3xl mx-auto">
                    <div class="text-center space-y-1">
                        <span class="text-[9px] font-display font-black text-primary uppercase tracking-[0.4em] block">{{ __('Interaction') }}</span>
                        <h2 class="text-2xl font-display font-black uppercase tracking-tight">{{ __('Your Answer') }}</h2>
                    </div>

                    {{-- Dynamic Interaction Block --}}
                    <div id="interaction-root" class="w-full">
                        @if($game->slug === 'group-players')
                            <x-games.interaction.group :challenge="$challenge" :game="$game" />
                        @else
                            <x-games.interaction.standard :challenge="$challenge" :game="$game" />
                        @endif
                    </div>

                    <div class="pt-6 border-t border-outline-variant/10 flex flex-wrap items-center justify-center gap-6">
                        <button id="give-up-btn" class="text-on-surface-variant hover:text-error font-display font-bold text-xs uppercase tracking-[0.2em] transition-colors flex items-center gap-2">
                            <span class="text-lg">👁️</span>
                            {{ __('Reveal Answer') }}
                        </button>

                        <a href="{{ route('games.play', ['slug' => $game->slug]) }}" 
                           class="flex items-center gap-3 px-8 py-4 bg-surface-container-high/50 hover:bg-surface-container-high rounded-full border border-white/5 font-display font-black text-xs uppercase tracking-[0.2em] transition-all group active:scale-95">
                            <span class="material-symbols-outlined text-lg group-hover:rotate-180 transition-transform">refresh</span>
                            {{ __('Try Another') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Column (Hints) -->
        <div class="lg:col-span-4 xl:col-span-3 space-y-6">
            <!-- Hints Area -->
            <div class="glass-card rounded-[2rem] overflow-hidden flex flex-col border-outline-variant/10">
                <div class="p-4 bg-secondary/5 border-b border-secondary/10 flex items-center gap-3">
                    <span class="text-xl">💡</span>
                    <h3 class="text-xs font-display font-black text-on-surface uppercase tracking-widest">{{ __('Hints & Rescue') }}</h3>
                </div>

                <div class="p-6 space-y-6">
                    <div class="text-center space-y-4">
                        <p class="text-xs text-on-surface-variant font-medium leading-relaxed opacity-70">
                            {{ __('Stuck on this level? Reveal a hint one by one.') }}
                        </p>
                        <button id="hint-btn" class="w-full py-4 bg-secondary text-on-secondary rounded-2xl font-display font-black uppercase tracking-widest text-xs hover:brightness-110 transition-all shadow-lg shadow-secondary/20 active:scale-95">
                            {{ __('Unlock Hint') }}
                        </button>
                    </div>

                    <!-- Hints List -->
                    <div id="hints-display" class="space-y-4 pt-4 border-t border-outline-variant/10">
                        <!-- Hints will be appended here -->
                    </div>
                </div>
            </div>

            <!-- Ad/Promo Spot (Optional, like in design) -->
            <div class="glass-card rounded-[2rem] p-6 border-primary/10 bg-gradient-to-br from-primary/5 to-transparent">
                <span class="text-[9px] font-display font-black bg-primary text-on-primary px-2 py-0.5 rounded-full uppercase tracking-widest mb-3 inline-block">Pro Benefit</span>
                <h4 class="text-sm font-display font-black text-on-surface leading-tight uppercase mb-2">{{ __('Infinite Hints with Gamesiano Pro') }}</h4>
                <p class="text-[10px] text-on-surface-variant mb-4 opacity-60">{{ __('Never get stuck again. Get unlimited hints and no ads.') }}</p>
                <button class="w-full py-2.5 bg-white/5 hover:bg-white/10 text-white font-display font-bold rounded-xl uppercase tracking-widest text-[9px] transition-all border border-white/10">
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
    
    // Default progression is DESCENDING (150 -> 149) as newest levels are seeded last but shown first
    const prevLevelUrl = '{{ $currentLevel > 1 ? route('games.play', ['slug' => $game->slug, 'genre' => $selectedGenre?->slug, 'level' => $currentLevel - 1]) : '#' }}';
    
    let shownHints = [];

    // Level jump logic
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
                    <a href="${prevLevelUrl}" class="flex items-center gap-2 px-6 py-2 bg-primary text-on-primary rounded-xl font-display font-black uppercase tracking-widest text-[10px] hover:brightness-110 transition-all shadow-lg shadow-primary/20 active:scale-95">
                        {{ __('Next Level') }}
                        <span class="material-symbols-outlined text-sm rtl:rotate-180">arrow_back</span>
                    </a>
                </div>
            `;
        }

        feedback.innerHTML = content;
        
        // Remove existing state classes
        feedback.classList.remove('hidden', 'correct', 'wrong', 'revealed');
        
        // Add style and show
        feedback.className = 'p-4 rounded-xl font-display font-bold text-sm uppercase tracking-wide transition-all feedback ' + 
                           (isCorrect ? 'bg-tertiary/10 text-tertiary border border-tertiary/20' : 'bg-error/10 text-error border border-error/20');
        
        feedback.style.display = 'block';
    }
    window.showFeedback = showFeedback;

    // 1. Initialize Autocomplete (Global)
    document.addEventListener('DOMContentLoaded', () => {
        const answerInput = document.getElementById('answer-input');
        if (answerInput) {
            const answerType = answerInput.dataset.answerType;
            if (answerType && ['player', 'club', 'stadium', 'actor', 'movie'].includes(answerType)) {
                const searchUrlTemplate = @json(route('search.unified', ['type' => '__TYPE__']));
                const searchUrl = searchUrlTemplate.replace('__TYPE__', answerType);
                if (typeof initAutocomplete === 'function') {
                    initAutocomplete('answer-input', 'autocomplete-list', searchUrl);
                }
            }
        }
        
        // Update Bookmark UI
        if (typeof updateBookmarkUI === 'function') {
            updateBookmarkUI({{ $game->id }});
        }
    });

    // 2. Global Game Logic (Standard)
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
            // Gamesiano Style Modal usage
            if (typeof openHintModal === 'function') {
                openHintModal(() => {
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
        // Stimulus reveal logic
        const img = document.getElementById('challenge-image');
        if (img) {
            img.classList.remove('silhouette-filter');
            const revealSrc = img.dataset.reveal;
            if (revealSrc) img.src = revealSrc;
        }
        
        // Success pulse on container
        const arena = document.querySelector('.glass-card');
        if (arena) {
            arena.classList.add('neon-border-blue');
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
