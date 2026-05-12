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
                    <div class="group/card relative flex flex-col h-full bg-surface-variant/40 dark:bg-zinc-900/40 backdrop-blur-xl rounded-[1rem] border border-outline-variant/10 shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:shadow-primary/20 hover:border-primary/30 overflow-hidden">
                        <a href="{{ route('games.play', ['slug' => $latestGame->slug]) }}" class="absolute inset-0 z-30"></a>
                        
                        <!-- Image Area -->
                        <div class="relative aspect-[4/5] overflow-hidden">
                            @if ($latestGame->image_url)
                                <img src="{{ $latestGame->image_url }}" alt="{{ $latestGame->localized_title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110">
                            @endif

                            <!-- Top Badge -->
                            <div class="absolute top-5 start-5 z-20">
                                <div class="text-[10px] font-display font-black text-primary uppercase tracking-[0.2em] px-4 py-1.5 bg-primary/10 backdrop-blur-xl rounded-full border border-primary/20">
                                    {{ __('New Arrival') }}
                                </div>
                            </div>
                            
                            <!-- Bottom Image Gradient (Subtle) -->
                            <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>

                        <!-- Content Area -->
                        <div class="p-6 space-y-3">
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

        <!-- Categories Container -->
        <div id="categories-container" class="space-y-16">
            @foreach($genres as $genre)
                @php
                    $themeColor = $genre->theme_color ?: '#3b82f6'; // Default blue
                @endphp
                <section class="genre-section space-y-8" id="genre-section-{{ $genre->id }}" style="--genre-theme: {{ $themeColor }};">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl shadow-lg transition-transform hover:scale-110" 
                                 style="background: {{ $themeColor }}20; border: 1px solid {{ $themeColor }}40; color: {{ $themeColor }};">
                                {{ $genre->icon ?? '🧩' }}
                            </div>
                            <div>
                                <h3 class="text-2xl font-display font-black uppercase tracking-tight">{{ $genre->localized_name }}</h3>
                                <p class="text-[10px] font-display font-bold uppercase tracking-widest text-on-surface-variant opacity-60">
                                    {{ $genre->games()->count() }} {{ __('Games Available') }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('games.genre', ['genre_slug' => $genre->slug]) }}" 
                           class="text-[10px] font-display font-black uppercase tracking-widest px-4 py-2 rounded-xl bg-surface-variant/50 hover:bg-surface-variant transition-colors">
                            {{ __('View All') }}
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
                        @foreach($games as $game)
                            @if($game->genres->contains($genre->id))
                                @php
                                    $route = route('games.play', ['slug' => $game->slug, 'genre' => $genre->slug]);
                                @endphp
                                <div class="game-item group relative flex flex-col bg-surface-variant/40 dark:bg-zinc-900/40 backdrop-blur-xl rounded-[2.5rem] border border-outline-variant/10 shadow-2xl transition-all duration-500 hover:-translate-y-2 overflow-hidden hover:shadow-2xl"
                                     style="--hover-glow: {{ $themeColor }}30;">
                                    <a href="{{ $route }}" class="absolute inset-0 z-30" aria-label="{{ $game->localized_title }}"></a>
                                    
                                    <!-- Image Area -->
                                    <div class="relative aspect-square overflow-hidden bg-surface-variant/20">
                                        @if ($game->image_url)
                                            <img src="{{ $game->image_url }}" alt="{{ $game->localized_title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                        @else
                                            <div class="absolute inset-0 flex items-center justify-center p-8 text-center" style="background: linear-gradient(135deg, {{ $themeColor }}10, {{ $themeColor }}20)">
                                                <span class="text-xl font-display font-black uppercase tracking-tighter opacity-40" style="color: {{ $themeColor }}">{{ $game->localized_title }}</span>
                                            </div>
                                        @endif
                                        
                                        <!-- Overlay for better name clarity -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    </div>
 
                                    <!-- Content Area -->
                                    <div class="p-6 space-y-4">
                                        <h3 class="text-xl font-display font-black text-on-surface uppercase tracking-tight transition-colors line-clamp-1"
                                            style="color: inherit;"
                                            onmouseover="this.style.color='{{ $themeColor }}'" 
                                            onmouseout="this.style.color='inherit'">
                                            {{ $game->localized_title }}
                                        </h3>
                                        
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-1.5 text-on-surface-variant/50 text-[10px] font-display font-black uppercase tracking-widest">
                                                <span class="material-symbols-outlined text-sm">play_circle</span>
                                                {{ __('Quick Play') }}
                                            </div>
                                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-lg transition-transform group-hover:scale-110" 
                                                 style="background: {{ $themeColor }}; color: white; box-shadow: 0 4px 15px {{ $themeColor }}40;">
                                                <span class="material-symbols-outlined text-sm">play_arrow</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
 
        <!-- AEO Content Blocks -->
        <div class="grid lg:grid-cols-2 gap-12 mt-24">
            <!-- Definition Block -->
            <section class="bg-surface-variant/20 rounded-[2.5rem] p-8 sm:p-12 border border-outline-variant/10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary/10 border border-secondary/20 text-secondary text-[10px] font-display font-black uppercase tracking-[0.2em] mb-6">
                    {{ __('About Us') }}
                </div>
                <h2 class="text-3xl sm:text-4xl font-display font-black uppercase tracking-tight mb-6 leading-tight">
                    {{ __('What is Gamesiano?') }}
                </h2>
                <p class="text-on-surface-variant text-lg leading-relaxed font-medium">
                    {{ __('Gamesiano is the ultimate gaming hub for interactive challenges and online games. We provide a seamless platform for players to test their skills across various genres including sports, logic, and trivia. Our mission is to make gaming accessible and fun for everyone, everywhere.') }}
                </p>
            </section>
 
            <!-- FAQ Section -->
            <section class="space-y-8">
                <div>
                    <h2 class="text-3xl font-display font-black uppercase tracking-tight mb-2">{{ __('Frequently Asked Questions') }}</h2>
                    <p class="text-on-surface-variant text-sm font-medium">{{ __('Everything you need to know about Gamesiano and how to play.') }}</p>
                </div>
 
                <div class="space-y-4">
                    @php
                        $faqs = [
                            ['q' => 'Is Gamesiano free to play?', 'a' => 'Yes, Gamesiano is completely free to play. You can access all our basic games and challenges without any subscription.'],
                            ['q' => 'Do I need to create an account?', 'a' => 'No, you can play most games as a guest. However, creating an account allows you to save your progress and track your achievements.'],
                            ['q' => 'How often are new games added?', 'a' => 'We add new games and challenges weekly to keep the experience fresh and exciting.'],
                            ['q' => 'What devices are supported?', 'a' => 'Gamesiano is optimized for both desktop and mobile devices. You can play directly in your browser on any modern device.'],
                        ];
                    @endphp
 
                    @foreach($faqs as $faq)
                        <div class="group bg-surface border border-outline-variant/10 rounded-2xl p-6 transition-all hover:border-primary/30">
                            <h3 class="text-lg font-display font-black uppercase tracking-tight mb-2 group-hover:text-primary transition-colors">
                                {{ __($faq['q']) }}
                            </h3>
                            <p class="text-on-surface-variant text-sm leading-relaxed">
                                {{ __($faq['a']) }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </section>
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
