@extends('layouts.app')

@section('content')
    <div class="hero">
        <div class="hero-content">
            <span class="badge">Live Games</span>
            <h1>The Ultimate Football Mystery Challenge</h1>
            <p>Test your knowledge and sharpen your eyes. Step into the arena where your football intuition is the only
                guide. Can you identify the legends hidden in the shadows?</p>
            <div class="hero-actions">
                <a href="{{ route('games.index') }}" class="btn btn-primary">Start Playing</a>
                <a href="#how" class="btn btn-outline">How it Works</a>
            </div>
        </div>
    </div>

    <div class="container">
        <section id="how" class="features">
            <div class="feature-card">
                <div class="feature-icon">🔍</div>
                <h3>Watch</h3>
                <p>Observe the black and white silhouette of a famous football moment. Look for clues in the movements and
                    form.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">❓</div>
                <h3>Guess</h3>
                <p>Use your football knowledge to identify the player. Every detail counts, from the kit to the
                    celebrations.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🏆</div>
                <h3>Win</h3>
                <p>Check your answer and climb the ranks. Win hints and unlock special game modes as you progress.</p>
            </div>
        </section>
    </div>

    @push('styles')
        <style>
            .hero {
                padding: 6rem 1rem;
                background: radial-gradient(circle at 70% 30%, #eefbf0 0%, transparent 70%);
                text-align: center;
                margin-bottom: 2rem;
            }

            .hero-content {
                max-width: 800px;
                margin: 0 auto;
            }

            .badge {
                display: inline-block;
                padding: 0.4rem 1rem;
                background: var(--stadium-glow);
                color: var(--stadium-green);
                border-radius: 50px;
                font-size: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 1.5px;
                margin-bottom: 1.5rem;
            }

            .hero h1 {
                font-family: 'Outfit', sans-serif;
                font-size: 3rem;
                line-height: 1.1;
                margin-bottom: 1.5rem;
                color: var(--pitch-dark);
                background: linear-gradient(135deg, var(--pitch-dark) 0%, #2ea043 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .hero p {
                font-size: 1.1rem;
                color: var(--text-dim);
                margin-bottom: 2.5rem;
                line-height: 1.6;
            }

            .hero-actions {
                display: flex;
                gap: 1rem;
                justify-content: center;
            }

            .features {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 1.5rem;
                margin-bottom: 5rem;
            }

            .feature-card {
                background: white;
                padding: 2rem;
                border-radius: 20px;
                border: 1px solid var(--glass-border);
                transition: var(--transition);
            }

            .feature-card:hover {
                transform: translateY(-5px);
                border-color: var(--stadium-green);
                box-shadow: var(--shadow);
            }

            .feature-icon {
                font-size: 2rem;
                margin-bottom: 1rem;
            }

            .feature-card h3 {
                font-family: 'Outfit', sans-serif;
                margin-bottom: 0.75rem;
                font-size: 1.25rem;
            }

            .feature-card p {
                color: var(--text-dim);
                font-size: 0.95rem;
                line-height: 1.5;
            }

            @media (max-width: 768px) {
                .hero h1 {
                    font-size: 2.25rem;
                }

                .hero {
                    padding: 4rem 1rem;
                }
            }
        </style>
    @endpush
@endsection