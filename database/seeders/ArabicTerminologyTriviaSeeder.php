<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Challenge;
use App\Models\ChallengeHint;
use App\Models\GameItem;
use Illuminate\Database\Seeder;

class ArabicTerminologyTriviaSeeder extends Seeder
{
    public function run(): void
    {
        $game = Game::where('slug', 'terminology-trivia')->first();
        if (!$game) return;

        $football = Genre::where('slug', 'football')->first();
        $actors = Genre::where('slug', 'actors')->first();
        $movies = Genre::where('slug', 'movies')->first();

        // 1. Egyptian Football Terms (AR)
        $footballTerms = [
            [
                'term' => 'محمود الخطيب',
                'description' => 'أسطورة النادي الأهلي ورئيسه الحالي، يلقب بـ "بيبو" وهو أول مصري يحصل على الكرة الذهبية الأفريقية.',
                'hints' => ['بيبو بيبو الله يا خطيب', 'رئيس النادي الأهلي', 'صاحب مهارات خرافية في السبعينات والثمانينات']
            ],
            [
                'term' => 'محمد أبوتريكة',
                'description' => 'نجم الكرة المصرية والنادي الأهلي الملقب بـ "الماجيكو" و "أمير القلوب"، قاد مصر للفوز بأمم أفريقيا 2006 و 2008.',
                'hints' => ['يا يا يا يا تريكة', 'الماجيكو', 'صاحب هدف الفوز في نهائي 2008']
            ],
            [
                'term' => 'نادي القرن',
                'description' => 'اللقب الرسمي الذي منحه الاتحاد الأفريقي للنادي الأهلي المصري كأفضل نادي في أفريقيا في القرن العشرين.',
                'hints' => ['الأهلي المصري', 'لقب قاري شهير', 'يتفاخر به جماهير الأحمر']
            ],
            [
                'term' => 'ديربي القاهرة',
                'description' => 'المباراة التاريخية التي تجمع بين قطبي الكرة المصرية الأهلي والزمالك، وتعتبر من أقوى الديربيات في العالم.',
                'hints' => ['الأهلي ضد الزمالك', 'قمة الكرة المصرية', 'تتوقف عندها أنفاس الجماهير في مصر']
            ],
            [
                'term' => 'عصام الحضري',
                'description' => 'حارس مرمى مصري أسطوري يلقب بـ "السد العالي"، وهو أكبر لاعب شارك في تاريخ كأس العالم.',
                'hints' => ['السد العالي', 'رقص فوق العارضة', 'صد ركلات ترجيح تاريخية في أمم أفريقيا']
            ],
            [
                'term' => 'صلاح الدين',
                'description' => 'اللقب الذي تطلقه الجماهير المصرية على النجم محمد صلاح "فخر العرب" وهداف ليفربول التاريخي.',
                'hints' => ['الملك المصري', 'أبو مكة', 'هداف الدوري الإنجليزي']
            ],
        ];

        // 2. Egyptian Actors (AR)
        $actorTerms = [
            [
                'term' => 'عادل إمام',
                'description' => 'أحد أبرز الممثلين في تاريخ السينما والمسرح العربي، يلقب بـ "الزعيم" وصاحب أطول مسيرة فنية ناجحة.',
                'hints' => ['الزعيم', 'مدرسة المشاغبين', 'شاهد ماشفش حاجة']
            ],
            [
                'term' => 'أحمد زكي',
                'description' => 'ممثل مصري عبقري يلقب بـ "إمبراطور السينما"، برع في تقمص الشخصيات التاريخية مثل السادات وناصر.',
                'hints' => ['النمر الأسود', 'الإمبراطور', 'الهروب']
            ],
            [
                'term' => 'سعاد حسني',
                'description' => 'فنانة مصرية شاملة لقبت بـ "سندريلا الشاشة العربية"، وتعتبر من أهم الممثلات في تاريخ السينما المصرية.',
                'hints' => ['السندريلا', 'خلي بالك من زوزو', 'صغيرة على الحب']
            ],
            [
                'term' => 'فؤاد المهندس',
                'description' => 'عملاق الكوميديا والمسرح المصري، اشتهر بلقب "الأستاذ" وقدم ثنائياً ناجحاً مع زوجته شويكار.',
                'hints' => ['الأستاذ', 'سك على بناتك', 'كلمتين وبس']
            ],
            [
                'term' => 'إسماعيل يس',
                'description' => 'نجم الكوميديا الأول في الخمسينات، تميز بـ "بققه" الواسع وقدم سلسلة أفلام شهيرة تحمل اسمه.',
                'hints' => ['أبو ضحكة جنان', 'في الجيش.. في الأسطول', 'صاحب أشهر فم في السينما']
            ],
        ];

        // 3. Egyptian Movies (AR)
        $movieTerms = [
            [
                'term' => 'الكيت كات',
                'description' => 'فيلم مصري عبقري من بطولة محمود عبد العزيز، يجسد فيه شخصية "الشيخ حسني" الكفيف الذي يرفض الاعتراف بعجزه.',
                'hints' => ['الشيخ حسني', 'داوود عبد السيد', 'حي إمبابة']
            ],
            [
                'term' => 'ولاد رزق',
                'description' => 'سلسلة أفلام أكشن مصرية ناجحة تتناول قصة 4 أشقاء يحترفون الإجرام ولكن يربطهم عهد "رضا".',
                'hints' => ['أسود الأرض', 'أحمد عز وعمرو يوسف', 'عين صيرة']
            ],
            [
                'term' => 'الإرهاب والكباب',
                'description' => 'فيلم كوميدي سياسي من بطولة عادل إمام، تدور أحداثه حول موظف يجد نفسه متورطاً في احتجاز رهائن بمجمع التحرير.',
                'hints' => ['مجمع التحرير', 'عادل إمام ويسرا', 'العدالة الناجزة']
            ],
            [
                'term' => 'الفيل الأزرق',
                'description' => 'فيلم تشويق ورعب نفسي مأخوذ عن رواية لأحمد مراد، يتناول قصة الطبيب النفسي يحيى راشد وحبوب "الفيل الأزرق".',
                'hints' => ['يحيى راشد', 'كريم عبد العزيز', 'خالد الصاوي "نايل"']
            ],
        ];

        Challenge::where('game_id', $game->id)->where('language', 'ar')->delete();

        $this->seedGenre($game, $football, $footballTerms, 'ar');
        $this->seedGenre($game, $actors, $actorTerms, 'ar');
        $this->seedGenre($game, $movies, $movieTerms, 'ar');
    }

    private function seedGenre($game, $genre, $terms, $lang)
    {
        foreach ($terms as $item) {
            $term = $item['term'];
            $description = $item['description'];
            $hints = $item['hints'];

            // Register in GameItem for Autocomplete
            GameItem::updateOrCreate(
                ['type' => 'term', 'name_ar' => $term],
                ['is_active' => true]
            );

            $challenge = Challenge::create([
                'game_id' => $game->id,
                'genre_id' => $genre->id,
                'language' => $lang,
                'difficulty' => 'medium',
                'stimulus_type' => 'text',
                'stimulus_data' => [
                    'question' => $description,
                ],
                'answer' => $term,
                'answer_type' => 'term',
                'autocomplete_type' => 'term',
            ]);

            foreach ($hints as $hintContent) {
                ChallengeHint::create([
                    'challenge_id' => $challenge->id,
                    'content' => $hintContent,
                ]);
            }
        }
    }
}
