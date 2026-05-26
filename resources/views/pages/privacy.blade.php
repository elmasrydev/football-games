@extends('layouts.app')

@section('content')
    <div class="container static-page">
        @if(app()->getLocale() === 'ar')
            <div class="page-header">
                <h1>سياسة الخصوصية</h1>
                <p class="subtitle">آخر تحديث: فبراير 2026</p>
            </div>

            <div class="page-content">
                <section>
                    <h2>1. مقدمة</h2>
                    <p>مرحباً بكم في جيمزيانو. نحن نقدر خصوصيتكم ونلتزم بالشفافية الكاملة بشأن كيفية تعاملنا مع أي معلومات تشاركونها معنا أثناء اللعب.</p>
                </section>

                <section>
                    <h2>2. المعلومات التي نجمعها</h2>
                    <p>تم تصميم منصتنا لتتمكن من اللعب دون الحاجة لإنشاء حساب لمعظم الميزات. نحن لا نجمع معلومات التعريف الشخصية (PII) مثل اسمك أو عنوانك إلا إذا قمت بتقديمها طواعية عبر نماذج الاتصال الخاصة بنا أو ميزات تسجيل الدخول.</p>
                    <p>قد نقوم بجمع بعض المعلومات غير الشخصية مثل:</p>
                    <ul>
                        <li>نوع المتصفح وإصداره</li>
                        <li>إحصائيات وبيانات اللعب المجهولة (مثل نسب الفوز والخسارة)</li>
                        <li>معلومات الجهاز لغرض تحسين أداء اللعبة وتوافقها</li>
                    </ul>
                </section>

                <section>
                    <h2>3. ملفات تعريف الارتباط (Cookies)</h2>
                    <p>نحن نستخدم ملفات تعريف الارتباط الأساسية لحفظ تقدمك في اللعب وتفضيلاتك الشخصية (مثل النمط الداكن أو إعدادات الصوت). هذه الملفات ضرورية لعمل الموقع بشكل صحيح.</p>
                </section>

                <section>
                    <h2>4. خدمات الطرف الثالث</h2>
                    <p>نحن نستخدم خدمات تابعة لأطراف ثالثة مثل موقع YouTube لتقديم محتوى الفيديو. قد تقوم هذه الخدمات بجمع بيانات خاصة بها وفقاً لسياسات الخصوصية التابعة لها.</p>
                </section>

                <section>
                    <h2>5. أمن البيانات</h2>
                    <p>نحن نطبق معايير أمان صناعية قياسية لحماية سلامة موقعنا وأي بيانات نقوم بتخزينها. ومع ذلك، لا يوجد أي إرسال عبر الإنترنت آمن بنسبة 100%.</p>
                </section>

                <section>
                    <h2>6. التغييرات في هذه السياسة</h2>
                    <p>قد نقوم بتحديث هذه السياسة بشكل دوري. أي تغييرات سيتم نشرها على هذه الصفحة مع تحديث تاريخ "آخر تحديث" في الأعلى.</p>
                </section>
            </div>
        @else
            <div class="page-header">
                <h1>Privacy Policy</h1>
                <p class="subtitle">Last Updated: February 2026</p>
            </div>

            <div class="page-content">
                <section>
                    <h2>1. Introduction</h2>
                    <p>Welcome to Games Hub. We value your privacy and are committed to being transparent about how we
                        handle any information you share with us while playing our games.</p>
                </section>

                <section>
                    <h2>2. Information We Collect</h2>
                    <p>Games Hub is designed to be played without requiring an account for most features. We do not
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
                border-inline-start: 4px solid var(--accent);
                padding-inline-start: 1rem;
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
