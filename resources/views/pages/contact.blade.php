@extends('layouts.app')

@section('content')
    <div class="container static-page">
        <div class="page-header">
            <h1>Contact Us</h1>
            <p class="subtitle">Have a suggestion or found a bug? We'd love to hear from you.</p>
        </div>

        <div class="page-content">
            <div class="contact-grid">
                <div class="contact-info">
                    <section>
                        <h2>Get in Touch</h2>
                        <p>We are always looking to improve the Games Hub experience. If you have ideas for new
                            games, suggestions for challenges, or just want to say hi, feel free to reach out.</p>
                    </section>

                    <section>
                        <h2>Support</h2>
                        <p>For technical issues or bug reports, please include details about your device and browser to help
                            us solve the problem faster.</p>
                    </section>

                    <div class="email-box">
                        <strong>Email us at:</strong>
                        <a href="mailto:support@gameshub.com" class="contact-email">support@gameshub.com</a>
                    </div>
                </div>

                <div class="social-connect">
                    <section>
                        <h2>Follow the Mystery</h2>
                        <p>Stay updated with our latest challenges and community news on our social channels.</p>
                        <div class="social-links">
                            <span class="social-placeholder">Twitter / X</span>
                            <span class="social-placeholder">Instagram</span>
                            <span class="social-placeholder">TikTok</span>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .static-page {
                max-width: 900px;
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

            .contact-grid {
                display: grid;
                grid-template-columns: 1.5fr 1fr;
                gap: 4rem;
            }

            .page-content h2 {
                font-family: var(--font-display);
                font-size: 1.5rem;
                color: var(--accent-strong);
                margin-bottom: 1rem;
            }

            .page-content p {
                margin-bottom: 1.5rem;
                line-height: 1.7;
            }

            .email-box {
                background: rgba(var(--surface-muted-rgb), 0.9);
                padding: 1.5rem;
                border-radius: 20px;
                border: 1px solid var(--border-soft);
                display: inline-block;
            }

            .contact-email {
                display: block;
                margin-top: 0.5rem;
                font-size: 1.2rem;
                color: var(--accent-strong);
                text-decoration: none;
                font-weight: 600;
            }

            .social-links {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .social-placeholder {
                padding: 0.75rem 1rem;
                background: rgba(var(--surface-rgb), 0.6);
                border: 1px solid var(--border-soft);
                border-radius: 16px;
                font-weight: 600;
                color: var(--text-muted);
            }

            @media (max-width: 768px) {
                .contact-grid {
                    grid-template-columns: 1fr;
                    gap: 2rem;
                }
            }
        </style>
    @endpush
@endsection
