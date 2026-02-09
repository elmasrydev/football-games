@extends('layouts.app')

@section('content')
    <div class="container static-page">
        <div class="page-header">
            <h1>Terms of Service</h1>
            <p class="subtitle">Effective Date: February 2026</p>
        </div>

        <div class="page-content">
            <section>
                <h2>1. Acceptance of Terms</h2>
                <p>By accessing or using Football Mystery, you agree to be bound by these Terms of Service. If you do not
                    agree, please do not use the site.</p>
            </section>

            <section>
                <h2>2. Use of License</h2>
                <p>We grant you a personal, non-exclusive, non-transferable license to play our games for entertainment
                    purposes only. You may not:</p>
                <ul>
                    <li>Scrape or extract data from our site for commercial use.</li>
                    <li>Attempt to bypass any technical safeguards or game mechanics.</li>
                    <li>Redistribute our custom game assets without prior written consent.</li>
                </ul>
            </section>

            <section>
                <h2>3. Intellectual Property</h2>
                <p>The "Football Mystery" brand, our custom code, game logic, and proprietary visual assets are the
                    intellectual property of Football Mystery. Team logos, player images, and video clips are used for
                    trivia and educational purposes under "Fair Use" or provided via third-party APIs.</p>
            </section>

            <section>
                <h2>4. Limitation of Liability</h2>
                <p>Football Mystery is provided "as is." We do not guarantee that the site will always be available or
                    error-free. We are not liable for any damages arising from your use of the site.</p>
            </section>

            <section>
                <h2>5. Termination</h2>
                <p>We reserve the right to terminate or suspend access to our service at any time, without prior notice, for
                    conduct that we believe violates these Terms.</p>
            </section>

            <section>
                <h2>6. Governing Law</h2>
                <p>These terms are governed by and construed in accordance with the laws of the jurisdiction in which we
                    operate, without regard to its conflict of law provisions.</p>
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
                font-size: 2.25rem;
                color: var(--pitch-dark);
                margin-bottom: 0.5rem;
            }

            .subtitle {
                color: var(--text-dim);
                font-size: 0.9rem;
            }

            .page-content section {
                margin-bottom: 2rem;
            }

            .page-content h2 {
                font-family: 'Outfit', sans-serif;
                font-size: 1.25rem;
                color: var(--pitch-dark);
                margin-bottom: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            .page-content p {
                margin-bottom: 1rem;
                color: var(--text-main);
                line-height: 1.7;
            }

            .page-content ul {
                margin-bottom: 1.5rem;
                padding-left: 1.5rem;
            }

            .page-content li {
                margin-bottom: 0.5rem;
            }
        </style>
    @endpush
@endsection