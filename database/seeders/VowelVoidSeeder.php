<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Challenge;
use App\Models\ChallengeHint;
use App\Models\GameItem;
use Illuminate\Database\Seeder;

class VowelVoidSeeder extends Seeder
{
    public function run(): void
    {
        $game = Game::where('slug', 'vowel-void')->first();
        if (!$game) return;

        $football = Genre::where('slug', 'football')->first();
        $actors = Genre::where('slug', 'actors')->first();
        $movies = Genre::where('slug', 'movies')->first();

        // 1. Players (50)
        $players = [
            ['Lionel Messi', 'The GOAT from Argentina', 'Barcelona and Inter Miami legend'],
            ['Cristiano Ronaldo', 'CR7 from Portugal', 'Real Madrid and Al Nassr star'],
            ['Mohamed Salah', 'The Egyptian King', 'Liverpool winger'],
            ['Erling Haaland', 'Norwegian goal machine', 'Man City striker'],
            ['Kylian Mbappe', 'French speedster', 'World Cup winner 2018'],
            ['Neymar Jr', 'Brazilian trickster', 'Santos and Al Hilal star'],
            ['Kevin De Bruyne', 'Belgian playmaker', 'Midfield engine for Man City'],
            ['Robert Lewandowski', 'Polish striker', 'Bayern and Barca goalscorer'],
            ['Karim Benzema', 'French Ballon d\'Or winner', 'Former Real Madrid captain'],
            ['Luka Modric', 'Croatian maestro', 'Midfield veteran'],
            ['Harry Kane', 'England captain', 'Spurs and Bayern striker'],
            ['Zinedine Zidane', 'French legend', 'Iconic headbutt in WC 2006'],
            ['Ronaldinho', 'Brazilian magician', 'Always playing with a smile'],
            ['Pele', 'The King of Football', 'Only player to win 3 World Cups'],
            ['Diego Maradona', 'Hand of God', 'Napoli and Argentina icon'],
            ['Johan Cruyff', 'Total Football pioneer', 'Ajax and Barcelona legend'],
            ['Thierry Henry', 'Arsenal Invincible', 'French goalscorer'],
            ['Wayne Rooney', 'Manchester United legend', 'England\'s former top scorer'],
            ['Steven Gerrard', 'Liverpool captain', 'Scored in Istanbul 2005'],
            ['Frank Lampard', 'Chelsea legend', 'Highest scoring midfielder'],
            ['David Beckham', 'Free-kick specialist', 'Manchester United and Real Madrid #7'],
            ['Luis Suarez', 'Uruguayan striker', 'Part of the MSN trio'],
            ['Zlatan Ibrahimovic', 'The Lion from Sweden', 'Played for both Milan clubs'],
            ['Virgil van Dijk', 'Dutch defender', 'Liverpool\'s wall'],
            ['Vinicius Jr', 'Real Madrid star', 'Brazilian winger'],
            ['Jude Bellingham', 'English young star', 'Golden Boy 2023'],
            ['Antoine Griezmann', 'French playmaker', 'Atletico Madrid star'],
            ['Son Heung-min', 'South Korean star', 'Spurs captain'],
            ['Sadio Mane', 'Senegalese winger', 'Liverpool and Bayern star'],
            ['Riyad Mahrez', 'Algerian wizard', 'Leicester and Man City star'],
            ['Gianluigi Buffon', 'Italian goalkeeper', 'World Cup winner 2006'],
            ['Manuel Neuer', 'German sweeper-keeper', 'Bayern Munich wall'],
            ['Lev Yashin', 'The Black Spider', 'Only GK to win Ballon d\'Or'],
            ['Samuel Eto\'o', 'Cameroon legend', 'Won trebles with Barca and Inter'],
            ['Didier Drogba', 'Chelsea hero', 'Ivory Coast legend'],
            ['Kaka', 'Brazilian Ballon d\'Or winner', 'AC Milan legend'],
            ['Andrea Pirlo', 'Italian architect', 'Juventus and Milan maestro'],
            ['Xavi Hernandez', 'Barca midfield brain', 'Tiki-taka master'],
            ['Andres Iniesta', 'World Cup final scorer 2010', 'Barca legend'],
            ['Roberto Carlos', 'Powerful left boot', 'Free-kick vs France 1997'],
            ['Paolo Maldini', 'AC Milan defender', 'Played until age 41'],
            ['Sergio Ramos', 'Real Madrid defender', '92:48 header'],
            ['Casemiro', 'Defensive midfielder', 'Real Madrid and Man Utd'],
            ['Rodri', 'Champions League winner 2023', 'Man City anchor'],
            ['NGolo Kante', 'Everywhere on the pitch', 'Leicester and Chelsea champion'],
            ['Paul Pogba', 'French midfielder', 'Dab celebration'],
            ['Gareth Bale', 'Welsh wizard', 'Champions League overhead kick'],
            ['Marco Reus', 'Dortmund legend', 'Loyal German winger'],
            ['Ronaldo Nazario', 'O Fenomeno', 'Brazilian striker with two WCs'],
            ['Iker Casillas', 'San Iker', 'Spain and Real Madrid GK'],
        ];

        // 2. Actors (50)
        $egyActors = [
            ['Adel Emam', 'The Leader (Al Zaeem)', 'Iconic comedy actor'],
            ['Ahmed Zaki', 'The Black Tiger', 'Master of transformations'],
            ['Nour El Sherif', 'Haj Metwali', 'Legendary TV and cinema star'],
            ['Mahmoud Abdel Aziz', 'The Magician (Al Saher)', 'Raafat Al-Hagan star'],
            ['Ismail Yassine', 'Classic comedy legend', 'Always in the army movies'],
            ['Fouad El Mohandes', 'The Professor of Comedy', 'Mr. X icon'],
            ['Omar Sharif', 'International star', 'Doctor Zhivago star'],
            ['Yousra', 'Diva of Egyptian cinema', 'Star of many Adel Emam movies'],
            ['Faten Hamama', 'Lady of the Arab Screen', 'Former wife of Omar Sharif'],
            ['Souad Hosny', 'Cinderella of Egyptian cinema', 'Star of Khally Balak Min Zouzou'],
            ['Ahmed Helmy', 'Modern comedy star', 'Star of X-Large and Zaki Chan'],
            ['Mona Zaki', 'Famous actress', 'Wife of Ahmed Helmy'],
            ['Karim Abdel Aziz', 'The Blue Elephant star', 'Son of director Mohamed Abdel Aziz'],
            ['Ahmed Ezz', 'Action star', 'Star of Welad Rizk'],
            ['Amir Karara', 'The Choice (Al Ekhteyar) star', 'The Pasha of Egypt'],
            ['Mohamed Ramadan', 'Number One', 'Star of El Brens'],
            ['Tamer Hosny', 'Star of the Generation', 'Singer and actor'],
            ['Menna Shalaby', 'Award winning actress', 'Daughter of Zizi Mostafa'],
            ['Hend Sabry', 'Tunisian-Egyptian star', 'Star of Ayza Atgawez'],
            ['Mohamed Henedy', 'Sa\'idi at the American University', 'Voice of Timon'],
            ['Alaa Waley El Din', 'Aboud on the Border', 'Beloved comedy star who died young'],
            ['Hassan Hosny', 'The Grandfather of Egyptian comedy', 'Appeared in almost every movie'],
            ['Samir Ghanem', 'Fatouta legend', 'One of the Three Lights of Theater'],
            ['Dalal Abdel Aziz', 'Beloved actress', 'Wife of Samir Ghanem'],
            ['Nelly Karim', 'Queen of drama', 'Star of That and Segn El Nessa'],
            ['Asser Yassin', 'The 100 Face star', 'Modern Egyptian leading man'],
            ['Maged El Kedwany', 'Brilliant character actor', 'Star of we\'ll be right back'],
            ['Mohamed Saad', 'Elbi Limby', 'Iconic physical comedy'],
            ['Ahmed Mekky', 'Al Kabeer Awy', 'H-Dabbour star'],
            ['Akram Hosny', 'Abu Hafeezah', 'Comedy star and writer'],
            ['Ruby', 'Singer and actress', 'Star of Segn El Nessa'],
            ['Sherihan', 'The Queen of Fawazir', 'Legendary stage performer'],
            ['Khaled El Nabawy', 'International Egyptian actor', 'Kingdom of Heaven star'],
            ['Bassem Samra', 'Raw talent from Manshia', 'Star of Al-Asli'],
            ['Mohamed Farag', 'Method actor', 'Star of Newton\'s Cradle'],
            ['Eyad Nassar', 'Jordanian star in Egypt', 'Star of Afrah Al Qobba'],
            ['Dina El Sherbiny', 'Malika star', 'Popular TV actress'],
            ['Amina Khalil', 'Grand Hotel star', 'Modern drama icon'],
            ['Chico', 'Part of the famous trio', 'Star of Al-Laba'],
            ['Hesham Maged', 'Member of the comedy trio', 'Writer and actor'],
            ['Shadia', 'The Voice of Egypt', 'Delat Al-Hassan star'],
            ['Abdel Halim Hafez', 'The Dark-Skinned Nightingale', 'Legendary singer and actor'],
            ['Rushdy Abaza', 'The Don Juan of cinema', 'Strong man of the screen'],
            ['Laila Elwi', 'Cinema beauty', 'Star of Hob Al Banat'],
            ['Elham Shahin', 'Controversial and talented', 'Ya Donia Ya Gharammy star'],
            ['Nelly', 'Fawazir legend', 'Sister of Feyرووز'],
            ['Donia Samir Ghanem', 'Multi-talented star', 'Star of Lahfa'],
            ['Bayoumi Fouad', 'The busiest man in Egypt', 'Comedy character actor'],
            ['Hala Shiha', 'The Hidden Pearl', 'Star of El Selem Wel Deeban'],
            ['Donia Abd Elaziz', 'Popular TV actress', 'Started as a child star'],
        ];

        // 3. Movies (50)
        $movieData = [
            ['The Godfather', 'Mafia masterpiece', 'Don Corleone family'],
            ['Inception', 'A dream within a dream', 'Christopher Nolan mind-bender'],
            ['Titanic', 'Jack and Rose', 'The unsinkable ship'],
            ['Joker', 'Arthur Fleck story', 'Joaquin Phoenix masterpiece'],
            ['Pulp Fiction', 'Quentin Tarantino classic', 'John Travolta and Samuel L. Jackson'],
            ['Forrest Gump', 'Life is like a box of chocolates', 'Tom Hanks legend'],
            ['The Dark Knight', 'Batman vs Joker', 'Why so serious?'],
            ['Gladiator', 'Are you not entertained?', 'Russell Crowe as Maximus'],
            ['Avatar', 'Pandora and Na\'vi', 'James Cameron epic'],
            ['Interstellar', 'Space and time travel', 'Cooper and Murph'],
            ['Parasite', 'South Korean Oscar winner', 'Social class dark comedy'],
            ['Avengers', 'Earth\'s mightiest heroes', 'Marvel Cinematic Universe'],
            ['Iron Man', 'Tony Stark', 'I am Iron Man'],
            ['Spider Man', 'With great power comes responsibility', 'Peter Parker'],
            ['Star Wars', 'May the force be with you', 'Luke Skywalker and Darth Vader'],
            ['Jurassic Park', 'Dinosaurs come back', 'Steven Spielberg epic'],
            ['The Matrix', 'Red pill or blue pill', 'Keanu Reeves as Neo'],
            ['Fight Club', 'First rule: You do not talk about it', 'Brad Pitt and Edward Norton'],
            ['Se7en', 'What\'s in the box?', 'Seven deadly sins crimes'],
            ['Braveheart', 'Freedom!', 'William Wallace story'],
            ['Scarface', 'Say hello to my little friend', 'Al Pacino as Tony Montana'],
            ['Goodfellas', 'As far back as I can remember...', 'Ray Liotta and Joe Pesci'],
            ['Toy Story', 'To infinity and beyond', 'Woody and Buzz'],
            ['Lion King', 'Hakuna Matata', 'Simba\'s journey'],
            ['Shrek', 'Ogres are like onions', 'The green swamp hero'],
            ['Frozen', 'Let it go', 'Elsa and Anna'],
            ['Ratatouille', 'Anyone can cook', 'Remy the rat'],
            ['Coco', 'Remember me', 'Day of the Dead journey'],
            ['Up', 'Balloon house', 'Carl and Russell'],
            ['Wall E', 'Last robot on Earth', 'Eve and space journey'],
            ['Finding Nemo', 'Just keep swimming', 'Marlin and Dory'],
            ['Jaws', 'You\'re gonna need a bigger boat', 'Great white shark'],
            ['Psycho', 'Shower scene', 'Alfred Hitchcock horror'],
            ['Alien', 'In space, no one can hear you scream', 'Ripley vs Xenomorph'],
            ['Predator', 'Get to the chopper!', 'Arnold vs Alien hunter'],
            ['Terminator', 'I\'ll be back', 'The cyborg assassin'],
            ['Die Hard', 'Yippee-ki-yay', 'John McClane in Nakatomi Plaza'],
            ['Rambo', 'First Blood', 'Sylvester Stallone soldier'],
            ['Rocky', 'Italian Stallion', 'Boxing legend'],
            ['Top Gun', 'Feel the need for speed', 'Maverick and Goose'],
            ['Mad Max', 'Fury Road', 'Post-apocalyptic car chase'],
            ['Dune', 'Fear is the mind-killer', 'Paul Atreides on Arrakis'],
            ['Oppenheimer', 'The atomic bomb creator', 'Now I am become death'],
            ['Barbie', 'Life in plastic', 'Margot Robbie and Ryan Gosling'],
            ['Tenet', 'Time inversion', 'Protagonist mission'],
            ['Memento', 'Short term memory loss', 'Reverse story structure'],
            ['Whiplash', 'Not quite my tempo', 'Drummer and harsh teacher'],
            ['La La Land', 'City of Stars', 'Emma Stone and Ryan Gosling musical'],
            ['Moonlight', 'Chiron\'s story', 'Oscar winner for Best Picture'],
            ['Green Book', 'Dr. Don Shirley and Tony Lip', 'The travel guide for Black people'],
        ];

        // Clear existing challenges for this game to avoid duplicates on re-seed
        Challenge::where('game_id', $game->id)->where('language', 'en')->delete();

        shuffle($players);
        shuffle($egyActors);
        shuffle($movieData);

        $this->seedGroup($game, $football, $players, 'player');
        $this->seedGroup($game, $actors, $egyActors, 'actor');
        $this->seedGroup($game, $movies, $movieData, 'movie');
    }

