@extends('layouts.app')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-8 space-y-12 pb-20">
    
    <!-- Library Header -->
    <header class="relative py-12 border-b border-outline-variant/20 flex flex-col md:flex-row md:items-end justify-between gap-8">
        <div class="space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary/10 border border-secondary/20 text-secondary text-[10px] font-display font-black uppercase tracking-[0.2em]">
                {{ __('Explore') }}
            </div>
            <h1 class="text-4xl sm:text-5xl font-display font-black uppercase tracking-tight text-on-background">
                {{ __('Game') }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">{{ __('Library') }}</span>
            </h1>
            <p class="text-on-surface-variant max-w-xl text-base leading-relaxed">
                {{ __('Choose a mode, switch theme or direction whenever you want, and keep the current gameplay intact.') }}
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
                <div class="text-3xl font-display font-black text-secondary leading-none">24/7</div>
                <div class="text-[10px] font-display font-bold uppercase tracking-widest text-on-surface-variant opacity-60">
                    {{ __('Live') }} <br> {{ __('Uptime') }}
                </div>
            </div>
        </div>
    </header>

    <!-- Genre Switcher -->
    @if($genres->count() > 0)
        <div class="flex items-center gap-3 overflow-x-auto pb-4 scrollbar-none">
            <a href="{{ route('games.index') }}" 
               class="flex-none flex items-center gap-2 px-6 py-3 rounded-full font-display font-bold text-xs uppercase tracking-widest transition-all {{ !$selectedGenre ? 'bg-primary text-on-primary shadow-lg shadow-primary/20' : 'glass-card text-on-surface-variant hover:text-primary' }}">
                <span class="text-lg">🌐</span>
                {{ __('All') }}
            </a>
            @foreach($genres as $genre)
                <a href="{{ route('games.index', ['genre' => $genre->slug]) }}" 
                   class="flex-none flex items-center gap-2 px-6 py-3 rounded-full font-display font-bold text-xs uppercase tracking-widest transition-all {{ $selectedGenre && $selectedGenre->id === $genre->id ? 'bg-primary text-on-primary shadow-lg shadow-primary/20' : 'glass-card text-on-surface-variant hover:text-primary' }}">
                    <span class="text-lg">{{ $genre->icon ?? '🧩' }}</span>
                    {{ $genre->localized_name }}
                </a>
            @endforeach
        </div>
    @endif

    <!-- Games Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
        @forelse($games as $game)
            @php
                $route = route('games.play', ['slug' => $game->slug]);
            @endphp
            <div class="group relative aspect-[3/4] rounded-[2rem] overflow-hidden glass-card transition-all duration-500 hover:-translate-y-2 hover:neon-border-blue">
                <a href="{{ $route }}" class="absolute inset-0 z-10" aria-label="{{ $game->localized_title }}"></a>
                
                <!-- Background Image -->
                @if ($game->image_url)
                    <img src="{{ $game->image_url }}" alt="{{ $game->localized_title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                @else
                    <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center p-8 text-center">
                        <span class="text-xl font-display font-black uppercase tracking-tighter opacity-40">{{ $game->localized_title }}</span>
                    </div>
                @endif

                <!-- Overlays -->
                <div class="absolute inset-0 bg-gradient-to-t from-background via-background/20 to-transparent opacity-80 z-0"></div>
                
                <!-- Top Actions -->
                <div class="absolute top-6 inset-x-6 z-20 flex justify-between items-start pointer-events-none">
                    <span class="bg-white/10 backdrop-blur-md border border-white/20 text-white text-[9px] font-display font-black px-3 py-1 rounded-full uppercase tracking-widest flex items-center gap-1.5">
                        <span class="text-xs">{{ $game->genre?->icon ?? '🧩' }}</span>
                        {{ $game->genre?->localized_name ?? __('Featured') }}
                    </span>
                    <button class="w-10 h-10 rounded-full glass-card flex items-center justify-center text-on-surface-variant hover:text-primary shadow-lg hover:scale-110 transition-all active:scale-90 pointer-events-auto"
                            onclick="event.preventDefault(); event.stopPropagation(); toggleBookmark({{ $game->id }})" 
                            data-id="{{ $game->id }}">
                        <span class="material-symbols-outlined transition-colors">bookmark</span>
                    </button>
                </div>

                <!-- Content -->
                <div class="absolute bottom-6 inset-x-6 z-20 space-y-3 pointer-events-none">
                    <h3 class="text-2xl font-display font-black text-white uppercase tracking-tight group-hover:text-primary transition-colors line-clamp-1">
                        {{ $game->localized_title }}
                    </h3>
                    <p class="text-white/60 text-xs font-medium line-clamp-2 leading-relaxed">
                        {{ $game->localized_description }}
                    </p>
                    
                    <div class="pt-4 flex items-center justify-between">
                        <div class="flex items-center gap-1.5 text-white/40 text-[10px] font-display font-black uppercase tracking-widest">
                            <span class="material-symbols-outlined text-sm">group</span>
                            12k {{ __('Playing') }}
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-primary text-on-primary flex items-center justify-center shadow-lg shadow-primary/20 group-hover:scale-110 transition-transform active:scale-95">
                            <span class="material-symbols-outlined">play_arrow</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center glass-card rounded-[2.5rem]">
                <p class="text-on-surface-variant font-display font-bold uppercase tracking-widest">{{ __('No games found. New mysteries are coming soon!') }}</p>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof getBookmarks === 'function') {
            const bookmarkedIds = getBookmarks();
            bookmarkedIds.forEach(id => {
                if (typeof updateBookmarkUI === 'function') {
                    updateBookmarkUI(id);
                }
            });
        }
    });
</script>
@endpush
@endsection
