@extends('layouts.app')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-8 space-y-12 pb-20">
    
    <!-- Header -->
    <header class="relative py-12 border-b border-outline-variant/20 flex flex-col md:flex-row md:items-end justify-between gap-8">
        <div class="space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 text-primary text-[10px] font-display font-black uppercase tracking-[0.2em]">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                </span>
                {{ __('Real-Time Arena') }}
            </div>
            <h1 class="text-4xl sm:text-5xl font-display font-black uppercase tracking-tight text-on-background">
                {{ __('Multiplayer') }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">{{ __('Games') }}</span>
            </h1>
            <p class="text-on-surface-variant max-w-xl text-base leading-relaxed">
                {{ __('Challenge your friends or random players worldwide in real-time speed trivia and vocabulary battles. Fast pacing, interactive leaderboards, and instant fun!') }}
            </p>
        </div>
        
        <div class="glass-card flex items-center gap-6 px-8 py-6 rounded-3xl border-primary/20">
            <div class="space-y-1">
                <div class="text-3xl font-display font-black text-primary leading-none">{{ $games->count() }}</div>
                <div class="text-[10px] font-display font-bold uppercase tracking-widest text-on-surface-variant opacity-60">
                    {{ __('Active') }} <br> {{ __('Modes') }}
                </div>
            </div>
            <div class="w-px h-10 bg-outline-variant/30"></div>
            <div class="space-y-1">
                <div class="text-3xl font-display font-black text-secondary leading-none">Live</div>
                <div class="text-[10px] font-display font-bold uppercase tracking-widest text-on-surface-variant opacity-60">
                    {{ __('Reverb') }} <br> {{ __('Sync') }}
                </div>
            </div>
        </div>
    </header>

    <!-- Games Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($games as $game)
            @php
                $themeColor = '#8b5cf6'; // Violet default
                if ($game->slug === 'mazad') {
                    $themeColor = '#adc6ff';
                }
                $playUrl = route($game->slug . '.lobby', ['locale' => app()->getLocale()]);
            @endphp
            <div class="group relative flex flex-col bg-surface-variant/40 dark:bg-zinc-900/40 backdrop-blur-xl rounded-[2.5rem] overflow-hidden border border-outline-variant/10 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/20 hover:border-primary/30">
                
                <!-- Image Area -->
                <div class="relative aspect-[16/10] overflow-hidden bg-surface-variant/20">
                    @if ($game->image_url)
                        <img src="{{ $game->image_url }}" alt="{{ $game->localized_title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center p-8 text-center" style="background: linear-gradient(135deg, {{ $themeColor }}10, {{ $themeColor }}20)">
                            <span class="text-3xl font-display font-black uppercase tracking-tighter opacity-40" style="color: {{ $themeColor }}">{{ $game->localized_title }}</span>
                        </div>
                    @endif

                    <!-- Mode Badge -->
                    <div class="absolute top-5 start-5 z-20">
                        <div class="text-[10px] font-display font-black text-primary uppercase tracking-[0.2em] px-4 py-1.5 bg-primary/10 backdrop-blur-xl rounded-full border border-primary/20">
                            {{ __('Multiplayer') }}
                        </div>
                    </div>
                    
                    <!-- Bottom Image Gradient -->
                    <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
                </div>

                <!-- Content Area -->
                <div class="p-8 space-y-6 flex flex-grow flex-col">
                    <div class="space-y-3">
                        <h3 class="text-3xl font-display font-black text-on-surface uppercase tracking-tight group-hover:text-primary transition-colors">
                            {{ $game->localized_title }}
                        </h3>
                        <p class="text-on-surface-variant/80 text-sm font-medium leading-relaxed">
                            {{ app()->getLocale() === 'ar' ? $game->description_ar : $game->description }}
                        </p>
                    </div>

                    <!-- How to Play Preview -->
                    <div class="p-4 rounded-2xl bg-surface-variant/30 dark:bg-zinc-950/20 border border-outline-variant/10 space-y-2">
                        <span class="text-[9px] font-display font-bold uppercase tracking-widest text-primary">{{ __('How to Play') }}</span>
                        <p class="text-on-surface-variant text-xs font-medium leading-relaxed whitespace-pre-line">
                            {{ app()->getLocale() === 'ar' ? $game->how_to_play_ar : $game->how_to_play }}
                        </p>
                    </div>

                    <!-- Action Footer -->
                    <div class="pt-6 mt-auto border-t border-outline-variant/10 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-on-surface-variant/50 text-[10px] font-display font-black uppercase tracking-widest">
                            <span class="material-symbols-outlined text-sm">groups</span>
                            <span>{{ __('2+ Players') }}</span>
                        </div>
                        
                        <a href="{{ $playUrl }}" class="flex items-center gap-3 px-6 py-3 rounded-2xl bg-primary text-on-primary font-display font-black text-xs uppercase tracking-widest hover:brightness-110 shadow-lg shadow-primary/20 transition-all active:scale-[0.98]">
                            <span>{{ __('Enter Lobby') }}</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
