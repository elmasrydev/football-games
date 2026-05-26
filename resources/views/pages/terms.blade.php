@extends('layouts.app')

@section('content')
    <div class="container static-page">
        @if(app()->getLocale() === 'ar')
            <div class="page-header">
                <h1>شروط الخدمة</h1>
                <p class="subtitle">تاريخ النفاذ: فبراير 2026</p>
            </div>

            <div class="page-content">
                <section>
                    <h2>1. قبول الشروط</h2>
                    <p>من خلال الدخول إلى منصة جيمزيانو أو استخدامها، فإنك توافق على الالتزام بشروط الخدمة هذه. وإذا كنت لا توافق عليها، يرجى التوقف عن استخدام الموقع.</p>
                </section>

                <section>
                    <h2>2. رخصة الاستخدام</h2>
                    <p>نحن نمنحك رخصة شخصية، غير حصرية، وغير قابلة للنقل للعب ألعابنا لأغراض الترفيه والتسلية فقط. ولا يجوز لك:</p>
                    <ul>
                        <li>سحب أو استخراج البيانات من موقعنا للاستخدام التجاري.</li>
                        <li>محاولة تخطي أي تدابير حماية تقنية أو آليات اللعب.</li>
                        <li>إعادة توزيع أصول لعبتنا المخصصة دون موافقة خطية مسبقة.</li>
                    </ul>
                </section>

                <section>
                    <h2>3. الملكية الفكرية</h2>
                    <p>إن العلامة التجارية "جيمزيانو" والأكواد البرمجية المخصصة ومنطق الألعاب والأصول البصرية المملوكة لنا هي ملك فكري لمنصة جيمزيانو. قد يتم استخدام وسائط الطرف الثالث أو المواد المرجعية لأغراض اللعب أو التعليم أو التعليق عند الاقتضاء.</p>
                </section>

                <section>
                    <h2>4. حدود المسؤولية</h2>
                    <p>يتم تقديم منصة جيمزيانو "كما هي". نحن لا نضمن أن يكون الموقع متاحاً دائماً أو خالياً من الأخطاء. ولسنا مسؤولين عن أي أضرار تنشأ عن استخدامك للموقع.</p>
                </section>

                <section>
                    <h2>5. إنهاء الخدمة</h2>
                    <p>نحتفظ بالحق في إنهاء أو تعليق الوصول إلى خدماتنا في أي وقت ودون إشعار مسبق، وذلك لأي سلوك نعتقد أنه ينتهك هذه الشروط.</p>
                </section>

                <section>
                    <h2>6. القانون الحاكم</h2>
                    <p>تخضع هذه الشروط وتُفسر وفقاً للقوانين المعمول بها في الولاية القضائية التي نعمل بها، دون النظر إلى تعارضها مع أحكام القانون.</p>
                </section>
            </div>
        @else
            <div class="page-header">
                <h1>Terms of Service</h1>
                <p class="subtitle">Effective Date: February 2026</p>
            </div>

            <div class="page-content">
                <section>
                    <h2>1. Acceptance of Terms</h2>
                    <p>By accessing or using Games Hub, you agree to be bound by these Terms of Service. If you do not
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
                    <p>The "Games Hub" brand, our custom code, game logic, and proprietary visual assets are the
                        intellectual property of Games Hub. Third-party media or reference materials may be used for
                        gameplay, educational, or commentary purposes where appropriate.</p>
                </section>

                <section>
                    <h2>4. Limitation of Liability</h2>
                    <p>Games Hub is provided "as is." We do not guarantee that the site will always be available or
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
                font-family: var(--font-display);
                font-size: 2.25rem;
                color: var(--text);
                margin-bottom: 0.5rem;
            }

            .subtitle {
                color: var(--text-soft);
                font-size: 0.9rem;
            }

            .page-content section {
                margin-bottom: 2rem;
            }

            .page-content h2 {
                font-family: var(--font-display);
                font-size: 1.25rem;
                color: var(--text);
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
