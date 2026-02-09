@extends('layouts.app')

@section('content')
    <div class="container static-page">
        <div class="page-header">
            <h1>Privacy Policy</h1>
            <p class="subtitle">Last Updated: February 2026</p>
        </div>

        <div class="page-content">
            <section>
                <h2>1. Introduction</h2>
                <p>Welcome to Football Mystery. We value your privacy and are committed to being transparent about how we
                    handle any information you share with us while playing our games.</p>
            </section>

            <section>
                <h2>2. Information We Collect</h2>
                <p>Football Mystery is designed to be played without requiring an account for most features. We do not
                    collect personal identifying information (PII) like your name or address unless you explicitly provide
                    it through our contact forms or future authentication features.</p>
                <p>We may collect non-personal information such as:</p>
                <ul>
                    <li>Browser type and version</li>
                    <li>Anonymous game performance metrics (e.g., win/loss ratios)</li>
                    <li>Device information for optimization purposes</li>
                </ul>
            </section>

            <section>
                <h2>3. Cookies</h2>
                <p>We use essential cookies to remember your game progress and preferences (like dark mode or sound
                    settings). These are necessary for the site to function correctly.</p>
            </section>

            <section>
                <h2>4. Third-Party Services</h2>
                <p>We use Third-Party services such as YouTube for video content. These services may collect their own data
                    according to their respective privacy policies.</p>
            </section>

            <section>
                <h2>5. Data Security</h2>
                <p>We implement industry-standard security measures to protect the integrity of our site and any data we
                    store. However, no internet transmission is 100% secure.</p>
            </section>

            <section>
                <h2>6. Changes to This Policy</h2>
                <p>We may update this policy periodically. Any changes will be reflected on this page with an updated "Last
                    Updated" date.</p>
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
                border-left: 4px solid var(--stadium-green);
                padding-left: 1rem;
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