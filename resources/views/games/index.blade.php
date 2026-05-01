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
                <div class="text-3xl font-display font-black text-primary leading-none">{{ $totalGamesCount }}</div>
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

    <!-- Genre Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
        @forelse($genres as $genre)
            <div class="group relative flex flex-col bg-surface-variant/40 dark:bg-zinc-900/40 backdrop-blur-xl rounded-[1rem] overflow-hidden border border-outline-variant/10 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/20 hover:border-primary/30">
                <a href="{{ route('games.genre', ['genre_slug' => $genre->slug]) }}" class="absolute inset-0 z-30" aria-label="{{ $genre->localized_name }}"></a>
                
                <!-- Image Area -->
                <div class="relative aspect-video overflow-hidden">
                    @if ($genre->image_url)
                        <img src="{{ $genre->image_url }}" alt="{{ $genre->localized_name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center p-8">
                            <span class="text-4xl group-hover:scale-125 transition-transform duration-500">{{ $genre->icon ?? '🧩' }}</span>
                        </div>
                    @endif
                    
                    <!-- Icon Badge -->
                    <div class="absolute bottom-4 left-4 z-20">
                        <div class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white text-xl">
                            {{ $genre->icon ?? '🧩' }}
                        </div>
                    </div>

                    <!-- Subtle Bottom Gradient -->
                    <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>

                <!-- Content Area -->
                <div class="p-6 space-y-4 flex flex-grow flex-col">
                    <div class="space-y-2">
                        <h3 class="text-2xl font-display font-black text-on-surface uppercase tracking-tight group-hover:text-primary transition-colors line-clamp-1">
                            {{ $genre->localized_name }}
                        </h3>
                        <p class="text-on-surface-variant/70 text-xs font-medium line-clamp-2 leading-relaxed">
                            {{ $genre->localized_description ?: __('Explore our curated collection of :genre games and challenges.', ['genre' => $genre->localized_name]) }}
                        </p>
                    </div>

                    <!-- Footer -->
                    <div class="pt-4 mt-auto border-t border-outline-variant/10 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-on-surface-variant/50 text-[10px] font-display font-black uppercase tracking-widest">
                            <span class="material-symbols-outlined text-sm">sports_esports</span>
                            <span>{{ $genre->games_count }} {{ __('Games') }}</span>
                        </div>
                        
                        <div class="flex items-center gap-2 text-primary font-display font-black text-xs uppercase tracking-wider group-hover:gap-3 transition-all">
                            <div class="w-8 h-8 rounded-xl bg-primary text-on-primary flex items-center justify-center shadow-lg shadow-primary/20 group-hover:scale-110 transition-transform active:scale-95">
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center glass-card rounded-[2.5rem]">
                <p class="text-on-surface-variant font-display font-bold uppercase tracking-widest">{{ __('No genres found. New worlds are coming soon!') }}</p>
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
