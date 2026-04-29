@extends('layouts.app')

@section('content')
    <div class="container static-page">
        <div class="page-header">
            <h1>About Games Hub</h1>
            <p class="subtitle">A place for visual puzzles, trivia, and interactive challenge games.</p>
        </div>

        <div class="page-content">
            <section>
                <h2>Our Mission</h2>
                <p>Games Hub was built to make knowledge-based games feel more interactive, more visual, and more fun.
                    Our mission is to create polished challenge experiences that reward curiosity, memory, and pattern
                    recognition.</p>
            </section>

            <section>
                <h2>The Experience</h2>
                <p>We believe trivia and puzzle games should be more than plain text prompts. That is why the platform is
                    designed around visual clues, progression, hints, and multiple styles of interaction:</p>
                <ul>
                    <li><strong>Visual Guessing:</strong> Identify people, places, or moments from cropped images and
                        silhouettes.</li>
                    <li><strong>Word Puzzles:</strong> Solve anagrams, fill in missing letters, and discover hidden terms.</li>
                    <li><strong>Connection Challenges:</strong> Follow sequences, relationships, and grouped clues.</li>
                    <li><strong>Progressive Hints:</strong> Reveal help gradually instead of jumping straight to the answer.</li>
                    <li><strong>Fast Replay:</strong> Move quickly between levels and return to bookmarked favorites.</li>
                </ul>
            </section>

            <section>
                <h2>Built for Players</h2>
                <p>Whether you prefer light challenges or more demanding puzzles, Games Hub is designed to support a wide
                    range of play styles. New challenges and content can be added continuously so there is always
                    something fresh to explore.</p>
            </section>
        </div>
    </div>

    @push('styles')
        <style>
            .static-page {
                max-width: 800px;
                margin: 0 auto;
                padding: 1rem 0;
            }

            .page-header {
                text-align: center;
                margin-bottom: 3rem;
            }

            .page-header h1 {
                font-family: var(--font-display);
                font-size: 2.5rem;
                color: var(--text);
                margin-bottom: 1rem;
            }

            .subtitle {
                color: var(--text-soft);
                font-size: 1.1rem;
            }

            .page-content section {
                margin-bottom: 2.5rem;
            }

            .page-content h2 {
                font-family: var(--font-display);
                font-size: 1.75rem;
                color: var(--accent-strong);
                margin-bottom: 1rem;
            }

            .page-content p {
                margin-bottom: 1.5rem;
                line-height: 1.8;
                color: var(--text-muted);
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