    private function seedGroup($game, $genre, $data, $answerType)
    {
        $autocompleteMapping = [
            'football' => 'player',
            'actors' => 'actor',
            'movies' => 'movie',
        ];
        $autocompleteType = $autocompleteMapping[$genre->slug] ?? $answerType;

        foreach ($data as $item) {
            $answer = $item[0];
            $hints = array_slice($item, 1);

            // Vowel Void logic: Remove AEIOU
            $vowelVoid = preg_replace('/[aeiouAEIOU]/', '_', $answer);

            $challenge = Challenge::create([
                'game_id' => $game->id,
                'genre_id' => $genre->id,
                'language' => 'en',
                'difficulty' => $this->getDifficulty($answer),
                'stimulus_type' => 'scrambled_text', // Component handles vowel void too
                'stimulus_data' => [
                    'consonant_display' => $vowelVoid,
                ],
                'answer' => $answer,
                'answer_type' => $answerType,
                'autocomplete_type' => $autocompleteType,
            ]);

            foreach ($hints as $idx => $hint) {
                ChallengeHint::create([
                    'challenge_id' => $challenge->id,
                    'content' => $hint,
                    'sort_order' => $idx,
                ]);
            }
        }
    }

    private function getDifficulty($str)
    {
        $len = strlen($str);
        if ($len < 8) return 'easy';
        if ($len < 12) return 'medium';
        return 'hard';
    }
}
