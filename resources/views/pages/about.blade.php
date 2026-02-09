@extends('layouts.app')

@section('content')
    <div class="container static-page">
        <div class="page-header">
            <h1>About Football Mystery</h1>
            <p class="subtitle">The ultimate destination for football trivia enthusiasts.</p>
        </div>

        <div class="page-content">
            <section>
                <h2>Our Mission</h2>
                <p>Football Mystery was born out of a deep-seated passion for the beautiful game. Our mission is to
                    challenge the knowledge of football fans worldwide through engaging, high-fidelity visual puzzles and
                    interactive trivia.</p>
            </section>

            <section>
                <h2>The Experience</h2>
                <p>We believe that football trivia should be more than just text-based questions. That's why we've designed
                    a suite of interactive games that test your eyes as much as your memory:</p>
                <ul>
                    <li><strong>Kit Detective:</strong> Can you identify a legendary team from just a close-up of their
                        fabric?</li>
                    <li><strong>Silhouette:</strong> Recognizing the world's best players by their iconic outlines.</li>
                    <li><strong>Stadium Spotter:</strong> Pinpointing the world's most famous arenas from unique
                        perspectives.</li>
                    <li><strong>Career Path:</strong> Tracing the journeys of football legends through the clubs they've
                        represented.</li>
                    <li><strong>Highlight Moments:</strong> Guessing the player or event from classic clips and
                        celebrations.</li>
                </ul>
            </section>

            <section>
                <h2>Built for Fans</h2>
                <p>Whether you're a casual viewer or a hardcore statistics expert, Football Mystery offers varying levels of
                    difficulty to keep you on your toes. We are constantly updating our database with new challenges to
                    ensure there's always something fresh to solve.</p>
            </section>
        </div>
    </div>

    @push('styles')
        <style>
            .static-page {
                max-width: 800px;
                margin: 0 auto;
                padding: 4rem 2rem;
            }

            .page-header {
                text-align: center;
                margin-bottom: 3rem;
            }

            .page-header h1 {
                font-family: 'Outfit', sans-serif;
                font-size: 2.5rem;
                color: var(--pitch-dark);
                margin-bottom: 1rem;
            }

            .subtitle {
                color: var(--text-dim);
                font-size: 1.1rem;
            }

            .page-content section {
                margin-bottom: 2.5rem;
            }

            .page-content h2 {
                font-family: 'Outfit', sans-serif;
                font-size: 1.75rem;
                color: var(--stadium-green);
                margin-bottom: 1rem;
            }

            .page-content p {
                margin-bottom: 1.5rem;
                line-height: 1.8;
            }

            .page-content ul {
                margin-bottom: 1.5rem;
                padding-left: 1.5rem;
            }

            .page-content li {
                margin-bottom: 0.75rem;
            }
        </style>
    @endpush
@endsection