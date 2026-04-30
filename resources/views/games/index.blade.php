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
            <div class="group relative flex flex-col bg-surface-variant/40 dark:bg-zinc-900/40 backdrop-blur-xl rounded-[2.5rem] overflow-hidden border border-outline-variant/10 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/20 hover:border-primary/30">
                <!-- 1. Top Bar: Genre & Bookmark (Independent Layer) -->
                <div class="p-5 flex justify-between items-center z-40 relative">
                    <div class="flex items-center gap-1.5">
                        @foreach($game->genres as $genre)
                            <div class="bg-primary/10 text-primary text-[10px] font-display font-black w-8 h-8 rounded-full uppercase tracking-widest flex items-center justify-center hover:bg-primary/20 transition-colors" title="{{ $genre->localized_name }}">
                                <span class="text-sm leading-none">{{ $genre->icon ?? '🧩' }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <button class="w-9 h-9 rounded-full hover:bg-primary/10 flex items-center justify-center text-on-surface-variant hover:text-primary transition-all active:scale-90"
                            onclick="event.preventDefault(); event.stopPropagation(); toggleBookmark({{ $game->id }})" 
                            data-id="{{ $game->id }}">
                        <span class="material-symbols-outlined text-[20px]">bookmark</span>
                    </button>
                </div>

                <!-- 2. Clickable Main Content Area -->
                <a href="{{ $route }}" class="flex flex-col flex-grow z-30 group/link" aria-label="{{ $game->localized_title }}">
                    <!-- Square Image Container -->
                    <div class="px-5">
                        <div class="rounded-[1.8rem] overflow-hidden aspect-square">
                            @if ($game->image_url)
                                <img src="{{ $game->image_url }}" alt="{{ $game->localized_title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                                    <span class="text-xs font-display font-black uppercase opacity-20">{{ $game->localized_title }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Name & Description -->
                    <div class="p-6 pb-4 space-y-2">
                        <h3 class="text-xl font-display font-black text-on-surface uppercase tracking-tight group-hover:text-primary transition-colors line-clamp-1">
                            {{ $game->localized_title }}
                        </h3>
                        <p class="text-on-surface-variant/70 text-xs font-medium line-clamp-2 leading-relaxed">
                            {{ $game->localized_description }}
                        </p>
                    </div>

                    <!-- Separator -->
                    <div class="px-6 mt-auto">
                        <div class="h-px bg-outline-variant/20"></div>
                    </div>

                    <!-- Footer: Stats & Play Button -->
                    <div class="p-6 pt-4 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-on-surface-variant/50 text-[10px] font-display font-black uppercase tracking-widest">
                            <span class="material-symbols-outlined text-sm">trending_up</span>
                            <span>12k {{ __('Playing') }}</span>
                        </div>
                        
                        <div class="flex items-center gap-2 text-primary font-display font-black text-xs uppercase tracking-wider group-hover:gap-3 transition-all">
                            <span>{{ __('Play Now') }}</span>
                            <div class="w-8 h-8 rounded-xl bg-primary text-on-primary flex items-center justify-center shadow-lg shadow-primary/20 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-sm">play_arrow</span>
                            </div>
                        </div>
                    </div>
                </a>
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
