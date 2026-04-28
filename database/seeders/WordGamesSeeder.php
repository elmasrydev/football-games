<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Game;
use App\Models\AnagramChallenge;
use App\Models\AnagramHint;
use App\Models\VowelVoidChallenge;
use App\Models\VowelVoidHint;
use App\Models\MissingLinkChallenge;
use App\Models\MissingLinkHint;
use App\Models\FootballGlossaryChallenge;
use App\Models\FootballGlossaryHint;
use App\Models\TransferChainChallenge;
use App\Models\TransferChainHint;
use Illuminate\Database\Seeder;

class WordGamesSeeder extends Seeder
{
    public function run(): void
    {
        $football = Category::where('slug', 'football')->first();
        
        if (!$football) {
            $this->command->error('Football category not found! Run CategorySeeder first.');
            return;
        }

        // 1. Anagram Arena
        $anagramGame = Game::updateOrCreate(
            ['slug' => 'anagram-arena'],
            [
                'title' => 'Anagram Arena',
                'name_ar' => 'ساحة الأحرف',
                'description' => 'Unscramble the letters to find the football legend!',
                'category_id' => $football->id,
                'image' => 'games/anagram-arena.png',
                'is_active' => true,
            ]
        );

        $this->seedAnagrams($anagramGame);

        // 2. Vowel Void
        $vowelVoidGame = Game::updateOrCreate(
            ['slug' => 'vowel-void'],
            [
                'title' => 'Vowel Void',
                'name_ar' => 'فراغ الحروف',
                'description' => 'Can you guess the name with only consonants shown?',
                'category_id' => $football->id,
                'image' => 'games/vowel-void.png',
                'is_active' => true,
            ]
        );

        $this->seedVowelVoids($vowelVoidGame);

        // 3. Missing Link
        $missingLinkGame = Game::updateOrCreate(
            ['slug' => 'missing-link'],
            [
                'title' => 'Missing Link',
                'name_ar' => 'الحلقة المفقودة',
                'description' => 'Find the word that connects two football terms!',
                'category_id' => $football->id,
                'image' => 'games/missing-link.png',
                'is_active' => true,
            ]
        );

        $this->seedMissingLinks($missingLinkGame);

        // 4. Football Glossary
        $glossaryGame = Game::updateOrCreate(
            ['slug' => 'football-glossary'],
            [
                'title' => 'Football Glossary',
                'name_ar' => 'قاموس كرة القدم',
                'description' => 'Test your knowledge of football terminology!',
                'category_id' => $football->id,
                'image' => 'games/football-glossary.png',
                'is_active' => true,
            ]
        );

        $this->seedGlossary($glossaryGame);

        // 5. Transfer Chain
        $transferGame = Game::updateOrCreate(
            ['slug' => 'transfer-chain'],
            [
                'title' => 'Transfer Chain',
                'name_ar' => 'سلسلة الانتقالات',
                'description' => 'Find a player who played for both clubs!',
                'category_id' => $football->id,
                'image' => 'games/transfer-chain.png',
                'is_active' => true,
            ]
        );

        $this->seedTransferChains($transferGame);

        $this->command->info('✅ Seeded 5 word games with 10 levels each!');
    }

