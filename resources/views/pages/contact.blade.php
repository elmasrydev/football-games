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
                        <p>We are always looking to improve the Football Mystery experience. If you have ideas for new
                            games, suggestions for challenges, or just want to say hi, feel free to reach out.</p>
                    </section>

                    <section>
                        <h2>Support</h2>
                        <p>For technical issues or bug reports, please include details about your device and browser to help
                            us solve the problem faster.</p>
                    </section>

                    <div class="email-box">
                        <strong>Email us at:</strong>
                        <a href="mailto:support@footballmystery.com" class="contact-email">support@footballmystery.com</a>
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

            .contact-grid {
                display: grid;
                grid-template-columns: 1.5fr 1fr;
                gap: 4rem;
            }

            .page-content h2 {
                font-family: 'Outfit', sans-serif;
                font-size: 1.5rem;
                color: var(--stadium-green);
                margin-bottom: 1rem;
            }

            .page-content p {
                margin-bottom: 1.5rem;
                line-height: 1.7;
            }

            .email-box {
                background: #f8fafc;
                padding: 1.5rem;
                border-radius: 12px;
                border: 1px solid var(--glass-border);
                display: inline-block;
            }

            .contact-email {
                display: block;
                margin-top: 0.5rem;
                font-size: 1.2rem;
                color: var(--stadium-green);
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
                background: #fff;
                border: 1px solid var(--glass-border);
                border-radius: 8px;
                font-weight: 600;
                color: var(--text-dim);
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