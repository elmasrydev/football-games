@extends('layouts.app')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-8 space-y-12 pb-20">
    
    <!-- Genre Header -->
    <header class="relative py-12 border-b border-outline-variant/20 flex flex-col md:flex-row md:items-end justify-between gap-8">
        <div class="space-y-4">
            <nav class="flex items-center gap-2 text-[10px] font-display font-black uppercase tracking-[0.2em] text-on-surface-variant/60">
                <a href="{{ route('games.index') }}" class="hover:text-primary transition-colors">{{ __('Library') }}</a>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="text-secondary">{{ $genre->localized_name }}</span>
            </nav>
            <h1 class="text-4xl sm:text-5xl font-display font-black uppercase tracking-tight text-on-background flex items-center gap-4">
                @if($genre->image_url)
                    <div class="w-16 h-16 rounded-2xl overflow-hidden shadow-2xl">
                        <img src="{{ $genre->image_url }}" alt="{{ $genre->localized_name }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <span class="text-5xl">{{ $genre->icon ?? '🧩' }}</span>
                @endif
                <span>{{ $genre->localized_name }}</span>
            </h1>
            <p class="text-on-surface-variant max-w-xl text-base leading-relaxed">
                {{ $genre->localized_description ?: __('Explore games in the :genre category. Bookmark your favorites for quick access.', ['genre' => $genre->localized_name]) }}
            </p>
        </div>
        
        <div class="glass-card flex items-center gap-6 px-8 py-6 rounded-3xl border-primary/20">
            <div class="space-y-1">
                <div class="text-3xl font-display font-black text-primary leading-none">{{ $games->count() }}</div>
                <div class="text-[10px] font-display font-bold uppercase tracking-widest text-on-surface-variant opacity-60">
                    {{ __('Games') }} <br> {{ __('Available') }}
                </div>
            </div>
        </div>
    </header>

    <!-- Games Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
        @forelse($games as $game)
            @php
                $route = route('games.play', ['slug' => $game->slug, 'genre' => $genre->slug]);
            @endphp
            <div class="group relative flex flex-col bg-surface-variant/40 dark:bg-zinc-900/40 backdrop-blur-xl rounded-[1rem] overflow-hidden border border-outline-variant/10 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/20 hover:border-primary/30">
                <a href="{{ $route }}" class="absolute inset-0 z-30" aria-label="{{ $game->localized_title }}"></a>
                
                <!-- Image Area -->
                <div class="relative aspect-square overflow-hidden">
                    @if ($game->image_url)
                        <img src="{{ $game->image_url }}" alt="{{ $game->localized_title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center p-8 text-center">
                            <span class="text-xs font-display font-black uppercase opacity-20">{{ $game->localized_title }}</span>
                        </div>
                    @endif

                    <!-- Bookmark Button Overlay -->
                    <div class="absolute top-4 inset-x-4 z-40 flex justify-end">
                        <button class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white hover:text-primary shadow-lg hover:scale-110 transition-all active:scale-90"
                                onclick="event.preventDefault(); event.stopPropagation(); toggleBookmark({{ $game->id }}, {{ $genre->id }})" 
                                data-id="{{ $game->id }}"
                                data-genre="{{ $genre->id }}">
                            <span class="material-symbols-outlined text-[20px]">bookmark</span>
                        </button>
                    </div>

                    <!-- Subtle Bottom Gradient -->
                    <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>

                <!-- Content Area -->
                <div class="p-6 space-y-4 flex flex-grow flex-col">
                    <div class="space-y-2">
                        <h3 class="text-xl font-display font-black text-on-surface uppercase tracking-tight group-hover:text-primary transition-colors line-clamp-1">
                            {{ $game->localized_title }}
                        </h3>
                        <p class="text-on-surface-variant/70 text-xs font-medium line-clamp-2 leading-relaxed">
                            {{ $game->localized_description }}
                        </p>
                    </div>

                    <!-- Footer -->
                    <div class="pt-4 mt-auto border-t border-outline-variant/10 flex items-center justify-between">
                        <div class="flex items-center gap-1.5 text-on-surface-variant/50 text-[10px] font-display font-black uppercase tracking-widest">
                            <span class="material-symbols-outlined text-sm">trending_up</span>
                            12k {{ __('Playing') }}
                        </div>
                        
                        <div class="flex items-center gap-2 text-primary font-display font-black text-xs uppercase tracking-wider group-hover:gap-3 transition-all">
                            <div class="w-8 h-8 rounded-xl bg-primary text-on-primary flex items-center justify-center shadow-lg shadow-primary/20 group-hover:scale-110 transition-transform active:scale-95">
                                <span class="material-symbols-outlined text-sm">play_arrow</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center glass-card rounded-[2.5rem]">
                <p class="text-on-surface-variant font-display font-bold uppercase tracking-widest">{{ __('No games found in this genre yet.') }}</p>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof getBookmarks === 'function') {
            const bookmarkedKeys = getBookmarks();
            const genreId = {{ $genre->id }};
            bookmarkedKeys.forEach(key => {
                if (key.includes('_' + genreId)) {
                    const gameId = key.split('_')[0];
                    if (typeof updateBookmarkUI === 'function') {
                        updateBookmarkUI(gameId, genreId);
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection
