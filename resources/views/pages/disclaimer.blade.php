@extends('layouts.app')

@section('content')
    <div class="container static-page">
        @if(app()->getLocale() === 'ar')
            <div class="page-header">
                <h1>إخلاء المسؤولية</h1>
                <p class="subtitle">معلومات هامة بخصوص محتوى الألعاب وحلول التحديات.</p>
            </div>

            <div class="page-content">
                <div class="disclaimer-hero">
                    <p>جيمزيانو هي منصة مستقلة تم تصميمها لغرض الترفيه وحل الألغاز والأسئلة الثقافية.</p>
                </div>

                <section>
                    <h2>للترفيه فقط</h2>
                    <p>جميع التلميحات والحلول والإجابات المقدمة عبر ألعابنا هي لأغراض <strong>الترفيه والتسليّة فقط</strong>. ورغم أننا نسعى لتحقيق دقة بنسبة 100% في قاعدة بياناتنا، إلا أننا لا ندعي أننا المصدر الرسمي للسجلات التاريخية أو التصنيفات أو البيانات المرجعية من أي نوع.</p>
                </section>

                <section>
                    <h2>ليست حلولاً رسمية</h2>
                    <p>لا ينبغي استخدام الإجابات المعروضة في ألعابنا (على سبيل المثال الأسماء أو التواريخ أو المواقع أو الفئات) كمراجع رسمية للقرارات القانونية أو التجارية أو المهنية. نحن لسنا تابعين أو معتمدين أو برعاية أي هيئة إدارية أو علامة تجارية أو جهة مالكة للحقوق أو شخصية عامة.</p>
                </section>

                <section>
                    <h2>إشعار الاستخدام العادل</h2>
                    <p>قد يحتوي هذا الموقع على مواد محمية بحقوق الطبع والنشر لم يتم الترخيص باستخدامها دائماً بشكل صريح من قبل مالك الحقوق. نحن نوفر هذه المواد كجزء من جهودنا لتقديم الأسئلة والتعليقات ومحتوى التحدي التفاعلي. ونعتقد أن هذا يشكل "استخداماً عادلاً" للمواد المحمية بموجب المادة 107 من قانون حقوق الطبع والنشر الأمريكي.</p>
                </section>

                <div class="disclaimer-footer">
                    <p>إذا كنت تعتقد أن أي محتوى على موقعنا غير دقيق أو ينتهك حقوق الملكية الفكرية، يرجى <a
                            href="{{ route('contact', ['locale' => app()->getLocale()]) }}">الاتصال بنا</a> فوراً.</p>
                </div>
            </div>
        @else
            <div class="page-header">
                <h1>Disclaimer</h1>
                <p class="subtitle">Important information regarding game content and solutions.</p>
            </div>

            <div class="page-content">
                <div class="disclaimer-hero">
                    <p>Games Hub is an independent platform built for entertainment, puzzle solving, and trivia-style play.</p>
                </div>

                <section>
                    <h2>Entertainment Only</h2>
                    <p>All hints, solutions, and answers provided across our games are for <strong>entertainment purposes
                            only</strong>. While we strive for 100% accuracy in our database, we do not claim to be the official
                        source for historical records, rankings, or reference data of any kind.</p>
                </section>

                <section>
                    <h2>Not Official Solutions</h2>
                    <p>The answers presented in our games (for example names, dates, locations, or categories) should not be used as
                        official references for legal, commercial, or professional decisions. We are not affiliated with,
                        endorsed by, or sponsored by any governing body, franchise, rights holder, or public figure.</p>
                </section>

                <section>
                    <h2>Fair Use Notice</h2>
                    <p>This site may contain copyrighted material, the use of which has not always been specifically authorized
                        by the copyright owner. We are making such material available in our efforts to provide trivia,
                        commentary, and interactive challenge content. We believe this constitutes a 'fair use' of any such copyrighted
                        material as provided for in section 107 of the US Copyright Law.</p>
                </section>

                <div class="disclaimer-footer">
                    <p>If you believe any content on our site is inaccurate or violates intellectual property rights, please <a
                            href="{{ route('contact', ['locale' => app()->getLocale()]) }}">contact us</a> immediately.</p>
                </div>
            </div>
        @endif
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
                font-family: 'Outfit', sans-serif;
                font-size: 2.5rem;
                color: #ef4444;
                /* Alert color */
                margin-bottom: 1rem;
            }

            .subtitle {
                color: var(--text-soft);
                font-size: 1.1rem;
            }

            .disclaimer-hero {
                background: rgba(245, 158, 11, 0.1);
                border-inline-start: 6px solid #f59e0b;
                padding: 2rem;
                margin-bottom: 3rem;
                border-radius: 0 20px 20px 0;
                font-size: 1.25rem;
                font-weight: 600;
                color: #92400e;
            }

            .page-content h2 {
                font-family: var(--font-display);
                font-size: 1.75rem;
                color: var(--text);
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
                border-top: 1px solid var(--border-soft);
                text-align: center;
                font-style: italic;
            }

            .disclaimer-footer a {
                color: var(--accent-strong);
                text-decoration: underline;
            }

            [dir='rtl'] .disclaimer-hero {
                border-radius: 20px 0 0 20px;
            }
        </style>
    @endpush
@endsection
