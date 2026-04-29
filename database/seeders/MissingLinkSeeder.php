<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Challenge;
use App\Models\ChallengeHint;
use Illuminate\Database\Seeder;

class MissingLinkSeeder extends Seeder
{
    public function run(): void
    {
        $game = Game::where('slug', 'missing-link')->first();
        if (!$game) return;

        $football = Genre::where('slug', 'football')->first();
        $actors = Genre::where('slug', 'actors')->first();
        $movies = Genre::where('slug', 'movies')->first();

        // 1. Players (50)
        $players = [
            ['Lionel Messi', ['Argentina', 'Barcelona', 'Inter Miami', 'GOAT']],
            ['Cristiano Ronaldo', ['Portugal', 'Real Madrid', 'Al Nassr', 'CR7']],
            ['Mohamed Salah', ['Egypt', 'Liverpool', 'Roma', 'Pharaoh']],
            ['Erling Haaland', ['Norway', 'Dortmund', 'Man City', 'Robot']],
            ['Kylian Mbappe', ['France', 'Monaco', 'PSG', 'Speed']],
            ['Neymar Jr', ['Brazil', 'Santos', 'Barcelona', 'Al Hilal']],
            ['Kevin De Bruyne', ['Belgium', 'Wolfsburg', 'Man City', 'Assist King']],
            ['Robert Lewandowski', ['Poland', 'Dortmund', 'Bayern', 'Barca']],
            ['Karim Benzema', ['France', 'Real Madrid', 'Ballon d\'Or', 'Al Ittihad']],
            ['Luka Modric', ['Croatia', 'Tottenham', 'Real Madrid', 'Maestro']],
            ['Harry Kane', ['England', 'Tottenham', 'Bayern', 'Captain']],
            ['Zinedine Zidane', ['France', 'Juventus', 'Real Madrid', 'Headbutt']],
            ['Ronaldinho', ['Brazil', 'PSG', 'Barcelona', 'Magic']],
            ['Pele', ['Brazil', 'Santos', '3 World Cups', 'King']],
            ['Diego Maradona', ['Argentina', 'Napoli', 'Barcelona', 'Hand of God']],
            ['Johan Cruyff', ['Netherlands', 'Ajax', 'Barcelona', 'Total Football']],
            ['Thierry Henry', ['France', 'Monaco', 'Arsenal', 'Invincible']],
            ['Wayne Rooney', ['England', 'Everton', 'Man United', 'Wazza']],
            ['Steven Gerrard', ['England', 'Liverpool', 'LA Galaxy', 'Captain Fantastic']],
            ['Frank Lampard', ['England', 'West Ham', 'Chelsea', 'Super Frank']],
            ['David Beckham', ['England', 'Man United', 'Real Madrid', 'Free Kicks']],
            ['Luis Suarez', ['Uruguay', 'Liverpool', 'Barcelona', 'El Pistolero']],
            ['Zlatan Ibrahimovic', ['Sweden', 'Ajax', 'Milan', 'The Lion']],
            ['Virgil van Dijk', ['Netherlands', 'Celtic', 'Liverpool', 'Wall']],
            ['Vinicius Jr', ['Brazil', 'Flamengo', 'Real Madrid', 'Vini']],
            ['Jude Bellingham', ['England', 'Dortmund', 'Real Madrid', 'Golden Boy']],
            ['Antoine Griezmann', ['France', 'Sociedad', 'Atletico', 'Grizou']],
            ['Son Heung-min', ['South Korea', 'Leverkusen', 'Tottenham', 'Sonny']],
            ['Sadio Mane', ['Senegal', 'Southampton', 'Liverpool', 'Bayern']],
            ['Riyad Mahrez', ['Algeria', 'Leicester', 'Man City', 'Al Ahli']],
            ['Gianluigi Buffon', ['Italy', 'Parma', 'Juventus', 'Gigi']],
            ['Manuel Neuer', ['Germany', 'Schalke', 'Bayern', 'Sweeper-Keeper']],
            ['Lev Yashin', ['Soviet Union', 'Dynamo Moscow', 'Ballon d\'Or', 'Black Spider']],
            ['Samuel Eto\'o', ['Cameroon', 'Barcelona', 'Inter', 'Chelsea']],
            ['Didier Drogba', ['Ivory Coast', 'Marseille', 'Chelsea', 'Legend']],
            ['Kaka', ['Brazil', 'Sao Paulo', 'Milan', 'Real Madrid']],
            ['Andrea Pirlo', ['Italy', 'Milan', 'Juventus', 'Architect']],
            ['Xavi Hernandez', ['Spain', 'Barcelona', 'Al Sadd', 'Brain']],
            ['Andres Iniesta', ['Spain', 'Barcelona', 'Vissel Kobe', 'The Illusionist']],
            ['Roberto Carlos', ['Brazil', 'Palmeiras', 'Real Madrid', 'Bullet Man']],
            ['Paolo Maldini', ['Italy', 'AC Milan', 'One Club Man', 'Il Capitano']],
            ['Sergio Ramos', ['Spain', 'Sevilla', 'Real Madrid', '92:48']],
            ['Casemiro', ['Brazil', 'Real Madrid', 'Man United', 'Tank']],
            ['Rodri', ['Spain', 'Atletico', 'Man City', 'Anchor']],
            ['NGolo Kante', ['France', 'Leicester', 'Chelsea', 'Al Ittihad']],
            ['Paul Pogba', ['France', 'Man United', 'Juventus', 'Pogboom']],
            ['Gareth Bale', ['Wales', 'Tottenham', 'Real Madrid', 'Sprint']],
            ['Marco Reus', ['Germany', 'Gladbach', 'Dortmund', 'Captain']],
            ['Ronaldo Nazario', ['Brazil', 'Inter', 'Real Madrid', 'O Fenomeno']],
            ['Iker Casillas', ['Spain', 'Real Madrid', 'Porto', 'San Iker']],
        ];

        // 2. Actors (50)
        $egyActors = [
            ['Adel Emam', ['The Leader', 'Comedy', 'School of Rioters', 'Zaeem']],
            ['Ahmed Zaki', ['Black Tiger', 'Escape', 'Master', 'Sadat']],
            ['Nour El Sherif', ['Haj Metwali', 'The Night of the Baby Doll', 'Kit Kat', 'Culture']],
            ['Mahmoud Abdel Aziz', ['The Magician', 'Raafat Al-Hagan', 'Kit Kat', 'Gentleman']],
            ['Ismail Yassine', ['Classic', 'Funny Face', 'Army', 'Comedy']],
            ['Fouad El Mohandes', ['Mr. X', 'Professor', 'My Fair Lady', 'Comedy']],
            ['Omar Sharif', ['International', 'Doctor Zhivago', 'Lawrence of Arabia', 'Bridge']],
            ['Yousra', ['Diva', 'Adel Emam', 'Birds of Darkness', 'Cairo']],
            ['Faten Hamama', ['Lady', 'Empire M', 'I Want a Solution', 'Screen']],
            ['Souad Hosny', ['Cinderella', 'Zouzou', 'Small for Love', 'Moon']],
            ['Ahmed Helmy', ['X-Large', 'Zaki Chan', 'Black Honey', 'Comedy']],
            ['Mona Zaki', ['Sahar El Layali', 'Newton\'s Cradle', 'Diva', 'Egypt']],
            ['Karim Abdel Aziz', ['Blue Elephant', 'The Choice', 'Kira & El Gin', 'Action']],
            ['Ahmed Ezz', ['Welad Rizk', 'The Passage', 'Kira & El Gin', 'Action']],
            ['Amir Karara', ['Bashar Masr', 'The Choice', 'Kalabsh', 'Action']],
            ['Mohamed Ramadan', ['Number One', 'Legend', 'The Prince', 'Action']],
            ['Tamer Hosny', ['Star', 'Singer', 'Omar & Salma', 'Suit']],
            ['Menna Shalaby', ['Newton\'s Cradle', 'The Choice', 'After the Battle', 'Diva']],
            ['Hend Sabry', ['Tunisia', 'Blue Elephant', 'Ayza Atgawez', 'Star']],
            ['Mohamed Henedy', ['Sa\'idi', 'Timon', 'Voleur', 'Comedy']],
            ['Alaa Waley El Din', ['Aboud', 'El Nazer', 'Beloved', 'Comedy']],
            ['Hassan Hosny', ['Father', 'Comedy', 'Supporting', 'Legend']],
            ['Samir Ghanem', ['Fatouta', 'Three Lights', 'Comedy', 'Legend']],
            ['Dalal Abdel Aziz', ['Beloved', 'Mother', 'Legend', 'Diva']],
            ['Nelly Karim', ['That', 'Segn El Nessa', 'Blue Elephant', 'Drama']],
            ['Asser Yassin', ['100 Faces', 'Diva', 'Action', 'Star']],
            ['Maged El Kedwany', 'Brilliant', 'Comedy', 'Character', 'Star'],
            ['Mohamed Saad', ['Limby', 'Booha', 'Comedy', 'Characters']],
            ['Ahmed Mekky', ['Al Kabeer', 'H-Dabbour', 'Rap', 'Comedy']],
            ['Akram Hosny', ['Abu Hafeezah', 'Maktoub Alaya', 'Comedy', 'Writer']],
            ['Ruby', ['Segn El Nessa', 'Singer', 'Diva', 'Egypt']],
            ['Sherihan', ['Fawazir', 'Stage', 'Legend', 'Diva']],
            ['Khaled El Nabawy', ['International', 'Kingdom of Heaven', 'Mamluks', 'Star']],
            ['Bassem Samra', ['Raw', 'That', 'Action', 'Star']],
            ['Mohamed Farag', ['Newton\'s Cradle', 'Method', 'Star', 'Actor']],
            ['Eyad Nassar', ['Jordan', 'The Choice', 'Diva', 'Star']],
            ['Dina El Sherbiny', ['Malika', 'Diva', 'Star', 'Egypt']],
            ['Amina Khalil', ['Grand Hotel', 'Diva', 'Star', 'Egypt']],
            ['Chico', ['Trio', 'Al Laba', 'Comedy', 'Star']],
            ['Hesham Maged', ['Trio', 'Writer', 'Comedy', 'Star']],
            ['Shadia', ['Voice', 'Diva', 'Singer', 'Legend']],
            ['Abdel Halim Hafez', ['Nightingale', 'Singer', 'Legend', 'Star']],
            ['Rushdy Abaza', ['Don Juan', 'Man', 'Legend', 'Star']],
            ['Laila Elwi', ['Beauty', 'Diva', 'Star', 'Legend']],
            ['Elham Shahin', ['Talent', 'Diva', 'Star', 'Legend']],
            ['Nelly', ['Fawazir', 'Diva', 'Star', 'Legend']],
            ['Donia Samir Ghanem', ['Multi-talented', 'Lahfa', 'Diva', 'Star']],
            ['Bayoumi Fouad', ['Busy', 'Comedy', 'Father', 'Star']],
            ['Hala Shiha', ['Pearl', 'Diva', 'Star', 'Legend']],
            ['Donia Abd Elaziz', ['Child Star', 'Diva', 'Star', 'Legend']],
        ];

        // 3. Movies (50)
        $movieData = [
            ['The Godfather', ['Mafia', 'Corleone', 'Italy', 'Horse Head']],
            ['Inception', ['Dreams', 'Spinning Top', 'Nolan', 'Layers']],
            ['Titanic', ['Ship', 'Iceberg', 'Jack & Rose', 'Blue Diamond']],
            ['Joker', ['Arthur Fleck', 'Clown', 'Gotham', 'Stairs']],
            ['Pulp Fiction', ['Tarantino', 'Suitcase', 'Dancing', 'Royale with Cheese']],
            ['Forrest Gump', ['Chocolate Box', 'Running', 'Bubba Gump', 'Feather']],
            ['The Dark Knight', ['Batman', 'Joker', 'Why So Serious', 'Two-Face']],
            ['Gladiator', ['Maximus', 'Rome', 'Colosseum', 'Spaniard']],
            ['Avatar', ['Pandora', 'Na\'vi', 'Blue', 'Flying']],
            ['Interstellar', ['Space', 'Black Hole', 'Cooper', 'TARS']],
            ['Parasite', ['Peach', 'Basement', 'Pizza Box', 'Rain']],
            ['Avengers', ['Stones', 'Snap', 'Thanos', 'Assemble']],
            ['Iron Man', ['Suit', 'Jarvis', 'Arc Reactor', 'Stark']],
            ['Spider Man', ['Web', 'Bite', 'Uncle Ben', 'New York']],
            ['Star Wars', ['Light Saber', 'Vader', 'Force', 'Death Star']],
            ['Jurassic Park', ['Dinosaurs', 'Island', 'DNA', 'Jeep']],
            ['The Matrix', ['Neo', 'Red Pill', 'Agent Smith', 'Phone Booth']],
            ['Fight Club', ['Soap', 'First Rule', 'Project Mayhem', 'Tyler']],
            ['Se7en', ['Box', 'Sins', 'Rainy City', 'Detective']],
            ['Braveheart', ['Freedom', 'Scotland', 'Blue Face', 'Wallace']],
            ['Scarface', ['Tony Montana', 'Cocaine', 'Chainsaw', 'Little Friend']],
            ['Goodfellas', ['Mob', 'Wise Guy', 'Funny How?', 'Copacabana']],
            ['Toy Story', ['Woody', 'Buzz', 'Andy', 'Pizza Planet']],
            ['Lion King', ['Simba', 'Pride Rock', 'Scar', 'Circle of Life']],
            ['Shrek', ['Ogre', 'Donkey', 'Swamp', 'Onions']],
            ['Frozen', ['Elsa', 'Let it Go', 'Snowman', 'Anna']],
            ['Ratatouille', ['Rat', 'Chef', 'Paris', 'Anyone Can Cook']],
            ['Coco', ['Guitar', 'Dead', 'Grandma', 'Orange Bridge']],
            ['Up', ['Balloons', 'House', 'Adventure', 'Wilderness']],
            ['Wall E', ['Robot', 'Trash', 'Plant', 'Eve']],
            ['Finding Nemo', ['Clownfish', 'Dory', 'Sydney', 'Shark']],
            ['Jaws', ['Shark', 'Boat', 'Teeth', 'Island']],
            ['Psycho', ['Shower', 'Motel', 'Mother', 'Knife']],
            ['Alien', ['Spaceship', 'Chestburster', 'Egg', 'Xenomorph']],
            ['Predator', ['Hunter', 'Jungle', 'Chopper', 'Infrared']],
            ['Terminator', ['Cyborg', 'I\'ll Be Back', 'Judgment Day', 'Sarah']],
            ['Die Hard', ['Nakatomi', 'Christmas', 'Vent', 'McClane']],
            ['Rambo', ['Knife', 'Jungle', 'Soldier', 'Forest']],
            ['Rocky', ['Boxing', 'Steps', 'Eye of the Tiger', 'Philly']],
            ['Top Gun', ['Maverick', 'Fighter Jet', 'Speed', 'Volleyball']],
            ['Mad Max', ['Desert', 'Cars', 'Fury', 'Water']],
            ['Dune', ['Arrakis', 'Worm', 'Spice', 'Paul']],
            ['Oppenheimer', ['Bomb', 'Atomic', 'Los Alamos', 'Physics']],
            ['Barbie', ['Pink', 'Dreamhouse', 'Ken', 'Mattel']],
            ['Tenet', ['Time', 'Inversion', 'Opera', 'Protagonist']],
            ['Memento', ['Polaroid', 'Tattoo', 'Memory', 'Backward']],
            ['Whiplash', ['Drums', 'Tempo', 'Fletcher', 'Blood']],
            ['La La Land', ['Musical', 'Stars', 'Piano', 'Purple Sky']],
            ['Moonlight', ['Beach', 'Blue', 'Chiron', 'Oscar']],
            ['Green Book', ['Travel', 'Piano', 'Chicken', 'Friendship']],
        ];

        // Clear existing
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
            $clues = (array) $item[1];

            $challenge = Challenge::create([
                'game_id' => $game->id,
                'genre_id' => $genre->id,
                'language' => 'en',
                'difficulty' => 'medium',
                'stimulus_type' => 'text',
                'stimulus_data' => [
                    'clues' => $clues,
                ],
                'answer' => $answer,
                'answer_type' => $answerType,
                'autocomplete_type' => $autocompleteType,
            ]);
        }
    }
}
