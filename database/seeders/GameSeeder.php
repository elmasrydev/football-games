<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $football = Genre::where('slug', 'football')->first();

        $games = [
            [
                'title' => 'Silhouette Identity',
                'name_ar' => 'هوية الظل',
                'slug' => 'guess-silhouette',
                'description' => 'Identify the person from their shadow silhouette.',
                'description_ar' => 'تعرف على الشخص من خلال ظله فقط.',
                'how_to_play' => "1. Look at the silhouette carefully.\n2. Type the name in the answer box.\n3. Use hints if you get stuck!",
                'how_to_play_ar' => "1. انظر إلى الظل بعناية.\n2. اكتب الاسم في مربع الإجابة.\n3. استخدم التلميحات إذا تعثرت!",
                'game_type' => 'image_guess',
                'answer_type' => 'player',
                'image_file' => 'guess-silhouette.png'
            ],
            [
                'title' => 'Scrambled Letters',
                'name_ar' => 'الحروف المبعثرة',
                'slug' => 'anagram-arena',
                'description' => 'Unscramble the letters to reveal the correct name.',
                'description_ar' => 'قم بإعادة ترتيب الحروف المبعثرة للكشف عن الاسم الصحيح.',
                'how_to_play' => "1. Study the scrambled letters.\n2. Check the word structure placeholders.\n3. Rearrange them to form the correct answer.",
                'how_to_play_ar' => "1. ادرس الحروف المبعثرة.\n2. تحقق من أماكن الحروف في الكلمة.\n3. أعد ترتيبها لتشكيل الإجابة الصحيحة.",
                'game_type' => 'word_puzzle',
                'answer_type' => 'player',
                'image_file' => 'anagram-arena.png'
            ],
            [
                'title' => 'Transfer Journey',
                'name_ar' => 'رحلة الانتقالات',
                'slug' => 'transfer-chain',
                'description' => 'Guess the person by following their career history.',
                'description_ar' => 'خمن الشخص من خلال تتبع مسيرة انتقالاته بين الأندية.',
                'how_to_play' => "1. View the sequence of clubs or teams.\n2. Identify who played for all of them in that order.\n3. Submit the full name.",
                'how_to_play_ar' => "1. عرض تسلسل الأندية أو الفرق.\n2. حدد من لعب لجميع هذه الأندية بهذا الترتيب.\n3. أرسل الاسم بالكامل.",
                'game_type' => 'connection_guess',
                'answer_type' => 'player',
                'image_file' => 'transfer-chain.png'
            ],
            [
                'title' => 'Stadium Master',
                'name_ar' => 'خبير الملاعب',
                'slug' => 'stadium-spotter',
                'description' => 'Name the famous stadium from a professional photo.',
                'description_ar' => 'تعرف على اسم الملعب الشهير من خلال صورته.',
                'how_to_play' => "1. Look at the stadium photo.\n2. Consider the architecture and colors.\n3. Type the official name of the stadium.",
                'how_to_play_ar' => "1. انظر إلى صورة الملعب.\n2. ضع في اعتبارك الهندسة المعمارية والألوان.\n3. اكتب الاسم الرسمي للملعب.",
                'game_type' => 'image_guess',
                'answer_type' => 'stadium',
                'image_file' => 'stadium-spotter.png'
            ],
            [
                'title' => 'Vowel Finder',
                'name_ar' => 'مكتشف الحروف',
                'slug' => 'vowel-void',
                'description' => 'Fill in the missing vowels to complete the name.',
                'description_ar' => 'املأ حروف العلة الناقصة لإكمال الاسم الصحيح.',
                'how_to_play' => "1. Read the consonants provided.\n2. Determine which vowels (A, E, I, O, U) are missing.\n3. Type the complete name.",
                'how_to_play_ar' => "1. اقرأ الحروف الساكنة المتوفرة.\n2. حدد حروف العلة الناقصة (أ، و، ي).\n3. اكتب الاسم الكامل.",
                'game_type' => 'word_puzzle',
                'answer_type' => 'player',
                'image_file' => 'vowel-void.png'
            ],
            [
                'title' => 'Legend Detective',
                'name_ar' => 'محقق الأساطير',
                'slug' => 'kit-detective',
                'description' => 'Identify the team or person from unique details.',
                'description_ar' => 'تعرف على الفريق أو الشخص من خلال تفاصيل فريدة.',
                'how_to_play' => "1. Zoom in on the specific kit details.\n2. Connect the colors and patterns to a team.\n3. Enter the correct identity.",
                'how_to_play_ar' => "1. قم بتكبير تفاصيل الطقم المحددة.\n2. اربط الألوان والأنماط بفريق ما.\n3. أدخل الهوية الصحيحة.",
                'game_type' => 'image_guess',
                'answer_type' => 'player',
                'image_file' => 'kit-detective.png'
            ],
            [
                'title' => 'Vintage Stars',
                'name_ar' => 'نجوم الزمن الجميل',
                'slug' => 'black-and-white',
                'description' => 'Identify the classic legend from a vintage photo.',
                'description_ar' => 'تعرف على أساطير اللعبة من خلال صورهم الكلاسيكية القديمة.',
                'how_to_play' => "1. Study the classic black and white photo.\n2. Think of historical legends from that era.\n3. Provide the correct name.",
                'how_to_play_ar' => "1. ادرس الصورة الكلاسيكية بالأبيض والأسود.\n2. فكر في الأساطير التاريخية من ذلك العصر.\n3. قدم الاسم الصحيح.",
                'game_type' => 'image_guess',
                'answer_type' => 'player',
                'image_file' => 'bw.png'
            ],
            [
                'title' => 'Iconic Moments',
                'name_ar' => 'لحظات أيقونية',
                'slug' => 'highlight-moments',
                'description' => 'Identify the match or person from a famous celebration.',
                'description_ar' => 'تعرف على المباراة أو الشخص من خلال احتفال تاريخي شهير.',
                'how_to_play' => "1. Recognize the famous celebration or moment.\n2. Recall the match or player involved.\n3. Answer correctly to proceed.",
                'how_to_play_ar' => "1. تعرف على الاحتفال أو اللحظة الشهيرة.\n2. تذكر المباراة أو اللاعب المعني.\n3. أجب بشكل صحيح للمتابعة.",
                'game_type' => 'image_guess',
                'answer_type' => 'player',
                'image_file' => 'highlight-moments.png'
            ],
            [
                'title' => 'Trophy Cabinet',
                'name_ar' => 'خزانة البطولات',
                'slug' => 'trophy-hunter',
                'description' => 'Identify the person or team from their trophy record.',
                'description_ar' => 'تعرف على الشخص أو الفريق من خلال سجل بطولاته وإنجازاته.',
                'how_to_play' => "1. Analyze the list of trophies and achievements.\n2. Match the records with a specific person or team.\n3. Type your answer.",
                'how_to_play_ar' => "1. تحليل قائمة البطولات والإنجازات.\n2. طابق السجلات مع شخص أو فريق معين.\n3. اكتب إجابتك.",
                'game_type' => 'image_guess',
                'answer_type' => 'player',
                'image_file' => 'trophy-hunter.png'
            ],
            [
                'title' => 'Word Master',
                'name_ar' => 'خبير الكلمات',
                'slug' => 'terminology-trivia',
                'description' => 'Guess the word based on its definition or description.',
                'description_ar' => 'خمن الكلمة بناءً على تعريفها أو وصفها.',
                'how_to_play' => "1. Read the provided definition carefully.\n2. Think of the term that fits the description.\n3. Submit your guess.",
                'how_to_play_ar' => "1. اقرأ التعريف المقدم بعناية.\n2. فكر في المصطلح الذي يناسب الوصف.\n3. أرسل تخمينك.",
                'game_type' => 'word_puzzle',
                'answer_type' => 'term',
                'image_file' => 'terminology-trivia.png'
            ],
            [
                'title' => 'The Bridge',
                'name_ar' => 'الجسر',
                'slug' => 'missing-link',
                'description' => 'Find the word that connects several terms.',
                'description_ar' => 'اعثر على الكلمة التي تربط بين عدة مصطلحات.',
                'how_to_play' => "1. Look at the group of words.\n2. Find the one word that links them all together.\n3. Type the connecting link.",
                'how_to_play_ar' => "1. انظر إلى مجموعة الكلمات.\n2. ابحث عن الكلمة الوحيدة التي تربطهم جميعاً ببعضهم البعض.\n3. اكتب رابط الاتصال.",
                'game_type' => 'word_puzzle',
                'answer_type' => 'term',
                'image_file' => 'missing-link.png'
            ],
            [
                'title' => 'Career Tracker',
                'name_ar' => 'متتبع المسيرة',
                'slug' => 'career',
                'description' => 'Identify the person by their full career path.',
                'description_ar' => 'تعرف على الشخص من خلال مسيرة حياته المهنية الكاملة.',
                'how_to_play' => "1. Review the chronological list of teams.\n2. Identify the person who followed this path.\n3. Enter the name.",
                'how_to_play_ar' => "1. مراجعة القائمة الزمنية للفرق.\n2. تحديد الشخص الذي اتبع هذا المسار.\n3. أدخل الاسم.",
                'game_type' => 'connection_guess',
                'answer_type' => 'player',
                'image_file' => 'career-path.png'
            ],
            [
                'title' => 'Group Finder',
                'name_ar' => 'مكتشف المجموعة',
                'slug' => 'group-players',
                'description' => 'Identify common links in a group of people.',
                'description_ar' => 'تحديد الروابط المشتركة في مجموعة من الأشخاص.',
                'how_to_play' => "1. Look at the names or images in the group.\n2. Find what they all have in common.\n3. Type the common link or relationship.",
                'how_to_play_ar' => "1. انظر إلى الأسماء أو الصور في المجموعة.\n2. ابحث عما يشتركون فيه جميعاً.\n3. اكتب الرابط أو العلاقة المشتركة.",
                'game_type' => 'connection_guess',
                'answer_type' => 'player',
                'image_file' => 'group_guess_cover.png'
            ],
            [
                'title' => 'Category Crusher',
                'name_ar' => 'خبير الفئات',
                'slug' => 'category-crusher',
                'description' => 'Find the common category for a set of items.',
                'description_ar' => 'ابحث عن الفئة المشتركة لمجموعة من العناصر.',
                'how_to_play' => "1. Look at the 4 items provided.\n2. Think of the category or group they all belong to.\n3. Type the category name.",
                'how_to_play_ar' => "1. انظر إلى العناصر الأربعة المقدمة.\n2. فكر في الفئة أو المجموعة التي ينتمون إليها جميعاً.\n3. اكتب اسم الفئة.",
                'game_type' => 'word_puzzle',
                'answer_type' => 'term',
                'image_file' => 'category-crusher.png'
            ],
            [
                'title' => 'Mazad',
                'name_ar' => 'مزاد',
                'slug' => 'mazad',
                'description' => 'Compete in real-time speed trivia! Answer as many correct answers as possible before time runs out.',
                'description_ar' => 'تنافس في الوقت الفعلي في لعبة سرعة المعلومات! اكتب أكبر عدد من الإجابات الصحيحة قبل انتهاء الوقت.',
                'how_to_play' => "1. Create or join a public or private room.\n2. Wait for players to join.\n3. Type as many correct answers as you can for each question before the timer ends!",
                'how_to_play_ar' => "1. أنشئ أو انضم إلى غرفة عامة أو خاصة.\n2. انتظر انضمام اللاعبين الآخرين.\n3. اكتب أكبر عدد ممكن من الإجابات الصحيحة لكل سؤال قبل انتهاء المؤقت!",
                'game_type' => 'multiplayer',
                'answer_type' => 'term',
                'image_file' => 'mazad.png'
            ],
        ];

        $allGenres = \App\Models\Genre::all();

        foreach ($games as $gameData) {
            $imageFile = $gameData['image_file'];
            unset($gameData['image_file']);
            
            $game = Game::updateOrCreate(
                ['slug' => $gameData['slug']], 
                $gameData
            );

            // Sync all genres for now as requested
            $game->genres()->sync($allGenres->pluck('id'));

            $sourcePath = storage_path('app/seeds/games/' . $imageFile);
            
            if (file_exists($sourcePath)) {
                $this->command->info("Seeding image for game: {$game->slug} from {$sourcePath}");
                $game->clearMediaCollection('cover');
                $game->addMedia($sourcePath)
                     ->preservingOriginal()
                     ->toMediaCollection('cover');
                
                $game->update(['image' => 'games/' . $imageFile]);
            } else {
                $this->command->warn("Image not found for game: {$game->slug} at path: {$sourcePath}");
            }
        }
    }
}
