@extends('layouts.app')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-8 space-y-12 pb-20">
    
    <!-- Hero Section (Gamesiano Style) -->
    <section class="relative h-[400px] sm:h-[500px] w-full rounded-[2.5rem] overflow-hidden flex items-center px-8 sm:px-16 group transition-all duration-700">
        <!-- Background Art -->
        <div class="absolute inset-0 z-0">
            <img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" 
                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuAjCWz5z6rU52kQT7DtcsGAHDRbrkBxDmZs2l3aLuTEGcpOUrZqIflMKAz4el_ivm1XEevb5WwXeyMol93Dp7LNxcJYfXEjoWcPIoPlPhoGbgZrUdga88d_qzoI9BxJMvUEbwW6mRJPjY4zu-xDS4krKLY3m7K-AK_Boif9ganDtxLMTpeIWiQ5ml-arh1s1Dj3IZJTf7Pa0yfDrpY7hLviEkyTZ-rexDYpvqlAKRtSjI0Ooo34CviGCNpqWx74Sum_ko6f2_LVlw0"
                 alt="Hero Background">
            <div class="absolute inset-0 bg-gradient-to-r from-background via-background/60 to-transparent rtl:bg-gradient-to-l"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 max-w-2xl space-y-6">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 text-primary text-[10px] font-display font-black uppercase tracking-[0.2em]">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                </span>
                {{ __('Your Arena') }}
            </div>
            
            <h1 class="text-4xl sm:text-6xl font-display font-black italic tracking-tighter uppercase leading-[0.9] text-on-background">
                {{ __('ENTER THE') }} <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">{{ __('GAMESIANO') }}</span>
            </h1>
            
            <p class="text-on-surface-variant text-base sm:text-lg max-w-md leading-relaxed font-medium">
                {{ __('Jump back into your saved challenges with a cleaner, faster hub built for repeat play.') }}
            </p>

            <div class="flex flex-wrap gap-4 pt-4">
                <a href="{{ route('games.index') }}" class="bg-primary text-on-primary font-display font-black uppercase tracking-widest px-8 py-4 rounded-2xl shadow-xl shadow-primary/20 hover:brightness-110 active:scale-95 transition-all">
                    {{ __('Browse All Games') }}
                </a>
                <div class="glass-card flex items-center gap-4 px-6 py-4 rounded-2xl">
                    <div class="text-2xl font-display font-black text-secondary leading-none">{{ $games->count() }}</div>
                    <div class="text-[10px] font-display font-bold uppercase tracking-widest leading-tight text-on-surface-variant">
                        {{ __('Active') }} <br> {{ __('Modes') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Grid -->
    <div class="space-y-8">
        <div class="flex items-end justify-between border-s-4 border-primary ps-6">
            <div>
                <span class="text-[10px] font-display font-black text-primary uppercase tracking-[0.3em] block mb-1">{{ __('Quick Access') }}</span>
                <h2 class="text-3xl font-display font-black uppercase tracking-tight">{{ __('Bookmarked Games') }}</h2>
            </div>
            <a href="{{ route('games.index') }}" class="text-xs font-display font-black text-on-surface-variant hover:text-primary transition-colors uppercase tracking-widest flex items-center gap-2">
                {{ __('View All') }}
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>

        <!-- Empty State -->
        <div id="no-bookmarks" class="hidden flex-col items-center justify-center py-20 glass-card rounded-[2.5rem] text-center px-6 border-dashed border-2 border-outline-variant/30" style="display: none;">
            <div class="w-24 h-24 rounded-full bg-surface-variant/50 flex items-center justify-center text-on-surface-variant mb-6">
                <span class="material-symbols-outlined text-5xl">bookmarks</span>
            </div>
            <h2 class="text-2xl font-display font-black uppercase tracking-tight mb-3">{{ __('No Bookmarks Yet') }}</h2>
            <div class="flex items-center gap-2 mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>
                <span class="text-[10px] font-display font-black uppercase tracking-widest text-on-surface-variant">{{ __('Live') }}</span>
            </div>
            <p class="text-on-surface-variant max-w-sm mb-8 leading-relaxed">{{ __('Save games from the library and they will show up here for instant access on your next visit.') }}</p>
            <a href="{{ route('games.index') }}" class="bg-primary text-on-primary font-display font-black uppercase tracking-widest px-8 py-3 rounded-2xl shadow-xl shadow-primary/20 hover:brightness-110 active:scale-95 transition-all">
                {{ __('Discover Games') }}
            </a>
        </div>

        <!-- Grid -->
        <div id="bookmarks-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
            @foreach($games as $game)
                @php
                    $route = route('games.play', ['slug' => $game->slug]);
                @endphp
                <div class="bookmark-item group relative aspect-[3/4] rounded-[2rem] overflow-hidden glass-card transition-all duration-500 hover:-translate-y-2 hover:neon-border-blue" 
                     data-id="{{ $game->id }}" 
                     style="display: none;">
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
                        <span class="bg-white/10 backdrop-blur-md border border-white/20 text-white text-[9px] font-display font-black px-3 py-1 rounded-full uppercase tracking-widest">
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
                            <div class="w-12 h-12 rounded-2xl bg-primary text-on-primary flex items-center justify-center shadow-lg shadow-primary/20 hover:scale-110 transition-transform active:scale-95">
                                <span class="material-symbols-outlined">play_arrow</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bookmarkedIds = typeof getBookmarks === 'function' ? getBookmarks() : [];
        const items = document.querySelectorAll('.bookmark-item');
        let found = 0;

        items.forEach(item => {
            const id = parseInt(item.getAttribute('data-id'));
            if (bookmarkedIds.includes(id)) {
                item.style.display = 'block';
                found++;
                
                // Ensure UI reflects bookmarked state
                if (typeof updateBookmarkUI === 'function') {
                    updateBookmarkUI(id);
                }
            }
        });

        if (found === 0) {
            document.getElementById('no-bookmarks').style.display = 'flex';
        }
    });

    // Overriding toggleBookmark to also hide items on Home page
    if (typeof toggleBookmark === 'function') {
        const originalToggle = toggleBookmark;
        window.toggleBookmark = function(gameId) {
            originalToggle(gameId);
            const bookmarks = getBookmarks();
            if (!bookmarks.includes(gameId)) {
                const item = document.querySelector(`.bookmark-item[data-id="${gameId}"]`);
                if (item) {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.9) translateY(10px)';
                    setTimeout(() => {
                        item.remove();
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
