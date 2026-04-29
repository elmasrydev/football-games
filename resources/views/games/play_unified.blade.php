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
        
        <!-- Stimulus Side -->
        <div class="lg:col-span-7 xl:col-span-8 space-y-6">
            <div class="glass-card rounded-[2.5rem] overflow-hidden relative border-outline-variant/10 shadow-2xl">
                {{-- Dynamic Stimulus Block --}}
                <div class="aspect-video lg:aspect-auto lg:min-h-[600px] flex items-center justify-center p-4">
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
                    <a href="{{ route('games.play', ['slug' => $game->slug]) }}" 
                       class="w-12 h-12 rounded-full glass-card flex items-center justify-center text-on-surface-variant hover:text-primary shadow-lg hover:scale-110 transition-all active:scale-90"
                       title="{{ __('Try Another') }}">
                        <span class="material-symbols-outlined">refresh</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Interaction Side -->
        <div class="lg:col-span-5 xl:col-span-4 space-y-6">
            <!-- Hints Area (Top) -->
            <div class="space-y-4">
                <button id="hint-btn" class="w-full glass-card group flex items-center justify-between p-5 rounded-3xl border-secondary/20 hover:border-secondary hover:bg-secondary/5 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-secondary/10 flex items-center justify-center text-secondary group-hover:scale-110 transition-transform">
                            <span class="text-2xl">💡</span>
                        </div>
                        <div class="text-start">
                            <span class="text-[10px] font-display font-black text-secondary uppercase tracking-widest block mb-1">{{ __('Support') }}</span>
                            <h3 class="text-sm font-display font-black uppercase tracking-tight">{{ __('Need a Hint?') }}</h3>
                        </div>
                    </div>
                    <span class="material-symbols-outlined text-secondary opacity-40 group-hover:opacity-100 transition-opacity">add_circle</span>
                </button>

                <!-- Hints List -->
                <div id="hints-display" class="space-y-3">
                    <!-- Hints will be appended here -->
                </div>
            </div>

            <!-- Answer Block -->
            <div class="glass-card rounded-[2.5rem] p-8 border-primary/20 shadow-xl relative overflow-hidden">
                <!-- Cyber Background Detail -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
                
                <div class="relative z-10 space-y-8">
                    <div class="space-y-1">
                        <span class="text-[10px] font-display font-black text-primary uppercase tracking-[0.3em] block">{{ __('Interaction') }}</span>
                        <h2 class="text-2xl font-display font-black uppercase tracking-tight">{{ __('Your Answer') }}</h2>
                    </div>

                    {{-- Dynamic Interaction Block --}}
                    <div id="interaction-root">
                        @if($game->slug === 'group-players')
                            <x-games.interaction.group :challenge="$challenge" :game="$game" />
                        @else
                            <x-games.interaction.standard :challenge="$challenge" :game="$game" />
                        @endif
                    </div>

                    <div class="pt-6 border-t border-outline-variant/20 flex flex-col gap-4">
                        <button id="give-up-btn" class="text-on-surface-variant hover:text-error font-display font-bold text-xs uppercase tracking-widest transition-colors flex items-center justify-center gap-2">
                            <span class="text-sm">👁️</span>
                            {{ __('Reveal Answer') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
    const feedback = document.getElementById('feedback');

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
                if (!feedback) return;
                
                feedback.textContent = data.message;
                feedback.className = 'p-4 rounded-xl font-display font-bold text-sm uppercase tracking-wide transition-all ' + 
                                   (data.correct ? 'bg-tertiary/10 text-tertiary border border-tertiary/20' : 'bg-error/10 text-error border border-error/20');
                feedback.classList.remove('hidden');

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
                            hintDiv.className = 'glass-card p-5 rounded-3xl border-secondary/20 flex items-start gap-4 animate-in slide-in-from-top-4 duration-500 shadow-xl';
                            hintDiv.innerHTML = `
                                <div class="w-10 h-10 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                                    <span class="text-lg">🎯</span>
                                </div>
                                <div>
                                    <span class="text-[9px] font-display font-black text-secondary uppercase tracking-widest block mb-1">{{ __('Hint') }} ${shownHints.length}</span>
                                    <p class="text-sm font-medium text-on-surface leading-relaxed">${data.hint}</p>
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
                if (!feedback) return;
                
                if (data.answers) {
                    feedback.textContent = `{{ __('Answers:') }} ${data.answers.join(', ')}`;
                } else {
                    feedback.textContent = `{{ __('The answer was:') }} ${data.answer}`;
                    if (answerInput) answerInput.value = data.answer;
                }
                
                feedback.className = 'p-4 rounded-xl font-display font-bold text-sm uppercase tracking-wide bg-primary/10 text-primary border border-primary/20';
                feedback.classList.remove('hidden');
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
            if (feedback) feedback.classList.add('hidden');
        });
    }
</script>
@endpush
@endsection
