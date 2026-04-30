@php
    $displayStats = $stats ?? $global_stats ?? [
        'streak' => 0,
        'games_played' => 0,
        'total_correct' => 0,
        'total_questions' => 0
    ];
    $compact = $compact ?? false;
@endphp

@if($compact)
<div class="flex items-center gap-2 sm:gap-4">
    <!-- Streak -->
    <div class="flex items-center gap-1.5 px-2 py-1 rounded-xl bg-error/5 border border-error/10 text-error group" title="{{ __('Streak') }}">
        <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1">local_fire_department</span>
        <span class="text-sm font-display font-black" id="hud-streak">{{ $displayStats['streak'] }}</span>
    </div>

    <!-- Played -->
    <div class="flex items-center gap-1.5 px-2 py-1 rounded-xl bg-primary/5 border border-primary/10 text-primary group" title="{{ __('Played') }}">
        <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1">sports_esports</span>
        <span class="text-sm font-display font-black" id="hud-played">{{ $displayStats['games_played'] }}</span>
    </div>

    <!-- Score -->
    <div class="flex items-center gap-1.5 px-2 py-1 rounded-xl bg-tertiary/5 border border-tertiary/10 text-tertiary group" title="{{ __('Correct') }}">
        <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1">stars</span>
        <span class="text-sm font-display font-black" id="hud-score">{{ $displayStats['total_correct'] }}/{{ $displayStats['total_questions'] }}</span>
    </div>
</div>
@else
<div class="flex flex-wrap items-center justify-center gap-3 sm:gap-6">
    <!-- Streak -->
    <div class="glass-card flex items-center gap-3 px-4 py-2 rounded-2xl border-error/20 hover:border-error/50 transition-colors group">
        <div class="w-10 h-10 rounded-xl bg-error/10 flex items-center justify-center text-error group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1">local_fire_department</span>
        </div>
        <div>
            <div class="text-[9px] font-display font-black uppercase tracking-widest text-on-surface-variant opacity-60">{{ __('Streak') }}</div>
            <div class="text-lg font-display font-black text-on-surface leading-none" id="hud-streak">{{ $displayStats['streak'] }}</div>
        </div>
    </div>

    <!-- Played -->
    <div class="glass-card flex items-center gap-3 px-4 py-2 rounded-2xl border-primary/20 hover:border-primary/50 transition-colors group">
        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1">sports_esports</span>
        </div>
        <div>
            <div class="text-[9px] font-display font-black uppercase tracking-widest text-on-surface-variant opacity-60">{{ __('Played') }}</div>
            <div class="text-lg font-display font-black text-on-surface leading-none" id="hud-played">{{ $displayStats['games_played'] }}</div>
        </div>
    </div>

    <!-- Score -->
    <div class="glass-card flex items-center gap-3 px-4 py-2 rounded-2xl border-tertiary/20 hover:border-tertiary/50 transition-colors group">
        <div class="w-10 h-10 rounded-xl bg-tertiary/10 flex items-center justify-center text-tertiary group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1">stars</span>
        </div>
        <div>
            <div class="text-[9px] font-display font-black uppercase tracking-widest text-on-surface-variant opacity-60">{{ __('Correct') }}</div>
            <div class="text-lg font-display font-black text-on-surface leading-none" id="hud-score">{{ $displayStats['total_correct'] }}/{{ $displayStats['total_questions'] }}</div>
        </div>
    </div>
</div>
@endif

<script>
    window.updateHUD = function(stats) {
        if (!stats) return;
        const streakEl = document.getElementById('hud-streak');
        const playedEl = document.getElementById('hud-played');
        const scoreEl = document.getElementById('hud-score');

        if (streakEl) streakEl.innerText = stats.streak;
        if (playedEl) playedEl.innerText = stats.games_played;
        if (scoreEl) scoreEl.innerText = stats.total_correct + '/' + stats.total_questions;
        
        // Success pulse effect
        const containers = document.querySelectorAll('.glass-card');
        containers.forEach(container => {
            container.classList.add('brightness-125', 'scale-105');
            setTimeout(() => container.classList.remove('brightness-125', 'scale-105'), 300);
        });
    };
</script>
