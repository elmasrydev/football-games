@extends('layouts.app')

@section('content')
    <div class="container">
        <section class="games-section">
            <div class="section-header">
                <h1>Available Challenges</h1>
                <p>Choose your game mode and start the mystery.</p>
            </div>
            <div class="games-grid">
                @forelse($games as $game)
                    @php
                        $route = match ($game->slug) {
                            'stadium-spotter' => route('games.stadium.play'),
                            'career' => route('games.career.play'),
                            'kit-detective' => route('games.kit.play'),
                            'trophy-hunter' => route('games.trophy.play'),
                            'guess-silhouette' => route('games.silhouette.play'),
                            'celebration-station' => route('games.celebration.play'),
                            default => route('games.bw.play', ['game' => $game->slug]),
                        };
                    @endphp
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
                @empty
                    <div class="no-games">
                        <p>No games found. New mysteries are coming soon!</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    @push('styles')
        <style>
            .games-section {
                padding: 4rem 0;
            }

            .section-header {
                text-align: center;
                margin-bottom: 4rem;
            }

            .section-header h1 {
                font-family: 'Outfit', sans-serif;
                font-size: 2.5rem;
                margin-bottom: 0.5rem;
                color: var(--pitch-dark);
            }

            .section-header p {
                color: var(--text-dim);
                font-size: 1.1rem;
            }

            .games-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
                gap: 2rem;
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

            .no-games {
                grid-column: 1 / -1;
                text-align: center;
                padding: 4rem 2rem;
                background: white;
                border: 1px solid var(--glass-border);
                border-radius: 20px;
                box-shadow: var(--shadow);
            }
        </style>
    @endpush
@endsection