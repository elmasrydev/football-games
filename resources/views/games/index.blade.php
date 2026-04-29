@extends('layouts.app')

@section('content')
    <div class="container">
        <section class="games-section">
            <div class="section-header panel">
                <div>
                    <span class="badge">{{ __('Game Library') }}</span>
                    <h1>{{ __('Available Challenges') }}</h1>
                    <p>{{ __('Choose a mode, switch theme or direction whenever you want, and keep the current gameplay intact.') }}</p>
                </div>
                <div class="section-summary">
                    <strong>{{ $games->count() }}</strong>
                    <span>{{ __('Active game modes') }}</span>
                </div>
            </div>
            <div class="games-grid">
                @forelse($games as $game)
                    @php
                        $route = route('games.play', ['slug' => $game->slug]);
                    @endphp
                    <div class="game-card-wrapper">
                        <button class="bookmark-btn card-bookmark" type="button"
                            onclick="event.preventDefault(); toggleBookmark({{ $game->id }})" data-id="{{ $game->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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
                @empty
                    <div class="no-games">
                        <p>{{ __('No games found. New mysteries are coming soon!') }}</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    @push('styles')
        <style>
            .games-section {
                display: grid;
                gap: 1.5rem;
            }

            .section-header {
                display: grid;
                grid-template-columns: minmax(0, 1fr) auto;
                gap: 1rem;
                align-items: end;
                padding: clamp(1.5rem, 3vw, 2.3rem);
                background: linear-gradient(135deg, rgba(59, 130, 246, 0.14), rgba(16, 185, 129, 0.1)), var(--surface);
                position: relative;
                overflow: hidden;
            }

            .section-header::before,
            .section-header::after {
                content: '';
                position: absolute;
                border-radius: 999px;
                pointer-events: none;
                filter: blur(16px);
            }

            .section-header::before {
                width: 200px;
                height: 200px;
                inset-inline-end: -50px;
                top: -80px;
                background: rgba(59, 130, 246, 0.18);
            }

            .section-header::after {
                width: 160px;
                height: 160px;
                inset-inline-start: 38%;
                bottom: -90px;
                background: rgba(16, 185, 129, 0.12);
            }

            .section-header h1 {
                font-family: var(--font-display);
                font-size: clamp(2rem, 5vw, 3.8rem);
                line-height: 0.98;
                letter-spacing: -0.05em;
                margin: 0.85rem 0 0.7rem;
            }

            .section-header p {
                color: var(--text-muted);
                font-size: 1.02rem;
                max-width: 62ch;
            }

            .section-summary {
                background: rgba(var(--surface-rgb), 0.62);
                border: 1px solid var(--border-soft);
                border-radius: 22px;
                padding: 1rem 1.15rem;
                min-width: 180px;
            }

            .section-summary strong {
                display: block;
                font-family: var(--font-display);
                font-size: 2rem;
                line-height: 1;
                margin-bottom: 0.35rem;
            }

            .section-summary span {
                color: var(--text-soft);
                font-size: 0.9rem;
                font-weight: 700;
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
                z-index: 10;
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

            .no-games {
                grid-column: 1 / -1;
                text-align: center;
                padding: 3rem 2rem;
                background: var(--surface);
                border: 1px solid var(--border-soft);
                border-radius: 28px;
                box-shadow: var(--shadow-soft);
                color: var(--text-muted);
            }

            @media (max-width: 780px) {
                .section-header {
                    grid-template-columns: 1fr;
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
                bookmarkedIds.forEach(id => {
                    updateBookmarkUI(id);
                });
            });
        </script>
    @endpush
@endsection
