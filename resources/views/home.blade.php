@extends('layouts.app')

@section('content')
    <div class="container home-shell">
        <div class="hero panel home-hero">
            <div class="hero-content">
                <span class="badge">{{ __('Your Arena') }}</span>
                <h1>{{ __('Bookmarked Games') }}</h1>
                <p>{{ __('Jump back into your saved challenges with a cleaner, faster hub built for repeat play.') }}</p>
            </div>
            <div class="hero-aside">
                <div class="hero-stat">
                    <strong>{{ $games->count() }}</strong>
                    <span>{{ __('Total active game modes') }}</span>
                </div>
                <a href="{{ route('games.index') }}" class="btn btn-primary">{{ __('Browse All Games') }}</a>
            </div>
        </div>

        <div id="no-bookmarks" class="empty-state" style="display: none;">
            <div class="empty-icon">🔖</div>
            <h2>{{ __('No Bookmarks Yet') }}</h2>
            <p>{{ __('Save games from the library and they will show up here for instant access on your next visit.') }}</p>
            <a href="{{ route('games.index') }}" class="btn btn-primary">{{ __('Discover Games') }}</a>
        </div>

        <div id="bookmarks-grid" class="games-grid">
            @foreach($games as $game)
                @php
                    $route = route('games.play', ['slug' => $game->slug]);
                @endphp
                <div class="game-card-wrapper bookmark-item" data-id="{{ $game->id }}" style="display: none;">
                    <button class="bookmark-btn active card-bookmark" type="button"
                        onclick="event.preventDefault(); toggleBookmark({{ $game->id }})" data-id="{{ $game->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                        </svg>
                    </button>
                    <a href="{{ $route }}" class="game-card">
                        <div class="game-media">
                            @if ($game->image_url)
                                <img src="{{ $game->image_url }}" alt="{{ $game->localized_title }}">
                            @else
                                <div class="placeholder-img">
                                    <span>{{ $game->localized_title }}</span>
                                </div>
                            @endif
                            <div class="media-shine"></div>
                            <span class="game-meta-chip">{{ $game->genre?->localized_name ?? __('Featured Game') }}</span>
                        </div>
                        <div class="game-info">
                            <div class="game-copy">
                                <h2>{{ $game->localized_title }}</h2>
                                <p>{{ $game->localized_description }}</p>
                            </div>
                            <span class="play-cta">{{ __('Play now') }}</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    @push('styles')
        <style>
            .home-shell {
                display: grid;
                gap: 1.5rem;
            }

            .home-hero {
                padding: clamp(1.5rem, 3vw, 2.4rem);
                display: grid;
                grid-template-columns: minmax(0, 1.7fr) minmax(240px, 0.8fr);
                gap: 1.5rem;
                align-items: end;
                background: linear-gradient(135deg, rgba(59, 130, 246, 0.16), rgba(16, 185, 129, 0.1)), var(--surface);
                position: relative;
                overflow: hidden;
            }

            .home-hero::before,
            .home-hero::after {
                content: '';
                position: absolute;
                border-radius: 999px;
                pointer-events: none;
                filter: blur(16px);
            }

            .home-hero::before {
                width: 180px;
                height: 180px;
                inset-inline-end: -40px;
                top: -50px;
                background: rgba(59, 130, 246, 0.18);
            }

            .home-hero::after {
                width: 140px;
                height: 140px;
                inset-inline-start: 45%;
                bottom: -70px;
                background: rgba(16, 185, 129, 0.14);
            }

            .hero-content h1 {
                font-family: var(--font-display);
                font-size: clamp(2.2rem, 6vw, 4.6rem);
                line-height: 0.96;
                letter-spacing: -0.05em;
                margin: 0.9rem 0 0.8rem;
            }

            .hero-content p {
                max-width: 60ch;
                color: var(--text-muted);
                font-size: 1.02rem;
            }

            .hero-aside {
                display: grid;
                gap: 0.9rem;
                justify-items: start;
            }

            .hero-stat {
                width: 100%;
                background: rgba(var(--surface-rgb), 0.6);
                border: 1px solid var(--border-soft);
                border-radius: 22px;
                padding: 1rem 1.15rem;
            }

            .hero-stat strong {
                display: block;
                font-family: var(--font-display);
                font-size: 2rem;
                line-height: 1;
                margin-bottom: 0.35rem;
            }

            .hero-stat span {
                color: var(--text-soft);
                font-size: 0.9rem;
                font-weight: 700;
            }
            
            .empty-state {
                text-align: center;
                padding: 3rem 1.5rem;
                background: var(--surface);
                border: 1px solid var(--border-soft);
                border-radius: 28px;
                box-shadow: var(--shadow-soft);
            }

            .empty-icon {
                font-size: 4rem;
                margin-bottom: 1rem;
            }

            .empty-state h2 {
                font-family: var(--font-display);
                margin-bottom: 0.6rem;
            }

            .empty-state p {
                margin-bottom: 1.5rem;
                color: var(--text-muted);
            }

            .games-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.3rem;
            }

            .game-card-wrapper {
                position: relative;
            }

            .card-bookmark {
                position: absolute;
                top: 1rem;
                inset-inline-end: 1rem;
                z-index: 5;
            }

            .game-card {
                background: var(--surface);
                border: 1px solid var(--border-soft);
                border-radius: 28px;
                overflow: hidden;
                box-shadow: var(--shadow-soft);
                transition: 0.24s ease;
                text-decoration: none;
                color: inherit;
                display: grid;
                position: relative;
            }

            .game-card:hover {
                transform: translateY(-8px) scale(1.01);
                border-color: rgba(59, 130, 246, 0.34);
                box-shadow: var(--shadow-elevated);
            }

            .game-media {
                position: relative;
                isolation: isolate;
                padding: 0.8rem 0.8rem 0;
            }

            .game-card img,
            .placeholder-img {
                width: 100%;
                aspect-ratio: 16 / 11;
                object-fit: cover;
                border-radius: 22px;
                transition: 0.24s ease;
            }

            .game-card:hover img {
                transform: scale(1.035);
            }

            .placeholder-img {
                background: linear-gradient(135deg, rgba(59, 130, 246, 0.18), rgba(16, 185, 129, 0.18));
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: var(--font-display);
                font-weight: 700;
                font-size: 1.25rem;
                color: var(--text);
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            .media-shine {
                position: absolute;
                inset: 0.8rem 0.8rem auto;
                height: 42%;
                border-radius: 22px 22px 120px 120px;
                background: linear-gradient(180deg, rgba(255, 255, 255, 0.26), transparent);
                z-index: 1;
                pointer-events: none;
            }

            .game-meta-chip {
                position: absolute;
                inset-inline-start: 1.35rem;
                bottom: 1rem;
                z-index: 2;
                display: inline-flex;
                align-items: center;
                padding: 0.45rem 0.8rem;
                border-radius: 999px;
                background: rgba(2, 6, 23, 0.62);
                color: white;
                border: 1px solid rgba(255, 255, 255, 0.18);
                font-size: 0.73rem;
                font-weight: 800;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                backdrop-filter: blur(10px);
            }

            .game-info {
                padding: 1.15rem 1.2rem 1.2rem;
                display: flex;
                align-items: end;
                justify-content: space-between;
                gap: 1rem;
            }

            .game-copy {
                min-width: 0;
            }

            .game-info h2 {
                font-family: var(--font-display);
                font-size: 1.38rem;
                margin-bottom: 0.5rem;
                color: var(--text);
                line-height: 1.05;
            }

            .game-info p {
                color: var(--text-muted);
                font-size: 0.95rem;
                line-height: 1.5;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .play-cta {
                flex: 0 0 auto;
                display: inline-flex;
                align-items: center;
                gap: 0.45rem;
                padding: 0.7rem 0.95rem;
                border-radius: 999px;
                background: rgba(59, 130, 246, 0.1);
                color: var(--accent-strong);
                font-size: 0.85rem;
                font-weight: 800;
                white-space: nowrap;
            }

            .play-cta::after {
                content: '↗';
                font-size: 0.95rem;
            }

            @media (max-width: 900px) {
                .home-hero {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 640px) {
                .hero-aside {
                    justify-items: stretch;
                }

                .game-info {
                    flex-direction: column;
                    align-items: stretch;
                }

                .play-cta {
                    justify-content: center;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const bookmarkedIds = getBookmarks();
                const items = document.querySelectorAll('.bookmark-item');
                let found = 0;

                items.forEach(item => {
                    const id = parseInt(item.getAttribute('data-id'));
                    if (bookmarkedIds.includes(id)) {
                        item.style.display = 'flex';
                        found++;
                    }
                });

                if (found === 0) {
                    document.getElementById('no-bookmarks').style.display = 'block';
                }
            });

            // Overriding toggleBookmark to also hide items on Home page
            const originalToggle = toggleBookmark;
            toggleBookmark = function(gameId) {
                originalToggle(gameId);
                const bookmarks = getBookmarks();
                if (!bookmarks.includes(gameId)) {
                    const item = document.querySelector(`.bookmark-item[data-id="${gameId}"]`);
                    if (item) {
                        item.style.opacity = '0';
                        setTimeout(() => {
                            item.remove();
                            if (document.querySelectorAll('.bookmark-item').length === 0) {
                                document.getElementById('no-bookmarks').style.display = 'block';
                            }
                        }, 300);
                    }
                }
            };
        </script>
    @endpush
@endsection
