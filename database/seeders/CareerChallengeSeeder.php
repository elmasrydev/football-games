<?php

namespace Database\Seeders;

use App\Models\CareerChallenge;
use App\Models\CareerClub;
use App\Models\CareerHint;
use App\Models\Club;
use App\Models\Game;
use Illuminate\Database\Seeder;

class CareerChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get the Career game
        $game = Game::firstOrCreate(
            ['slug' => 'career'],
            [
                'title' => 'Career Path',
                'description' => 'Guess the player from their career history. Watch the clubs unfold and figure out who it is!',
                'image' => null,
            ]
        );

        // Sample career challenges
        $challenges = [
            [
                'player_name' => 'Cristiano Ronaldo',
                'difficulty' => 'easy',
                'clubs' => [
                    ['name' => 'Sporting CP', 'year' => 2002],
                    ['name' => 'Manchester United', 'year' => 2003],
                    ['name' => 'Real Madrid', 'year' => 2009],
                    ['name' => 'Juventus', 'year' => 2018],
                    ['name' => 'Manchester United', 'year' => 2021],
                    ['name' => 'Al-Nassr', 'year' => 2023],
                ],
                'hints' => [
                    'He has won 5 Ballon d\'Or awards.',
                    'He is the all-time top scorer in UEFA Champions League.',
                    'He has scored over 800 career goals.',
                ],
            ],
            [
                'player_name' => 'Lionel Messi',
                'difficulty' => 'easy',
                'clubs' => [
                    ['name' => 'Barcelona', 'year' => 2004],
                    ['name' => 'Paris Saint-Germain', 'year' => 2021],
                    ['name' => 'Inter Miami', 'year' => 2023],
                ],
                'hints' => [
                    'He won the 2022 FIFA World Cup with Argentina.',
                    'He has won 8 Ballon d\'Or awards.',
                    'He spent his entire youth career at one club.',
                ],
            ],
            [
                'player_name' => 'Zlatan Ibrahimovic',
                'difficulty' => 'medium',
                'clubs' => [
                    ['name' => 'Ajax', 'year' => 2001],
                    ['name' => 'Juventus', 'year' => 2004],
                    ['name' => 'Inter Milan', 'year' => 2006],
                    ['name' => 'Barcelona', 'year' => 2009],
                    ['name' => 'AC Milan', 'year' => 2010],
                    ['name' => 'Paris Saint-Germain', 'year' => 2012],
                    ['name' => 'Manchester United', 'year' => 2016],
                    ['name' => 'LA Galaxy', 'year' => 2018],
                    ['name' => 'AC Milan', 'year' => 2020],
                ],
                'hints' => [
                    'He is known for his acrobatic goals.',
                    'He has played in 7 different top European leagues.',
                    'He once said "I came like a king, left like a legend".',
                ],
            ],
            [
                'player_name' => 'David Beckham',
                'difficulty' => 'medium',
                'clubs' => [
                    ['name' => 'Manchester United', 'year' => 1992],
                    ['name' => 'Real Madrid', 'year' => 2003],
                    ['name' => 'LA Galaxy', 'year' => 2007],
                    ['name' => 'AC Milan', 'year' => 2009],
                    ['name' => 'Paris Saint-Germain', 'year' => 2013],
                ],
                'hints' => [
                    'He is famous for his free-kick abilities.',
                    'He wore the number 7 shirt at his first club.',
                    'He is married to a former Spice Girl.',
                ],
            ],
            [
                'player_name' => 'Thierry Henry',
                'difficulty' => 'medium',
                'clubs' => [
                    ['name' => 'Monaco', 'year' => 1994],
                    ['name' => 'Juventus', 'year' => 1999],
                    ['name' => 'Arsenal', 'year' => 1999],
                    ['name' => 'Barcelona', 'year' => 2007],
                    ['name' => 'New York Red Bulls', 'year' => 2010],
                ],
                'hints' => [
                    'He is Arsenal\'s all-time top scorer.',
                    'He won the World Cup with France in 1998.',
                    'He was part of the "Invincibles" team.',
                ],
            ],
            [
                'player_name' => 'Karim Benzema',
                'difficulty' => 'easy',
                'clubs' => [
                    ['name' => 'Lyon', 'year' => 2005],
                    ['name' => 'Real Madrid', 'year' => 2009],
                    ['name' => 'Al-Ittihad', 'year' => 2023],
                ],
                'hints' => [
                    'He won the Ballon d\'Or in 2022.',
                    'He spent 14 seasons at one Spanish club.',
                    'He formed a deadly trio with Ronaldo and Bale.',
                ],
            ],
            [
                'player_name' => 'Neymar Jr',
                'difficulty' => 'easy',
                'clubs' => [
                    ['name' => 'Santos', 'year' => 2009],
                    ['name' => 'Barcelona', 'year' => 2013],
                    ['name' => 'Paris Saint-Germain', 'year' => 2017],
                    ['name' => 'Al-Hilal', 'year' => 2023],
                ],
                'hints' => [
                    'He was the most expensive transfer in football history.',
                    'He is known for his dribbling skills.',
                    'He won the Champions League with Barcelona in 2015.',
                ],
            ],
        ];

        foreach ($challenges as $challengeData) {
            $challenge = CareerChallenge::create([
                'game_id' => $game->id,
                'player_name' => $challengeData['player_name'],
                'difficulty' => $challengeData['difficulty'],
            ]);

            // Add clubs
            foreach ($challengeData['clubs'] as $order => $clubData) {
                $club = Club::where('name', $clubData['name'])->first();
                if ($club) {
                    CareerClub::create([
                        'career_challenge_id' => $challenge->id,
                        'club_id' => $club->id,
                        'join_year' => $clubData['year'],
                        'sort_order' => $order,
                    ]);
                }
            }

            // Add hints
            foreach ($challengeData['hints'] as $order => $hint) {
                CareerHint::create([
                    'career_challenge_id' => $challenge->id,
                    'content' => $hint,
                    'sort_order' => $order,
                ]);
            }
        }
    }
}
