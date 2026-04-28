<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Challenge;
use App\Models\ChallengeHint;
use Illuminate\Database\Seeder;

class SilhouetteSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure Genres exist
        $football = Genre::firstOrCreate(['slug' => 'football'], [
            'name_en' => 'Football', 'name_ar' => 'كرة القدم', 'icon' => '⚽', 'is_active' => true,
        ]);

        $actors = Genre::firstOrCreate(['slug' => 'actors'], [
            'name_en' => 'Actors', 'name_ar' => 'ممثلين', 'icon' => '🎭', 'is_active' => true,
        ]);

        // 2. Ensure Game exists
        $game = Game::firstOrCreate(['slug' => 'guess-silhouette'], [
            'title' => 'Guess the Silhouette',
            'name_ar' => 'خمن الظل',
            'description' => 'The pose, the stride, the legend. Can you identify the football superstar from just their shadow?',
            'image' => 'games/guess-silhouette.png',
            'game_type' => 'image_guess',
            'answer_type' => 'player',
            'is_active' => true,
        ]);

        // 3. Remove ALL existing challenges for this game to start fresh
        Challenge::where('game_id', $game->id)->delete();

        // 4. Football Challenges (12 levels)
        $footballData = [
            [
                'answer' => 'Mohamed Salah',
                'image' => 'silhouettes/salah.png',
                'reveal' => 'silhouettes/reveals/salah.png',
                'hints' => ['The Egyptian King', "Liverpool's all-time Premier League top scorer", "Famous for his goal-scoring from the right wing"]
            ],
            [
                'answer' => 'Lionel Messi',
                'image' => 'silhouettes/messi.png',
                'reveal' => 'silhouettes/reveals/messi.png',
                'hints' => ['The GOAT from Argentina', 'Legendary Barcelona #10', 'Won the World Cup in 2022']
            ],
            [
                'answer' => 'Cristiano Ronaldo',
                'image' => 'silhouettes/ronaldo.png',
                'reveal' => 'silhouettes/reveals/ronaldo.png',
                'hints' => ['CR7', 'All-time top scorer in international football', 'Has played for Man Utd, Real Madrid, and Juventus']
            ],
            [
                'answer' => 'Kylian Mbappé',
                'image' => 'silhouettes/mbappe.png',
                'reveal' => 'silhouettes/reveals/mbappe.png',
                'hints' => ['French speedster', 'Scored a hat-trick in a World Cup final', 'PSG all-time top scorer']
            ],
            [
                'answer' => 'Neymar Jr',
                'image' => 'silhouettes/neymar.png',
                'reveal' => 'silhouettes/reveals/neymar.png',
                'hints' => ['Brazilian trickster', 'World record transfer fee of €222m', 'Famous for his "Rainbow Flick"']
            ],
            [
                'answer' => 'Zlatan Ibrahimović',
                'image' => 'silhouettes/zlatan.png',
                'reveal' => 'silhouettes/reveals/zlatan.png',
                'hints' => ['He famously said: "I came like a king, left like a legend"', 'Known for his taekwondo-style goals', 'Played for both Milan clubs, PSG, and Barca']
            ],
            [
                'answer' => 'Harry Kane',
                'image' => 'silhouettes/kane.png',
                'reveal' => 'silhouettes/reveals/kane.png',
                'hints' => ["England's all-time record goalscorer", 'Moved to Bayern Munich in 2023', 'Former Tottenham superstar']
            ],
            [
                'answer' => 'Erling Haaland',
                'image' => 'silhouettes/haaland.png',
                'reveal' => 'silhouettes/reveals/haaland.png',
                'hints' => ['Man City goal machine', 'The Robot from Norway', 'Premier League single-season scoring record']
            ],
            [
                'answer' => 'Kevin De Bruyne',
                'image' => 'silhouettes/kdb.png',
                'reveal' => 'silhouettes/reveals/kdb.png',
                'hints' => ['Man City midfield maestro', 'The King of Assists', 'Visionary vision and crossing']
            ],
            [
                'answer' => 'Luka Modrić',
                'image' => 'silhouettes/modric.png',
                'reveal' => 'silhouettes/reveals/modric.png',
                'hints' => ['The Croatian Magician', 'Won the Ballon d\'Or in 2018', 'Real Madrid legendary midfielder']
            ],
            [
                'answer' => 'Karim Benzema',
                'image' => 'silhouettes/benzema.png',
                'reveal' => 'silhouettes/reveals/benzema.png',
                'hints' => ['Real Madrid legend', 'Known for his link-up play and finishing', 'Won the Ballon d\'Or in 2022']
            ],
            [
                'answer' => 'Ronaldinho',
                'image' => 'silhouettes/ronaldinho.png',
                'reveal' => 'silhouettes/reveals/ronaldinho.png',
                'hints' => ['Always smiling', 'The Samba King', '2005 Ballon d\'Or winner and Barca legend']
            ],
        ];

        $this->seedGenre($game, $football, $footballData);

        // 5. Actors Challenges (5 levels) - Now using Transparent PNGs for On-the-fly Silhouettes
        $actorsData = [
            [
                'answer' => 'Adel Emam', 
                'image' => 'silhouettes/actors/adel_emam.png', 
                'reveal' => 'silhouettes/actors/adel_emam.png',
                'hints' => ['Known as "El Za\'im" (The Leader)', 'Starred in "Al Irhabi" and "Al Zaeem"', 'The most famous comedian in Arab history']
            ],
            [
                'answer' => 'Ahmed Zaki', 
                'image' => 'silhouettes/actors/ahmed_zaki.png', 
                'reveal' => 'silhouettes/actors/ahmed_zaki.png',
                'hints' => ['The Black Tiger', 'Portrayed Presidents Nasser and Sadat', 'Famous for "Al Kit Kat" and "Al Beih Al Bawab"']
            ],
            [
                'answer' => 'Ismail Yassine', 
                'image' => 'silhouettes/actors/ismail_yassine.png', 
                'reveal' => 'silhouettes/actors/ismail_yassine.png',
                'hints' => ['Iconic for his large mouth and comedic expressions', 'Had a series of films named after him in the army/navy', 'The king of Egyptian comedy in the 50s']
            ],
            [
                'answer' => 'Fouad El-Mohandes', 
                'image' => 'silhouettes/actors/fouad_elmohandes.png', 
                'reveal' => 'silhouettes/actors/fouad_elmohandes.png',
                'hints' => ['The Professor (El Ostaz)', 'Famous for "Sayidati Al Jamila"', 'One of the pillars of Egyptian theater']
            ],
            [
                'answer' => 'Nour El-Sherif', 
                'image' => 'silhouettes/actors/nour_elsherif.png', 
                'reveal' => 'silhouettes/actors/nour_elsherif.png',
                'hints' => ['Starred as Haj Metwalli', 'Famous for "Sawaq El Atubis"', 'Known for his deep intellectual roles and TV dramas']
            ],
        ];

        $this->seedGenre($game, $actors, $actorsData);

        $this->command->info('✅ Cleaned and Seeded Guess the Silhouette with Football & Actors!');
    }

    private function seedGenre($game, $genre, $data) {
        foreach ($data as $item) {
            // Ensure the item exists in the GameItem table for autocomplete
            \App\Models\GameItem::firstOrCreate([
                'type' => $genre->slug === 'football' ? 'player' : 'actor',
                'name_en' => $item['answer'],
            ]);

            $challenge = Challenge::create([
                'game_id' => $game->id,
                'genre_id' => $genre->id,
                'answer' => $item['answer'],
                'difficulty' => 'medium',
                'stimulus_type' => 'image',
                'stimulus_data' => [
                    'image_path' => $item['image'],
                    'reveal_image_path' => $item['reveal'],
                ],
                'answer_type' => $genre->slug === 'football' ? 'player' : 'actor',
                'is_active' => true,
            ]);
            foreach ($item['hints'] as $idx => $content) {
                $challenge->hints()->create([
                    'content' => $content,
                    'sort_order' => $idx
                ]);
            }
        }
    }
}