    private function seedAnagrams($game)
    {
        $levels = [
            ['scrambled' => 'OLADNOR', 'answer' => 'Cristiano Ronaldo', 'diff' => 'easy', 'hints' => ['Brazilian and Portuguese legends share this name', 'He won the Ballon d\'Or multiple times']],
            ['scrambled' => 'SSIME', 'answer' => 'Lionel Messi', 'diff' => 'easy', 'hints' => ['The GOAT from Argentina', 'Legendary Barcelona #10']],
            ['scrambled' => 'RAAYNME', 'answer' => 'Neymar Jr', 'diff' => 'easy', 'hints' => ['Brazilian trickster', 'Played for Santos, Barca, and PSG']],
            ['scrambled' => 'KHAARZD', 'answer' => 'HAZARD', 'diff' => 'medium', 'hints' => ['Belgian star', 'Chelsea and Real Madrid winger']],
            ['scrambled' => 'LBPMHAAE', 'answer' => 'MBAPPE', 'diff' => 'medium', 'hints' => ['French speedster', 'World Cup winner 2018']],
            ['scrambled' => 'ENIZDA', 'answer' => 'ZIDANE', 'diff' => 'medium', 'hints' => ['French midfield maestro', 'Iconic headbutt in 2006']],
            ['scrambled' => 'REKBNCUAE', 'answer' => 'BECKENBAUER', 'diff' => 'hard', 'hints' => ['Der Kaiser', 'German legend who won WC as player and manager']],
            ['scrambled' => 'ERRUOEPDMA', 'answer' => 'MARADONA', 'diff' => 'hard', 'hints' => ['Hand of God', 'Napoli\'s greatest ever']],
            ['scrambled' => 'IVAH', 'answer' => 'XAVI', 'diff' => 'medium', 'hints' => ['Barcelona midfield brain', 'Tiki-taka master']],
            ['scrambled' => 'LEADNI', 'answer' => 'DANILO', 'diff' => 'medium', 'hints' => ['Brazilian defender', 'Played for Porto, Real Madrid, City, and Juve']],
            ['scrambled' => 'SSIME', 'answer' => 'Lionel Messi', 'diff' => 'easy', 'hints' => ['The GOAT from Argentina', 'Legendary Barcelona #10']],
            ['scrambled' => 'OLADNOR', 'answer' => 'Cristiano Ronaldo', 'diff' => 'easy', 'hints' => ['Brazilian and Portuguese legends share this name', 'He won the Ballon d\'Or multiple times']],
            ['scrambled' => 'RAAYNME', 'answer' => 'Neymar Jr', 'diff' => 'easy', 'hints' => ['Brazilian trickster', 'Played for Santos, Barca, and PSG']],
        ];

        foreach ($levels as $l) {
            $c = AnagramChallenge::create([
                'game_id' => $game->id,
                'scrambled_word' => $l['scrambled'],
                'answer' => $l['answer'],
                'difficulty' => $l['diff'],
            ]);
            foreach ($l['hints'] as $idx => $content) {
                AnagramHint::create(['anagram_challenge_id' => $c->id, 'content' => $content, 'sort_order' => $idx]);
            }
        }
    }

    private function seedVowelVoids($game)
    {
        $levels = [
            ['answer' => 'RONALDO', 'cat' => 'player', 'diff' => 'easy', 'hints' => ['CR7', 'All-time top scorer']],
            ['answer' => 'BARCELONA', 'cat' => 'team', 'diff' => 'easy', 'hints' => ['Camp Nou home', 'Blaugrana']],
            ['answer' => 'PENALTY', 'cat' => 'term', 'diff' => 'easy', 'hints' => ['Kick from 12 yards', 'Given for fouls in the box']],
            ['answer' => 'WEMBLEY', 'cat' => 'stadium', 'diff' => 'medium', 'hints' => ['English national stadium', 'Under the arch']],
            ['answer' => 'HAALAND', 'cat' => 'player', 'diff' => 'medium', 'hints' => ['Man City goal machine', 'The Robot from Norway']],
            ['answer' => 'OFFSIDE', 'cat' => 'term', 'diff' => 'medium', 'hints' => ['Beyond the last defender', 'VAR constant check']],
            ['answer' => 'GUARDIOLA', 'cat' => 'player', 'diff' => 'hard', 'hints' => ['Pep', 'Manager of 2023 treble winners']],
            ['answer' => 'ANFIELD', 'cat' => 'stadium', 'diff' => 'hard', 'hints' => ['You\'ll Never Walk Alone', 'Liverpool home']],
            ['answer' => 'BERNABEU', 'cat' => 'stadium', 'diff' => 'hard', 'hints' => ['Real Madrid fortress', 'Located in Madrid central']],
            ['answer' => 'DORTMUND', 'cat' => 'team', 'diff' => 'medium', 'hints' => ['Yellow Wall', 'BVB']],
        ];

        foreach ($levels as $l) {
            $c = VowelVoidChallenge::create([
                'game_id' => $game->id,
                'answer' => $l['answer'],
                'category' => $l['cat'],
                'difficulty' => $l['diff'],
            ]);
            foreach ($l['hints'] as $idx => $content) {
                VowelVoidHint::create(['vowel_void_challenge_id' => $c->id, 'content' => $content, 'sort_order' => $idx]);
            }
        }
    }

