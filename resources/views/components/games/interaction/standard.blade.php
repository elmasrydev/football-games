@props(['challenge', 'game'])

<div class="space-y-8">
    <!-- Question Header -->
    <div class="flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1">psychology</span>
            </div>
            <div>
                <span class="text-[9px] font-display font-black uppercase tracking-widest text-on-surface-variant opacity-60">{{ __('Challenge') }}</span>
                <h3 class="text-xs font-display font-black text-on-surface uppercase tracking-tight">{{ app()->getLocale() === 'ar' ? $game->localized_title : $game->localized_title }}</h3>
            </div>
        </div>
        <span class="px-3 py-1 rounded-full text-[9px] font-display font-black uppercase tracking-widest 
            @if($challenge->difficulty === 'easy') bg-tertiary/10 text-tertiary border border-tertiary/20
            @elseif($challenge->difficulty === 'medium') bg-secondary/10 text-secondary border border-secondary/20
            @else bg-error/10 text-error border border-error/20
            @endif">
            {{ $challenge->difficulty }}
        </span>
    </div>

    <!-- Question Content -->
    <div class="space-y-4">
        <h2 class="text-xl sm:text-2xl font-display font-black uppercase tracking-tight leading-tight">
            {{ __('Enter your answer below:') }}
        </h2>
        @if($challenge->question || $challenge->clue)
            <div class="p-5 rounded-2xl bg-surface-variant/30 border-s-4 border-primary relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-2 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-4xl">format_quote</span>
                </div>
                <p class="text-on-surface-variant text-sm font-medium leading-relaxed italic relative z-10">
                    {{ $challenge->question ?? $challenge->clue }}
                </p>
            </div>
        @endif
    </div>

    <!-- Interaction Zone -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <span class="text-[9px] font-display font-black uppercase tracking-[0.2em] text-on-surface-variant opacity-60">{{ __('Answer Zone') }}</span>
            <span class="text-[9px] font-display font-black uppercase tracking-widest text-primary bg-primary/5 px-2 py-0.5 rounded border border-primary/10">
                {{ $challenge->autocomplete_type ?? $challenge->answer_type ?? $game->answer_type ?? 'player' }}
            </span>
        </div>

        <x-player-answer-form 
            :placeholder="__('Your answer here...')" 
            :answerType="$challenge->autocomplete_type ?? $challenge->answer_type ?? $game->answer_type ?? 'player'" 
        />
    </div>

    <!-- Feedback Container -->
    <div id="feedback" class="hidden animate-in slide-in-from-bottom-2 duration-300"></div>

</div>
