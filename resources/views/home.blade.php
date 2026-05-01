@extends('layouts.app')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-8 space-y-12 pb-20">
    
    <!-- Hero Section (Gamesiano Style) -->
    <section class="relative min-h-[500px] w-full rounded-[2.5rem] overflow-hidden flex items-center group transition-all duration-700 bg-surface">
        <!-- Background Art -->
        <div class="absolute inset-0 z-0">
            <img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105 opacity-30 dark:opacity-20" 
                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuAjCWz5z6rU52kQT7DtcsGAHDRbrkBxDmZs2l3aLuTEGcpOUrZqIflMKAz4el_ivm1XEevb5WwXeyMol93Dp7LNxcJYfXEjoWcPIoPlPhoGbgZrUdga88d_qzoI9BxJMvUEbwW6mRJPjY4zu-xDS4krKLY3m7K-AK_Boif9ganDtxLMTpeIWiQ5ml-arh1s1Dj3IZJTf7Pa0yfDrpY7hLviEkyTZ-rexDYpvqlAKRtSjI0Ooo34CviGCNpqWx74Sum_ko6f2_LVlw0"
                 alt="Hero Background">
            <div class="absolute inset-0 bg-gradient-to-br from-background via-background/90 to-transparent rtl:bg-gradient-to-bl"></div>
        </div>

        <div class="relative z-10 w-full px-8 sm:px-16 py-12 grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left: Content -->
            <div class="space-y-8">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 text-primary text-[10px] font-display font-black uppercase tracking-[0.2em]">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                    </span>
                    {{ __('Your Arena') }}
                </div>
                
                <div class="space-y-4">
                    <h1 class="text-5xl sm:text-7xl font-display font-black italic tracking-tighter uppercase leading-[0.85] text-on-background">
                        {{ __('ENTER THE') }} <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">{{ __('GAMESIANO') }}</span>
                    </h1>
                    
                    <p class="text-on-surface-variant text-lg max-w-md leading-relaxed font-medium">
                        {{ __('Jump back into your saved challenges with a cleaner, faster hub built for repeat play.') }}
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-6">
                    <a href="{{ route('games.index') }}" class="bg-primary text-on-primary font-display font-black uppercase tracking-widest px-10 py-5 rounded-2xl shadow-2xl shadow-primary/30 hover:brightness-110 hover:-translate-y-1 active:scale-95 transition-all">
                        {{ __('Browse All Games') }}
                    </a>
                    <div class="flex items-center gap-4">
                        <div class="text-4xl font-display font-black text-secondary leading-none">{{ $games->count() }}</div>
                        <div class="text-[10px] font-display font-bold uppercase tracking-widest leading-tight text-on-surface-variant">
                            {{ __('Active') }} <br> {{ __('Modes') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Latest Games -->
            <div class="hidden lg:grid grid-cols-2 gap-6">
                @foreach($latestGames as $latestGame)
                    <div class="group/card relative flex flex-col h-full transition-all duration-500 hover:-translate-y-2">
                        <!-- Image Block -->
                        <div class="relative aspect-[4/5] rounded-t-[2.5rem] overflow-hidden border border-outline-variant/10 rounded-t-lg shadow-2xl transition-all duration-500 group-hover/card:shadow-primary/20 group-hover/card:border-primary/30 bg-surface-variant">
                            <a href="{{ route('games.play', ['slug' => $latestGame->slug]) }}" class="absolute inset-0 z-20"></a>
                            
                            @if ($latestGame->image_url)
                                <img src="{{ $latestGame->image_url }}" alt="{{ $latestGame->localized_title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110">
                            @endif

                            <!-- Top Badge -->
                            <div class="absolute top-5 start-5 z-20">
                                <div class="text-[10px] font-display font-black text-primary uppercase tracking-[0.2em] px-4 py-1.5 bg-primary/10 backdrop-blur-xl rounded-full border border-primary/20">
                                    {{ __('New Arrival') }}
                                </div>
                            </div>
                        </div>

                        <!-- Name Block (Proper UI Block) -->
                        <div class="rounded-b-lg shadow-2xl dark:bg-zinc-900/40 backdrop-blur-xl p-6">
                            <h3 class="text-xl font-display font-black text-on-surface uppercase tracking-tight group-hover/card:text-primary transition-colors line-clamp-1">
                                {{ $latestGame->localized_title }}
                            </h3>                           
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Content Grid -->
    <div class="space-y-16">
        <div class="flex items-end justify-between border-s-4 border-primary ps-6">
            <div>
                <span class="text-[10px] font-display font-black text-primary uppercase tracking-[0.3em] block mb-1">{{ __('Quick Access') }}</span>
                <h2 class="text-3xl font-display font-black uppercase tracking-tight">{{ __('Your Interests') }}</h2>
            </div>
            <a href="{{ route('games.index') }}" class="text-xs font-display font-black text-on-surface-variant hover:text-primary transition-colors uppercase tracking-widest flex items-center gap-2">
                {{ __('Explore Library') }}
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>

        <!-- Empty State -->
        <div id="no-bookmarks" class="hidden flex-col items-center justify-center py-20 glass-card rounded-[2.5rem] text-center px-6 border-dashed border-2 border-outline-variant/30">
            <div class="w-24 h-24 rounded-full bg-surface-variant/50 flex items-center justify-center text-on-surface-variant mb-6">
                <span class="material-symbols-outlined text-5xl">bookmarks</span>
            </div>
            <h2 class="text-2xl font-display font-black uppercase tracking-tight mb-3">{{ __('No Bookmarks Yet') }}</h2>
            <div class="flex items-center gap-2 mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>
                <span class="text-[10px] font-display font-black uppercase tracking-widest text-on-surface-variant">{{ __('Live') }}</span>
            </div>
            <p class="text-on-surface-variant max-w-sm mb-8 leading-relaxed">{{ __('Save games from the library and they will show up here grouped by your interests.') }}</p>
            <a href="{{ route('games.index') }}" class="bg-primary text-on-primary font-display font-black uppercase tracking-widest px-8 py-3 rounded-2xl shadow-xl shadow-primary/20 hover:brightness-110 active:scale-95 transition-all">
                {{ __('Discover Genres') }}
            </a>
        </div>

        <!-- Grouped Bookmarks Container -->
        <div id="bookmarks-container" class="space-y-16">
            @foreach($genres as $genre)
                <section class="genre-section space-y-8" id="genre-section-{{ $genre->id }}" style="display: none;">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-secondary/10 border border-secondary/20 flex items-center justify-center text-secondary text-2xl">
                            {{ $genre->icon ?? '🧩' }}
                        </div>
                        <h3 class="text-2xl font-display font-black uppercase tracking-tight">{{ $genre->localized_name }}</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
                        @foreach($games as $game)
                            @if($game->genres->contains($genre->id))
                                @php
                                    $route = route('games.play', ['slug' => $game->slug, 'genre' => $genre->slug]);
                                @endphp
                                <div class="bookmark-item group relative flex flex-col transition-all duration-500 hover:-translate-y-2" 
                                     data-id="{{ $game->id }}" 
                                     data-genre="{{ $genre->id }}"
                                     style="display: none;">
                                    
                                    <!-- Image Block -->
                                    <div class="relative aspect-square rounded-t-[2.5rem] overflow-hidden glass-card border border-outline-variant/10 transition-all duration-500 group-hover:neon-border-blue">
                                        <a href="{{ $route }}" class="absolute inset-0 z-10" aria-label="{{ $game->localized_title }}"></a>
                                        
                                        <!-- Background Image -->
                                        @if ($game->image_url)
                                            <img src="{{ $game->image_url }}" alt="{{ $game->localized_title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                        @else
                                            <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center p-8 text-center">
                                                <span class="text-xl font-display font-black uppercase tracking-tighter opacity-40">{{ $game->localized_title }}</span>
                                            </div>
                                        @endif

                                        <!-- Top Actions -->
                                        <div class="absolute top-4 inset-x-4 z-20 flex justify-end items-start">
                                            <button class="w-10 h-10 rounded-full glass-card flex items-center justify-center text-on-surface-variant hover:text-primary shadow-lg hover:scale-110 transition-all active:scale-90"
                                                    onclick="event.preventDefault(); event.stopPropagation(); toggleBookmark({{ $game->id }}, {{ $genre->id }})" 
                                                    data-id="{{ $game->id }}"
                                                    data-genre="{{ $genre->id }}">
                                                <span class="material-symbols-outlined transition-colors">bookmark</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Name Block (Proper UI Block) -->
                                    <div class="bg-surface-variant/30 dark:bg-zinc-900/40 backdrop-blur-xl p-6 rounded-b-[2.5rem] border-x border-b border-outline-variant/10 flex-grow">
                                        <h3 class="text-xl font-display font-black text-on-surface uppercase tracking-tight group-hover:text-primary transition-colors line-clamp-1">
                                            {{ $game->localized_title }}
                                        </h3>
                                        
                                        <div class="flex items-center justify-between mt-4">
                                            <div class="flex items-center gap-1.5 text-on-surface-variant/50 text-[10px] font-display font-black uppercase tracking-widest">
                                                <span class="material-symbols-outlined text-sm">trending_up</span>
                                                12k {{ __('Playing') }}
                                            </div>
                                            <a href="{{ $route }}" class="w-10 h-10 rounded-xl bg-primary text-on-primary flex items-center justify-center shadow-lg shadow-primary/20 hover:scale-110 transition-transform active:scale-95">
                                                <span class="material-symbols-outlined text-sm">play_arrow</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bookmarkedKeys = typeof getBookmarks === 'function' ? getBookmarks() : [];
        const items = document.querySelectorAll('.bookmark-item');
        const sections = document.querySelectorAll('.genre-section');
        let totalFound = 0;

        items.forEach(item => {
            const id = item.getAttribute('data-id');
            const genre = item.getAttribute('data-genre');
            const key = `${id}_${genre}`;
            
            if (bookmarkedKeys.includes(key)) {
                item.style.display = 'block';
                totalFound++;
                
                // Show the parent section
                const section = document.getElementById(`genre-section-${genre}`);
                if (section) section.style.display = 'block';

                // Update UI
                if (typeof updateBookmarkUI === 'function') {
                    updateBookmarkUI(id, genre);
                }
            }
        });

        if (totalFound === 0) {
            document.getElementById('no-bookmarks').style.display = 'flex';
        }
    });

    // Overriding toggleBookmark to also hide items on Home page
    if (typeof toggleBookmark === 'function') {
        const originalToggle = toggleBookmark;
        window.toggleBookmark = function(gameId, genreId) {
            originalToggle(gameId, genreId);
            const bookmarks = getBookmarks();
            const key = `${gameId}_${genreId}`;
            
            if (!bookmarks.includes(key)) {
                const item = document.querySelector(`.bookmark-item[data-id="${gameId}"][data-genre="${genreId}"]`);
                if (item) {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.9) translateY(10px)';
                    setTimeout(() => {
                        const section = item.closest('.genre-section');
                        item.remove();
                        
                        // If section is empty, hide it
                        if (section && section.querySelectorAll('.bookmark-item').length === 0) {
                            section.style.display = 'none';
                        }
                        
                        if (document.querySelectorAll('.bookmark-item').length === 0) {
                            document.getElementById('no-bookmarks').style.display = 'flex';
                        }
                    }, 500);
                }
            }
        };
    }
</script>
@endpush
@endsection