    private function seedMissingLinks($game)
    {
        $levels = [
            ['part_a' => 'CHAMPIONS', 'part_b' => 'FINAL', 'answer' => 'LEAGUE', 'diff' => 'easy', 'hints' => ['The big eared trophy competition', 'European elite']],
            ['part_a' => 'FREE', 'part_b' => 'STICK', 'answer' => 'KICK', 'diff' => 'easy', 'hints' => ['Awarded for a foul', 'Direct or Indirect']],
            ['part_a' => 'CORNER', 'part_b' => 'POST', 'answer' => 'FLAG', 'diff' => 'easy', 'hints' => ['Placed at the 4 corners', 'Used to signal corners/offsides']],
            ['part_a' => 'PENALTY', 'part_b' => 'OUT', 'answer' => 'SHOOT', 'diff' => 'medium', 'hints' => ['How draws are decided in knockouts', 'A series of kicks']],
            ['part_a' => 'GOAL', 'part_b' => 'ER', 'answer' => 'KEEP', 'diff' => 'medium', 'hints' => ['Can use hands', 'Stay between the posts']],
            ['part_a' => 'RED', 'part_b' => 'ROOM', 'answer' => 'CARD', 'diff' => 'medium', 'hints' => ['Sent off the pitch', 'Washed out of the game']],
            ['part_a' => 'HALF', 'part_b' => 'OUT', 'answer' => 'TIME', 'diff' => 'medium', 'hints' => ['Rest period', '45 minutes mark']],
            ['part_a' => 'EXTRA', 'part_b' => 'CLOCK', 'answer' => 'TIME', 'diff' => 'hard', 'hints' => ['Added 30 minutes', 'Played if it\'s a draw']],
            ['part_a' => 'INJURY', 'part_b' => 'ADDED', 'answer' => 'TIME', 'diff' => 'hard', 'hints' => ['Board shows these minutes', 'Stoppage period']],
            ['part_a' => 'CENTRE', 'part_b' => 'LINE', 'answer' => 'HALF', 'diff' => 'hard', 'hints' => ['Old school defensive position', 'Middle man']],
        ];

        foreach ($levels as $l) {
            $c = MissingLinkChallenge::create([
                'game_id' => $game->id,
                'part_a' => $l['part_a'],
                'part_b' => $l['part_b'],
                'answer' => $l['answer'],
                'difficulty' => $l['diff'],
            ]);
            foreach ($l['hints'] as $idx => $content) {
                MissingLinkHint::create(['missing_link_challenge_id' => $c->id, 'content' => $content, 'sort_order' => $idx]);
            }
        }
    }

    private function seedGlossary($game)
    {
        $levels = [
            ['clue' => 'When a player scores three goals in one match', 'answer' => 'HAT TRICK', 'diff' => 'easy', 'hints' => ['3 in a row', 'Take the ball home']],
            ['clue' => 'The area where the goalkeeper can handle the ball', 'answer' => 'PENALTY BOX', 'diff' => 'easy', 'hints' => ['18-yard box', 'The forbidden hand zone']],
            ['clue' => 'When a player is between the last defender and the goal', 'answer' => 'OFFSIDE', 'diff' => 'easy', 'hints' => ['Linesman raises the flag', 'Goal disallowed']],
            ['clue' => 'A pass that directly leads to a goal', 'answer' => 'ASSIST', 'diff' => 'easy', 'hints' => ['Helping hand', 'Playmaker\'s metric']],
            ['clue' => 'When a match ends with no winner', 'answer' => 'DRAW', 'diff' => 'medium', 'hints' => ['Tied score', 'Split the points']],
            ['clue' => 'The curved path a ball takes when kicked on the side', 'answer' => 'SWERVE', 'diff' => 'medium', 'hints' => ['Bend it like Beckham', 'Outside of the boot trait']],
            ['clue' => 'A defensive strategy where players mark zones, not opponents', 'answer' => 'ZONAL MARKING', 'diff' => 'hard', 'hints' => ['Area defense', 'Alternative to Man-to-Man']],
            ['clue' => 'When a team lets the opposition have the ball intentionally to pounce', 'answer' => 'PRESSING TRAP', 'diff' => 'hard', 'hints' => ['Tactical ambush', 'High intensity turnover']],
            ['clue' => 'The imaginary line across which a player is considered offside', 'answer' => 'OFFSIDE LINE', 'diff' => 'medium', 'hints' => ['Defenders hold this', 'VAR draws this']],
            ['clue' => 'A quick one-two pass between two players', 'answer' => 'WALL PASS', 'diff' => 'hard', 'hints' => ['Give and Go', 'Bypass the defender quickly']],
        ];

        foreach ($levels as $l) {
            $c = FootballGlossaryChallenge::create([
                'game_id' => $game->id,
                'clue' => $l['clue'],
                'answer' => $l['answer'],
                'difficulty' => $l['diff'],
            ]);
            foreach ($l['hints'] as $idx => $content) {
                FootballGlossaryHint::create(['football_glossary_challenge_id' => $c->id, 'content' => $content, 'sort_order' => $idx]);
            }
        }
    }

