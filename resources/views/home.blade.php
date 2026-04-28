@extends('layouts.app')

@section('content')
    <div class="hero">
        <div class="hero-content">
            <span class="badge">Your Arena</span>
            <h1>Bookmarked Games</h1>
            <p>Quick access to your favorite football mysteries.</p>
        </div>
    </div>

    <div class="container">
        <div id="no-bookmarks" class="empty-state" style="display: none;">
            <div class="empty-icon">🔖</div>
            <h2>No Bookmarks Yet</h2>
            <p>Games you bookmark will appear here for quick access.</p>
            <a href="{{ route('games.index') }}" class="btn btn-primary">Discover Games</a>
        </div>

        <div id="bookmarks-grid" class="games-grid">
            @foreach($games as $game)
                @php
                    $route = route('games.play', $game->slug);
                @endphp
                <div class="game-card-wrapper bookmark-item" data-id="{{ $game->id }}" style="display: none; position: relative;">
                    <button class="bookmark-btn active" onclick="event.preventDefault(); toggleBookmark({{ $game->id }})" data-id="{{ $game->id }}" style="position: absolute; top: 1rem; right: 1rem; z-index: 10;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                        </svg>
                    </button>
                    <a href="{{ $route }}" class="game-card">
                        @if ($game->image)
                            <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->title }}">
                        @else
                            <div class="placeholder-img">
                                <span>{{ $game->title }}</span>
                            </div>
                        @endif
                        <div class="game-info">
                            <h2>{{ $game->title }}</h2>
                            <p>{{ $game->description }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    @push('styles')
        <style>
            .hero { padding: 4rem 1rem; text-align: center; margin-bottom: 1rem; }
            .hero h1 { font-family: 'Outfit', sans-serif; font-size: 2.5rem; color: var(--pitch-dark); margin-bottom: 0.5rem; }
            .hero p { color: var(--text-dim); }
            
            .empty-state { text-align: center; padding: 4rem 1rem; }
            .empty-icon { font-size: 4rem; margin-bottom: 1rem; }
            .empty-state h2 { font-family: 'Outfit', sans-serif; margin-bottom: 0.5rem; }
            .empty-state p { margin-bottom: 2rem; color: var(--text-dim); }

            .games-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
                gap: 2rem;
                margin-top: 2rem;
            }

            .game-card {
                background: white;
                border: 1px solid var(--glass-border);
                border-radius: 20px;
                overflow: hidden;
                box-shadow: var(--shadow);
                transition: var(--transition);
                text-decoration: none;
                color: inherit;
                display: flex;
                flex-direction: column;
                position: relative;
            }

            .game-card::after {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, transparent 60%, rgba(0, 0, 0, 0.6) 100%);
                opacity: 0.3;
                transition: var(--transition);
            }

            .game-card:hover {
                transform: translateY(-8px);
                border-color: var(--stadium-green);
                box-shadow: 0 12px 24px rgba(46, 160, 67, 0.1);
            }

            .game-card:hover::after {
                opacity: 0.5;
            }

            .game-card img {
                width: 100%;
                height: 240px;
                object-fit: cover;
                transition: var(--transition);
            }

            .game-card:hover img {
                transform: scale(1.05);
            }

            .placeholder-img {
                width: 100%;
                height: 240px;
                background: linear-gradient(135deg, #f0f7f1, #e6f0e8);
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: 'Outfit', sans-serif;
                font-weight: 700;
                font-size: 1.25rem;
                color: var(--pitch-green);
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            .game-info {
                padding: 1.5rem;
                position: relative;
                z-index: 2;
            }

            .game-info h2 {
                font-family: 'Outfit', sans-serif;
                font-size: 1.3rem;
                margin-bottom: 0.5rem;
                color: var(--pitch-dark);
            }

            .game-info p {
                color: var(--text-dim);
                font-size: 0.95rem;
                line-height: 1.4;
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