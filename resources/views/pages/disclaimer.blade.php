@extends('layouts.app')

@section('content')
    <div class="container static-page">
        <div class="page-header">
            <h1>Disclaimer</h1>
            <p class="subtitle">Important information regarding game content and solutions.</p>
        </div>

        <div class="page-content">
            <div class="disclaimer-hero">
                <p>Football Mystery is an independent fan-made platform for entertainment and trivia purposes.</p>
            </div>

            <section>
                <h2>Entertainment Only</h2>
                <p>All hints, solutions, and answers provided across our games are for <strong>entertainment purposes
                        only</strong>. While we strive for 100% accuracy in our database, we do not claim to be the official
                    source for football statistics or historical records.</p>
            </section>

            <section>
                <h2>Not Official Solutions</h2>
                <p>The answers presented in our games (e.g., player names, kit years, stadium details) should not be used as
                    official references for legal, commercial, or professional decisions. We are not affiliated with,
                    endorsed by, or sponsored by FIFA, UEFA, or any specific football league, club, or player.</p>
            </section>

            <section>
                <h2>Fair Use Notice</h2>
                <p>This site may contain copyrighted material, the use of which has not always been specifically authorized
                    by the copyright owner. We are making such material available in our efforts to provide trivia and
                    commentary on football history. We believe this constitutes a 'fair use' of any such copyrighted
                    material as provided for in section 107 of the US Copyright Law.</p>
            </section>

            <div class="disclaimer-footer">
                <p>If you believe any content on our site is inaccurate or violates intellectual property rights, please <a
                        href="{{ route('contact') }}">contact us</a> immediately.</p>
            </div>
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
                color: #ef4444;
                /* Alert color */
                margin-bottom: 1rem;
            }

            .subtitle {
                color: var(--text-dim);
                font-size: 1.1rem;
            }

            .disclaimer-hero {
                background: #fffcf0;
                border-left: 6px solid #f59e0b;
                padding: 2rem;
                margin-bottom: 3rem;
                border-radius: 0 12px 12px 0;
                font-size: 1.25rem;
                font-weight: 600;
                color: #92400e;
            }

            .page-content h2 {
                font-family: 'Outfit', sans-serif;
                font-size: 1.75rem;
                color: var(--pitch-dark);
                margin-bottom: 1rem;
            }

            .page-content p {
                margin-bottom: 1.5rem;
                line-height: 1.8;
                color: var(--text-main);
            }

            .disclaimer-footer {
                margin-top: 3rem;
                padding-top: 2rem;
                border-top: 1px solid var(--glass-border);
                text-align: center;
                font-style: italic;
            }

            .disclaimer-footer a {
                color: var(--stadium-green);
                text-decoration: underline;
            }
        </style>
    @endpush
@endsection