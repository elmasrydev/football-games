<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Challenge;
use App\Models\ChallengeHint;
use App\Models\GameItem;
use Illuminate\Database\Seeder;

class TerminologyTriviaSeeder extends Seeder
{
    public function run(): void
    {
        $game = Game::where('slug', 'terminology-trivia')->first();
        if (!$game) return;

        $football = Genre::where('slug', 'football')->first();
        $actors = Genre::where('slug', 'actors')->first();
        $movies = Genre::where('slug', 'movies')->first();

        // 1. Football Terms (EN)
        $footballTerms = [
            [
                'term' => 'Offside',
                'description' => 'A rule where a player is involved in active play while being closer to the opponent\'s goal line than both the ball and the second-to-last opponent.',
                'hints' => ['Line judge raises the flag', 'VAR often checks this by millimeters', 'Inzaghi was born in this position']
            ],
            [
                'term' => 'Nutmeg',
                'description' => 'A skill where a player kicks the ball through an opponent\'s legs.',
                'hints' => ['Known as "Panna" in some cultures', 'Embarrassing for the defender', 'Luis Suarez was a master of this']
            ],
            [
                'term' => 'Hat-trick',
                'description' => 'The achievement of scoring three goals in a single game by an individual player.',
                'hints' => ['Match ball is usually taken home', 'Perfect version includes left foot, right foot, and head', 'Geoff Hurst in 1966 final']
            ],
            [
                'term' => 'Clean Sheet',
                'description' => 'A game or period of play in which a team or goalkeeper prevents the opposition from scoring any goals.',
                'hints' => ['Prized by goalkeepers', 'Often rewarded with bonuses', 'The "Zero" on the scoreboard']
            ],
            [
                'term' => 'Bicycle Kick',
                'description' => 'An acrobatic strike where a player kicks the ball mid-air while performing a backflip.',
                'hints' => ['Also called a scissors kick', 'Rooney vs Man City', 'Ronaldo vs Juventus in UCL']
            ],
            [
                'term' => 'Panenka',
                'description' => 'A technique used in penalty kicks where the player gives a light touch to the ball, causing it to rise and fall within the center of the goal.',
                'hints' => ['Chip penalty', 'Named after a Czech player', 'Zidane in 2006 World Cup final']
            ],
            [
                'term' => 'Tiki-taka',
                'description' => 'A style of play characterized by short passing and movement, working the ball through various channels.',
                'hints' => ['Pep Guardiola\'s Barcelona', 'Spain\'s golden era', 'Possession-based football']
            ],
            [
                'term' => 'False Nine',
                'description' => 'A center-forward who drops deep into midfield, drawing defenders out of position.',
                'hints' => ['Lionel Messi role under Pep', 'Totti at Roma', 'Not a traditional striker']
            ],
        ];

        // 2. Actor Terms (EN)
        $actorTerms = [
            [
                'term' => 'Method Acting',
                'description' => 'A range of training and rehearsal techniques that seek to encourage sincere and emotionally expressive performances.',
                'hints' => ['Christian Bale is famous for it', 'Staying in character off-camera', 'Marlon Brando was a pioneer']
            ],
            [
                'term' => 'EGOT',
                'description' => 'An acronym for someone who has won an Emmy, Grammy, Oscar, and Tony Award.',
                'hints' => ['Viola Davis recently achieved this', 'The Grand Slam of show business', 'Only a few dozen people have it']
            ],
            [
                'term' => 'Stunt Double',
                'description' => 'A skilled professional who replaces an actor for dangerous or specialized sequences.',
                'hints' => ['Tom Cruise famously DOES NOT use one for most things', 'Action movie essential', 'Usually wears the same clothes']
            ],
            [
                'term' => 'A-List',
                'description' => 'A term used for the most powerful and bankable actors in Hollywood.',
                'hints' => ['Highest paid stars', 'The Rock, Tom Hanks, Brad Pitt', 'Top tier of the hierarchy']
            ],
        ];

        // 3. Movie Terms (EN)
        $movieTerms = [
            [
                'term' => 'Blockbuster',
                'description' => 'A very popular or successful movie, typically a high-budget production.',
                'hints' => ['Jaws was the first one', 'Summer release season', 'Big box office numbers']
            ],
            [
                'term' => 'Cliffhanger',
                'description' => 'A plot device in fiction which features a main character in a precarious or difficult dilemma at the end of an episode or movie.',
                'hints' => ['To be continued...', 'Keeps the audience wanting more', 'Common in sequels']
            ],
            [
                'term' => 'MacGuffin',
                'description' => 'An object or device in a movie or book that serves merely as a trigger for the plot.',
                'hints' => ['Hitchcock popularized the term', 'The briefcase in Pulp Fiction', 'The Infinity Stones in early MCU']
            ],
            [
                'term' => 'Easter Egg',
                'description' => 'A hidden reference, message, or feature in a movie.',
                'hints' => ['Common in Marvel and Pixar', 'Reward for eagle-eyed fans', 'Found in the background or dialogue']
            ],
        ];

        Challenge::where('game_id', $game->id)->where('language', 'en')->delete();

        $this->seedGenre($game, $football, $footballTerms, 'en');
        $this->seedGenre($game, $actors, $actorTerms, 'en');
        $this->seedGenre($game, $movies, $movieTerms, 'en');
    }

    private function seedGenre($game, $genre, $terms, $lang)
    {
        foreach ($terms as $item) {
            $term = $item['term'];
            $description = $item['description'];
            $hints = $item['hints'];

            // Register in GameItem for Autocomplete
            GameItem::updateOrCreate(
                ['type' => 'term', 'name_en' => $term],
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
