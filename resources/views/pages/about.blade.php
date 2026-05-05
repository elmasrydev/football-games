@extends('layouts.app')

@section('content')
    <div class="container static-page mt-20">
        <div class="page-header">
            <h1 class="text-4xl font-display font-black uppercase tracking-tight">{{ __('About Gamesiano') }}</h1>
            <p class="subtitle text-on-surface-variant font-medium mt-4">{{ __('The ultimate hub for interactive games and visual challenges.') }}</p>
        </div>

        <div class="page-content space-y-12">
            <section>
                <h2 class="text-2xl font-display font-black uppercase tracking-tight mb-4">{{ __('Our Mission') }}</h2>
                <p class="text-on-surface-variant leading-relaxed">{{ __('Gamesiano was built to make knowledge-based games feel more interactive, more visual, and more fun. Our mission is to create polished challenge experiences that reward curiosity, memory, and pattern recognition for players globally.') }}</p>
            </section>

            <section>
                <h2 class="text-2xl font-display font-black uppercase tracking-tight mb-4">{{ __('The Experience') }}</h2>
                <p class="text-on-surface-variant leading-relaxed">{{ __('We believe trivia and puzzle games should be more than plain text prompts. That is why Gamesiano is designed around visual clues, progression, hints, and multiple styles of interaction:') }}</p>
                <ul class="list-disc list-inside space-y-3 text-on-surface-variant ps-4">
                    <li><strong>{{ __('Visual Guessing:') }}</strong> {{ __('Identify people, places, or moments from cropped images and silhouettes.') }}</li>
                    <li><strong>{{ __('Word Puzzles:') }}</strong> {{ __('Solve anagrams, fill in missing letters, and discover hidden terms.') }}</li>
                    <li><strong>{{ __('Connection Challenges:') }}</strong> {{ __('Follow sequences, relationships, and grouped clues.') }}</li>
                    <li><strong>{{ __('Progressive Hints:') }}</strong> {{ __('Reveal help gradually instead of jumping straight to the answer.') }}</li>
                    <li><strong>{{ __('Fast Replay:') }}</strong> {{ __('Move quickly between levels and return to bookmarked favorites.') }}</li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-display font-black uppercase tracking-tight mb-4">{{ __('Built for Players') }}</h2>
                <p class="text-on-surface-variant leading-relaxed">{{ __('Whether you prefer light challenges or more demanding puzzles, Gamesiano is designed to support a wide range of play styles. New challenges and content are added weekly so there is always something fresh to explore.') }}</p>
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
