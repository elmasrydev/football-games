@extends('layouts.app')

@section('content')
    <div class="container static-page mt-20">
        @if(app()->getLocale() === 'ar')
            <div class="page-header">
                <h1 class="text-4xl font-display font-black uppercase tracking-tight">عن جيمزيانو</h1>
                <p class="subtitle text-on-surface-variant font-medium mt-4">المنصة الرائدة للألعاب التفاعلية والتحديات البصرية.</p>
            </div>

            <div class="page-content space-y-12">
                <section>
                    <h2 class="text-2xl font-display font-black uppercase tracking-tight mb-4">رسالتنا</h2>
                    <p class="text-on-surface-variant leading-relaxed">تأسست منصة جيمزيانو لتجعل ألعاب المعلومات أكثر تفاعلية وبصرية ومتعة. رسالتنا هي تقديم تجارب تحدٍ متقنة ومصقولة تكافئ حب الاستطلاع والذاكرة وقوة الملاحظة للاعبين في جميع أنحاء العالم.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-display font-black uppercase tracking-tight mb-4">التجربة</h2>
                    <p class="text-on-surface-variant leading-relaxed">نحن نؤمن بأن ألعاب الأسئلة والألغاز يجب أن تكون أكثر من مجرد نصوص مكتوبة. لهذا السبب تم تصميم جيمزيانو لتعتمد على التلميحات البصرية، والتدرج، وأنماط التفاعل المتعددة:</p>
                    <ul class="list-disc list-inside space-y-3 text-on-surface-variant ps-4">
                        <li><strong>التخمين البصري:</strong> تعرف على الشخصيات أو الأماكن أو اللحظات التاريخية من الصور المقصوصة والظلال البصرية.</li>
                        <li><strong>ألغاز الكلمات:</strong> حل الأناجرام (إعادة ترتيب الحروف)، أكمل الحروف الناقصة، واكتشف المصطلحات المخفية.</li>
                        <li><strong>تحديات الربط:</strong> تتبع التسلسلات والعلاقات والروابط المشتركة بين الأدلة ومجموعات الأسئلة.</li>
                        <li><strong>التلميحات المتدرجة:</strong> اكشف المساعدة والتلميحات خطوة بخطوة بدلاً من الذهاب مباشرة للإجابة.</li>
                        <li><strong>إعادة اللعب السريع:</strong> تنقل بمرونة وسرعة بين المستويات وعد إلى ألعابك المحفوظة والمفضلة فوراً.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-display font-black uppercase tracking-tight mb-4">مصممة للاعبين</h2>
                    <p class="text-on-surface-variant leading-relaxed">سواء كنت تفضل التحديات الخفيفة أو الألغاز الأكثر صعوبة، فقد تم تصميم جيمزيانو ليدعم مختلف أساليب اللعب. يتم إضافة تحديات ومحتوى جديد أسبوعياً حتى تجد دائماً شيئاً جديداً ومثيراً لتكتشفه.</p>
                </section>
            </div>
        @else
            <div class="page-header">
                <h1 class="text-4xl font-display font-black uppercase tracking-tight">About Gamesiano</h1>
                <p class="subtitle text-on-surface-variant font-medium mt-4">The ultimate hub for interactive games and visual challenges.</p>
            </div>

            <div class="page-content space-y-12">
                <section>
                    <h2 class="text-2xl font-display font-black uppercase tracking-tight mb-4">Our Mission</h2>
                    <p class="text-on-surface-variant leading-relaxed">Gamesiano was built to make knowledge-based games feel more interactive, more visual, and more fun. Our mission is to create polished challenge experiences that reward curiosity, memory, and pattern recognition for players globally.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-display font-black uppercase tracking-tight mb-4">The Experience</h2>
                    <p class="text-on-surface-variant leading-relaxed">We believe trivia and puzzle games should be more than plain text prompts. That is why Gamesiano is designed around visual clues, progression, hints, and multiple styles of interaction:</p>
                    <ul class="list-disc list-inside space-y-3 text-on-surface-variant ps-4">
                        <li><strong>Visual Guessing:</strong> Identify people, places, or moments from cropped images and silhouettes.</li>
                        <li><strong>Word Puzzles:</strong> Solve anagrams, fill in missing letters, and discover hidden terms.</li>
                        <li><strong>Connection Challenges:</strong> Follow sequences, relationships, and grouped clues.</li>
                        <li><strong>Progressive Hints:</strong> Reveal help gradually instead of jumping straight to the answer.</li>
                        <li><strong>Fast Replay:</strong> Move quickly between levels and return to bookmarked favorites.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-display font-black uppercase tracking-tight mb-4">Built for Players</h2>
                    <p class="text-on-surface-variant leading-relaxed">Whether you prefer light challenges or more demanding puzzles, Gamesiano is designed to support a wide range of play styles. New challenges and content are added weekly so there is always something fresh to explore.</p>
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