    private function seedTransferChains($game)
    {
        $levels = [
            ['club_a' => 'Barcelona', 'club_b' => 'PSG', 'answers' => ['Messi', 'Neymar', 'Ronaldinho', 'Dani Alves'], 'diff' => 'easy', 'hints' => ['Legendary Brazilian #10', 'Most goals for Argentina']],
            ['club_a' => 'Man United', 'club_b' => 'Real Madrid', 'answers' => ['Ronaldo', 'Beckham', 'Van Nistelrooy', 'Casemiro'], 'diff' => 'easy', 'hints' => ['CR7', 'Free kick specialist #7']],
            ['club_a' => 'Liverpool', 'club_b' => 'Barcelona', 'answers' => ['Luis Suarez', 'Suarez', 'Philippe Coutinho', 'Coutinho', 'Javier Mascherano', 'Mascherano'], 'diff' => 'easy', 'hints' => ['Uruguayan striker', 'Little Magician']],
            ['club_a' => 'Chelsea', 'club_b' => 'Real Madrid', 'answers' => ['Eden Hazard', 'Hazard', 'Thibaut Courtois', 'Courtois', 'Antonio Rudiger', 'Rudiger', 'Mateo Kovacic', 'Kovacic'], 'diff' => 'medium', 'hints' => ['Belgian winger', 'French-born German CB']],
            ['club_a' => 'Arsenal', 'club_b' => 'Barcelona', 'answers' => ['Henry', 'Fabregas', 'Overmars', 'Aubameyang'], 'diff' => 'medium', 'hints' => ['The King of Highbury', 'Cesc']],
            ['club_a' => 'Bayern Munich', 'club_b' => 'Real Madrid', 'answers' => ['Kroos', 'Alaba', 'James Rodriguez', 'Robben'], 'diff' => 'medium', 'hints' => ['German sniper', 'Austrian utility man']],
            ['club_a' => 'Juventus', 'club_b' => 'Real Madrid', 'answers' => ['Ronaldo', 'Zidane', 'Cannavaro', 'Higuain'], 'diff' => 'medium', 'hints' => ['French midfied legend', 'Winner of WC 98 and Euro 2000']],
            ['club_a' => 'AC Milan', 'club_b' => 'PSG', 'answers' => ['Ibrahimovic', 'Thiago Silva', 'Beckham', 'Ronaldinho', 'Donnarumma'], 'diff' => 'hard', 'hints' => ['Zlatan', 'Brazilian CB captain']],
            ['club_a' => 'Inter Milan', 'club_b' => 'Chelsea', 'answers' => ['Lukaku', 'Crespo', 'Eto\'o', 'Kovacic'], 'diff' => 'hard', 'hints' => ['Belgian striker', 'Came back for 100m+']],
            ['club_a' => 'Tottenham', 'club_b' => 'Real Madrid', 'answers' => ['Bale', 'Modric', 'Van der Vaart'], 'diff' => 'hard', 'hints' => ['Welsh wizard', 'Croatian genius']],
        ];

        foreach ($levels as $l) {
            $c = TransferChainChallenge::create([
                'game_id' => $game->id,
                'club_a' => $l['club_a'],
                'club_b' => $l['club_b'],
                'answers' => $l['answers'],
                'difficulty' => $l['diff'],
            ]);
            foreach ($l['hints'] as $idx => $content) {
                TransferChainHint::create(['transfer_chain_challenge_id' => $c->id, 'content' => $content, 'sort_order' => $idx]);
            }
        }
    }
}
