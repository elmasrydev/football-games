<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Challenge;
use App\Models\ChallengeHint;
use Illuminate\Database\Seeder;

class TransferChainSeeder extends Seeder
{
    public function run(): void
    {
        $game = Game::where('slug', 'transfer-chain')->first();
        if (!$game) return;

        $football = Genre::where('slug', 'football')->first();
        $actors = Genre::where('slug', 'actors')->first();
        $movies = Genre::where('slug', 'movies')->first();

        // 1. Players (50)
        $players = [
            ['Lionel Messi', ['Barcelona', 'PSG', 'Inter Miami'], ['Has 8 Ballon d\'Ors', 'Won World Cup 2022', 'La Pulga']],
            ['Cristiano Ronaldo', ['Sporting CP', 'Man United', 'Real Madrid', 'Juventus', 'Al Nassr'], ['CR7', 'Siuuu', 'Real Madrid legend']],
            ['Mohamed Salah', ['Basel', 'Chelsea', 'Roma', 'Liverpool'], ['The Egyptian King', 'Anfield Hero', 'Top PL Scorer']],
            ['Erling Haaland', ['Molde', 'Salzburg', 'Dortmund', 'Man City'], ['The Robot', 'Scored 36 goals in a season', 'Norwegian striker']],
            ['Kylian Mbappe', ['Monaco', 'PSG'], ['World Cup 2018 winner', 'Hat-trick in 2022 final', 'Speedster']],
            ['Neymar Jr', ['Santos', 'Barcelona', 'PSG', 'Al Hilal'], ['Most expensive player', 'Joga Bonito', 'Brazil number 10']],
            ['Robert Lewandowski', ['Lech Poznań', 'Dortmund', 'Bayern', 'Barcelona'], ['Goal Machine', 'The Body', 'Poland captain']],
            ['Kevin De Bruyne', ['Genk', 'Chelsea', 'Wolfsburg', 'Man City'], ['Assist King', 'Belgian maestro', 'Visionary']],
            ['Luka Modric', ['Dinamo Zagreb', 'Tottenham', 'Real Madrid'], ['Ballon d\'Or 2018', 'Croatian captain', 'Maestro']],
            ['Harry Kane', ['Tottenham', 'Leicester', 'Bayern Munich'], ['England captain', 'Prolific striker', 'Hurricane']],
            ['Zlatan Ibrahimovic', ['Malmo', 'Ajax', 'Juventus', 'Inter', 'Barca', 'Milan', 'PSG', 'Man Utd', 'LA Galaxy'], ['The Lion', 'Dare to Zlatan', 'Sweden legend']],
            ['Luis Suarez', ['Ajax', 'Liverpool', 'Barcelona', 'Atletico', 'Gremio'], ['El Pistolero', 'MSN member', 'Uruguay striker']],
            ['Karim Benzema', ['Lyon', 'Real Madrid', 'Al Ittihad'], ['Ballon d\'Or 2022', 'Nueve', 'French striker']],
            ['Sergio Ramos', ['Sevilla', 'Real Madrid', 'PSG', 'Sevilla'], ['92:48 header', 'Legendary captain', 'SR4']],
            ['Gareth Bale', ['Southampton', 'Tottenham', 'Real Madrid', 'LAFC'], ['Golf. Wales. Madrid.', 'Champions League clutch', 'Speedster']],
            ['Thierry Henry', ['Monaco', 'Juventus', 'Arsenal', 'Barcelona', 'NY Red Bulls'], ['Invincible', 'Va Va Voom', 'Arsenal statue']],
            ['Ronaldinho', ['Gremio', 'PSG', 'Barcelona', 'AC Milan', 'Flamengo'], ['Smiling magician', 'Joga Bonito', 'Ballon d\'Or 2005']],
            ['Zinedine Zidane', ['Cannes', 'Bordeaux', 'Juventus', 'Real Madrid'], ['1998 World Cup hero', 'Zizou', 'Legendary headbutt']],
            ['David Beckham', ['Man United', 'Real Madrid', 'LA Galaxy', 'AC Milan', 'PSG'], ['Bend it like...', 'Goldenballs', 'Fashion icon']],
            ['Wayne Rooney', ['Everton', 'Man United', 'DC United', 'Derby County'], ['Wazza', 'Man Utd top scorer', 'White Pele']],
            ['Frank Lampard', ['West Ham', 'Chelsea', 'Man City', 'NYCFC'], ['Super Frank', 'Chelsea top scorer', 'Genius IQ']],
            ['Steven Gerrard', ['Liverpool', 'LA Galaxy'], ['Captain Fantastic', 'Stevie G', 'Istanbul 2005']],
            ['Eden Hazard', ['Lille', 'Chelsea', 'Real Madrid'], ['Belgian wizard', 'Dribbling master', 'Chelsea legend']],
            ['Antoine Griezmann', ['Real Sociedad', 'Atletico Madrid', 'Barcelona', 'Atletico Madrid'], ['Grizou', 'France number 7', 'Euro 2016 MVP']],
            ['Sadio Mane', ['Metz', 'Salzburg', 'Southampton', 'Liverpool', 'Bayern', 'Al Nassr'], ['Senegal hero', 'AFCON winner', 'Speed and power']],
            ['Riyad Mahrez', ['Le Havre', 'Leicester', 'Man City', 'Al Ahli'], ['Desert Fox', 'Leicester miracle', 'Magic left foot']],
            ['Paul Pogba', ['Man United', 'Juventus', 'Man United', 'Juventus'], ['Pogboom', 'World Cup winner', 'Dab celebration']],
            ['Jude Bellingham', ['Birmingham City', 'Dortmund', 'Real Madrid'], ['Golden Boy', 'Midfield engine', 'Rising star']],
            ['Vinicius Jr', ['Flamengo', 'Real Madrid'], ['Vini', 'UCL Final scorer', 'Brazilian flair']],
            ['Rodri', ['Villarreal', 'Atletico', 'Man City'], ['The Anchor', 'UCL Final hero', 'Midfield brain']],
            ['NGolo Kante', ['Boulogne', 'Caen', 'Leicester', 'Chelsea', 'Al Ittihad'], ['Humble hero', 'World Cup winner', 'Everywhere on the pitch']],
            ['Casemiro', ['Sao Paulo', 'Real Madrid', 'Porto', 'Real Madrid', 'Man United'], ['The Tank', 'Midfield destroyer', 'UCL multi-winner']],
            ['Toni Kroos', ['Hansa Rostock', 'Bayern', 'Leverkusen', 'Real Madrid'], ['Sniper', 'German engine', 'Pass master']],
            ['Luka Jovic', ['Red Star', 'Benfica', 'Frankfurt', 'Real Madrid', 'Fiorentina', 'Milan'], ['Serbian striker', 'Frankfurt breakout', 'Goal poacher']],
            ['James Rodriguez', ['Banfield', 'Porto', 'Monaco', 'Real Madrid', 'Bayern', 'Everton'], ['2014 World Cup Golden Boot', 'Colombian star', 'Magic left foot']],
            ['Alexis Sanchez', ['Udinese', 'Barcelona', 'Arsenal', 'Man United', 'Inter', 'Marseille'], ['El Nino Maravilla', 'Arsenal star', 'Chile legend']],
            ['Mesut Ozil', ['Schalke', 'Bremen', 'Real Madrid', 'Arsenal', 'Fenerbahce'], ['Assist king', 'German playmaker', 'Visionary']],
            ['Angel Di Maria', ['Rosario Central', 'Benfica', 'Real Madrid', 'Man United', 'PSG', 'Juventus'], ['El Fideo', 'Finals specialist', 'World Cup winner']],
            ['Alisson Becker', ['Internacional', 'Roma', 'Liverpool'], ['World class keeper', 'The Wall', 'Golden Glove winner']],
            ['Virgil van Dijk', ['Groningen', 'Celtic', 'Southampton', 'Liverpool'], ['The Wall', 'Best defender', 'Liverpool leader']],
            ['Gianluigi Buffon', ['Parma', 'Juventus', 'PSG', 'Juventus', 'Parma'], ['Gigi', 'Goalkeeping legend', 'Italy captain']],
            ['Manuel Neuer', ['Schalke', 'Bayern Munich'], ['Sweeper-keeper', 'Wall', 'Germany captain']],
            ['Iker Casillas', ['Real Madrid', 'Porto'], ['San Iker', 'Madrid legend', 'World Cup winner']],
            ['Xabi Alonso', ['Sociedad', 'Liverpool', 'Real Madrid', 'Bayern'], ['Master of passes', 'Midfield general', 'Manager star']],
            ['Cesc Fabregas', ['Arsenal', 'Barcelona', 'Chelsea', 'Monaco', 'Como'], ['Midfield maestro', 'Visionary', 'Spain legend']],
            ['Thiago Alcantara', ['Barcelona', 'Bayern', 'Liverpool'], ['The Magician', 'Technique master', 'Midfield orchestrator']],
            ['Philippe Coutinho', ['Vasco', 'Inter', 'Liverpool', 'Barcelona', 'Bayern', 'Aston Villa'], ['The Little Magician', 'Long range specialist', 'Brazil star']],
            ['Raheem Sterling', ['Liverpool', 'Man City', 'Chelsea'], ['Speedy winger', 'Goal scorer', 'England international']],
            ['Darwin Nunez', ['Penarol', 'Almeria', 'Benfica', 'Liverpool'], ['Uruguayan striker', 'Speed and chaos', 'Record signing']],
            ['Bruno Fernandes', ['Novara', 'Udinese', 'Sampdoria', 'Sporting CP', 'Man United'], ['Portuguese Magnifico', 'Captain', 'Goal scoring midfielder']],
        ];

        // 2. Actors (50) - Movies chain
        $actorsChain = [
            ['Tom Hanks', ['Forrest Gump', 'Saving Private Ryan', 'Cast Away', 'Toy Story'], ['Life is like a box of chocolates', 'Academy Award winner', 'Wilson!']],
            ['Leonardo DiCaprio', ['Titanic', 'Inception', 'The Wolf of Wall Street', 'The Revenant'], ['Finally won an Oscar', 'King of the world', 'Dream within a dream']],
            ['Brad Pitt', ['Fight Club', 'Seven', 'Troy', 'Once Upon a Time in Hollywood'], ['Tyler Durden', 'The first rule is...', 'Achilles']],
            ['Johnny Depp', ['Edward Scissorhands', 'Pirates of the Caribbean', 'Alice in Wonderland'], ['Captain Jack Sparrow', 'Mad Hatter', 'Frequent Tim Burton collaborator']],
            ['Will Smith', ['Men in Black', 'Independence Day', 'The Pursuit of Happyness', 'King Richard'], ['The Fresh Prince', 'Slap incident', 'Academy Award winner']],
            ['Robert Downey Jr.', ['Sherlock Holmes', 'Iron Man', 'The Avengers', 'Oppenheimer'], ['I am Iron Man', 'Sherlock', 'Tony Stark']],
            ['Scarlett Johansson', ['Lost in Translation', 'The Avengers', 'Lucy', 'Black Widow'], ['Black Widow', 'Major voice role in Her', 'Top female star']],
            ['Jennifer Lawrence', ['The Hunger Games', 'Silver Linings Playbook', 'American Hustle'], ['Katniss Everdeen', 'Oscar winner', 'J-Law']],
            ['Meryl Streep', ['The Devil Wears Prada', 'Mamma Mia!', 'The Iron Lady'], ['Most Oscar nominations ever', 'Miranda Priestly', 'Acting legend']],
            ['Morgan Freeman', ['The Shawshank Redemption', 'Seven', 'The Dark Knight'], ['Voice of God', 'Narrator of everything', 'Shawshank legend']],
            ['Samuel L. Jackson', ['Pulp Fiction', 'The Avengers', 'Star Wars', 'Django Unchained'], ['Bad Mother...', 'Nick Fury', 'Mace Windu']],
            ['Harrison Ford', ['Star Wars', 'Indiana Jones', 'Blade Runner', 'The Fugitive'], ['Han Solo', 'Indy', 'Han shot first']],
            ['Tom Cruise', ['Top Gun', 'Mission: Impossible', 'Jerry Maguire', 'Rain Man'], ['Does his own stunts', 'Maverick', 'Ethan Hunt']],
            ['Dwayne Johnson', ['The Mummy Returns', 'Fast & Furious', 'Jumanji', 'Moana'], ['The Rock', 'People\'s Champ', 'Maui']],
            ['Chris Hemsworth', ['Thor', 'Extraction', 'The Avengers', 'Rush'], ['God of Thunder', 'Australian star', 'Hammer wielder']],
            ['Christian Bale', ['American Psycho', 'The Dark Knight', 'The Machinist', 'Ford v Ferrari'], ['The Batman', 'Extreme weight changes', 'Patrick Bateman']],
            ['Heath Ledger', ['10 Things I Hate About You', 'Brokeback Mountain', 'The Dark Knight'], ['The Joker', 'Oscar winner', 'Why so serious?']],
            ['Joaquin Phoenix', ['Gladiator', 'Her', 'Joker', 'Napoleon'], ['Arthur Fleck', 'Commodus', 'Method actor']],
            ['Matthew McConaughey', ['Dazed and Confused', 'Dallas Buyers Club', 'Interstellar'], ['Alright, alright, alright', 'Oscar winner', 'Cooper']],
            ['Anne Hathaway', ['The Princess Diaries', 'The Devil Wears Prada', 'Les Misérables'], ['Oscar winner', 'Catwoman', 'Princess of Genovia']],
            ['Natalie Portman', ['Léon: The Professional', 'Star Wars', 'Black Swan', 'Thor'], ['Padmé Amidala', 'Oscar winner for Black Swan', 'Started as a child actress']],
            ['Emma Stone', ['Easy A', 'La La Land', 'The Favourite', 'Poor Things'], ['Oscar winner for La La Land', 'Gwen Stacy', 'Versatile actress']],
            ['Ryan Gosling', ['The Notebook', 'Drive', 'La La Land', 'Barbie'], ['Ken', 'Noah', 'I\'m just Ken']],
            ['Margot Robbie', ['The Wolf of Wall Street', 'Suicide Squad', 'Barbie'], ['Harley Quinn', 'Barbie', 'Australian star']],
            ['Cillian Murphy', ['28 Days Later', 'Peaky Blinders', 'Oppenheimer'], ['Thomas Shelby', 'Father of the atomic bomb', 'Nolan collaborator']],
            ['Benedict Cumberbatch', ['Sherlock', 'The Imitation Game', 'Doctor Strange'], ['Sherlock Holmes', 'Stephen Strange', 'Alan Turing']],
            ['Robert De Niro', ['The Godfather Part II', 'Taxi Driver', 'Raging Bull', 'Goodfellas', 'The Irishman'], ['You talkin\' to me?', 'Travis Bickle', 'Acting legend']],
            ['Al Pacino', ['The Godfather', 'Scarface', 'Scent of a Woman', 'Heat'], ['Michael Corleone', 'Tony Montana', 'Say hello to my little friend']],
            ['Denzel Washington', ['Training Day', 'Malcolm X', 'The Equalizer', 'Fences'], ['Oscar winner', 'King Kong ain\'t got nothing on me', 'Powerful performance']],
            ['Viola Davis', ['The Help', 'Fences', 'The Woman King'], ['EGOT winner', 'Oscar for Fences', 'Powerful presence']],
            ['Chadwick Boseman', ['42', 'Get on Up', 'Black Panther'], ['King T\'Challa', 'Wakanda Forever', 'Jackie Robinson']],
            ['Gal Gadot', ['Fast & Furious', 'Wonder Woman', 'Red Notice'], ['Wonder Woman', 'Miss Israel', 'Action star']],
            ['Jason Momoa', ['Game of Thrones', 'Aquaman', 'Dune'], ['Khal Drogo', 'Aquaman', 'Big guy']],
            ['Keanu Reeves', ['Speed', 'The Matrix', 'John Wick'], ['Neo', 'John Wick', 'You\'re breathtaking']],
            ['Daniel Craig', ['Casino Royale', 'Skyfall', 'Knives Out'], ['James Bond', 'Benoit Blanc', '007']],
            ['Hugh Jackman', ['X-Men', 'The Greatest Showman', 'Logan'], ['Wolverine', 'P.T. Barnum', 'Musical star']],
            ['Ryan Reynolds', ['Deadpool', 'Free Guy', 'The Proposal'], ['Deadpool', 'Green Lantern (oops)', 'Wrexham owner']],
            ['Chris Pratt', ['Parks and Recreation', 'Guardians of the Galaxy', 'Jurassic World'], ['Star-Lord', 'Andy Dwyer', 'Voice of Mario']],
            ['Vin Diesel', ['Pitch Black', 'Fast & Furious', 'Guardians of the Galaxy'], ['Dominic Toretto', 'Groot', 'I am Groot']],
            ['Mark Wahlberg', ['The Departed', 'The Fighter', 'Ted', 'Transformers'], ['Marky Mark', 'Boston native', 'Action and comedy star']],
            ['Julia Roberts', ['Pretty Woman', 'Erin Brockovich', 'Ocean\'s Eleven'], ['The smile', 'Oscar winner', 'America\'s sweetheart']],
            ['Sandra Bullock', ['Speed', 'Miss Congeniality', 'The Blind Side', 'Gravity'], ['Oscar winner', 'FBI agent', 'Stranded in space']],
            ['George Clooney', ['Ocean\'s Eleven', 'Up in the Air', 'Gravity', 'The Descendants'], ['Danny Ocean', 'Silver fox', 'Actor and director']],
            ['Bradly Cooper', ['The Hangover', 'Silver Linings Playbook', 'A Star Is Born'], ['Phil', 'Rocket Raccoon', 'Jackson Maine']],
            ['Zendaya', ['Spider-Man', 'Euphoria', 'Dune'], ['MJ', 'Rue', 'Chani']],
            ['Timothée Chalamet', ['Call Me by Your Name', 'Dune', 'Wonka'], ['Paul Atreides', 'Willy Wonka', 'Modern star']],
            ['Florence Pugh', ['Midsommar', 'Little Women', 'Black Widow', 'Oppenheimer'], ['Yelena Belova', 'Rising star', 'Intense performances']],
            ['Anya Taylor-Joy', ['The Witch', 'The Queen\'s Gambit', 'The Menu', 'Furiosa'], ['Beth Harmon', 'Chess genius', 'Unique look']],
            ['Adel Emam', ['The Leader', 'Terrorism and Kebab', 'Birds of Darkness'], ['The Zaeem', 'Legend of Arab cinema', 'Most famous Egyptian actor']],
            ['Ahmed Helmy', ['Zaki Chan', 'X-Large', 'Black Honey'], ['Modern comedy king', 'Egyptian star', 'Mona Zaki\'s husband']],
        ];

        // 3. Movies (50) - Actors chain
        $moviesChain = [
            ['Inception', ['Leonardo DiCaprio', 'Tom Hardy', 'Cillian Murphy'], ['Dream within a dream', 'Spinning top', 'Christopher Nolan movie']],
            ['The Avengers', ['Robert Downey Jr.', 'Chris Evans', 'Scarlett Johansson'], ['Marvel\'s first big team up', 'Assemble!', 'Battle of New York']],
            ['The Dark Knight', ['Christian Bale', 'Heath Ledger', 'Morgan Freeman'], ['Batman vs Joker', 'Why so serious?', 'Gotham City']],
            ['Interstellar', ['Matthew McConaughey', 'Anne Hathaway', 'Jessica Chastain'], ['Black hole voyage', 'TARS the robot', 'Nolan sci-fi']],
            ['Titanic', ['Leonardo DiCaprio', 'Kate Winslet', 'Billy Zane'], ['Unsinkable ship', 'Jack and Rose', 'Won 11 Oscars']],
            ['Pulp Fiction', ['John Travolta', 'Samuel L. Jackson', 'Uma Thurman'], ['Tarantino masterpiece', 'Royale with cheese', 'Mia Wallace']],
            ['Forrest Gump', ['Tom Hanks', 'Robin Wright', 'Gary Sinise'], ['Life is like a box of chocolates', 'Lieutenant Dan', 'Run, Forrest, run!']],
            ['Gladiator', ['Russell Crowe', 'Joaquin Phoenix', 'Connie Nielsen'], ['"Are you not entertained?"', 'Maximus', 'Roman Colosseum']],
            ['Joker', ['Joaquin Phoenix', 'Robert De Niro', 'Zazie Beetz'], ['Arthur Fleck', 'Gotham\'s clown prince', 'Staircase dance']],
            ['Oppenheimer', ['Cillian Murphy', 'Robert Downey Jr.', 'Emily Blunt'], ['Father of the atomic bomb', 'Manhattan Project', 'Nolan biopic']],
            ['Barbie', ['Margot Robbie', 'Ryan Gosling', 'America Ferrera'], ['Barbie Land', 'I\'m just Ken', 'Pink everywhere']],
            ['Spider-Man: No Way Home', ['Tom Holland', 'Zendaya', 'Benedict Cumberbatch'], ['Multiverse crossover', 'Peter Parker', 'MCU Spidey']],
            ['The Godfather', ['Marlon Brando', 'Al Pacino', 'James Caan'], ['I\'ll make him an offer...', 'Corleone family', 'Don Vito']],
            ['Goodfellas', ['Ray Liotta', 'Robert De Niro', 'Joe Pesci'], ['"As far back as I can remember..."', 'Mob life', 'Martin Scorsese movie']],
            ['Fight Club', ['Brad Pitt', 'Edward Norton', 'Helena Bonham Carter'], ['Project Mayhem', 'Tyler Durden', 'First rule of...']],
            ['The Matrix', ['Keanu Reeves', 'Laurence Fishburne', 'Carrie-Anne Moss'], ['Simulation reality', 'Red pill or blue pill', 'Neo is the one']],
            ['Se7en', ['Brad Pitt', 'Morgan Freeman', 'Gwyneth Paltrow'], ['Seven deadly sins', '"What\'s in the box?"', 'Detective thriller']],
            ['The Wolf of Wall Street', ['Leonardo DiCaprio', 'Jonah Hill', 'Margot Robbie'], ['Jordan Belfort', 'Penny stocks', 'Martin Scorsese comedy']],
            ['Once Upon a Time in Hollywood', ['Leonardo DiCaprio', 'Brad Pitt', 'Margot Robbie'], ['Tarantino\'s 1969 LA', 'Rick Dalton', 'Cliff Booth']],
            ['Heat', ['Al Pacino', 'Robert De Niro', 'Val Kilmer'], ['Epic bank robbery', 'Pacino vs De Niro', 'Michael Mann crime']],
            ['Dune', ['Timothée Chalamet', 'Zendaya', 'Rebecca Ferguson'], ['Sand planet', 'Arrakis', 'Paul Atreides']],
            ['Top Gun: Maverick', ['Tom Cruise', 'Miles Teller', 'Jennifer Connelly'], ['Fighter jets', 'Danger Zone', '36 years later sequel']],
            ['The Revenant', ['Leonardo DiCaprio', 'Tom Hardy', 'Domhnall Gleeson'], ['Survival in the wild', 'Bear attack', 'Leo\'s first Oscar']],
            ['Knives Out', ['Daniel Craig', 'Ana de Armas', 'Chris Evans'], ['Whodunnit mystery', 'Benoit Blanc', 'Harlan Thrombey death']],
            ['Glass Onion', ['Daniel Craig', 'Edward Norton', 'Janelle Monáe'], ['Tech billionaire island', 'Benoit Blanc returns', 'Knives Out sequel']],
            ['The Departed', ['Leonardo DiCaprio', 'Matt Damon', 'Jack Nicholson'], ['Boston mob vs police', 'Undercover mole', 'Scorsese Oscar winner']],
            ['Ocean\'s Eleven', ['George Clooney', 'Brad Pitt', 'Julia Roberts'], ['Las Vegas heist', 'Danny Ocean', '11 specialists']],
            ['Django Unchained', ['Jamie Foxx', 'Christoph Waltz', 'Leonardo DiCaprio'], ['Tarantino western', 'Bounty hunter', 'Calvin Candie']],
            ['Inglourious Basterds', ['Brad Pitt', 'Christoph Waltz', 'Mélanie Laurent'], ['Nazi occupied France', 'Lt. Aldo Raine', 'Col. Hans Landa']],
            ['Saving Private Ryan', ['Tom Hanks', 'Matt Damon', 'Tom Sizemore'], ['WWII search mission', 'D-Day landing', 'Spielberg war epic']],
            ['The Shawshank Redemption', ['Tim Robbins', 'Morgan Freeman', 'Bob Gunton'], ['Prison escape', 'Andy Dufresne', 'Red\'s narration']],
            ['Star Wars: A New Hope', ['Mark Hamill', 'Harrison Ford', 'Carrie Fisher'], ['Galactic rebellion', 'Luke Skywalker', 'Han Solo']],
            ['Indiana Jones: Raiders', ['Harrison Ford', 'Karen Allen', 'Paul Freeman'], ['Archaeologist adventurer', 'Ark of the Covenant', 'Snake pit']],
            ['Jurassic Park', ['Sam Neill', 'Laura Dern', 'Jeff Goldblum'], ['Dinosaur theme park', 'Life finds a way', 'Spielberg classic']],
            ['The Lord of the Rings', ['Elijah Wood', 'Ian McKellen', 'Viggo Mortensen'], ['Middle-earth epic', 'The One Ring', 'Frodo and Gandalf']],
            ['Pirates of the Caribbean', ['Johnny Depp', 'Geoffrey Rush', 'Orlando Bloom'], ['Captain Jack Sparrow', 'Black Pearl', 'Disney pirate adventure']],
            ['Harry Potter', ['Daniel Radcliffe', 'Emma Watson', 'Rupert Grint'], ['The Boy Who Lived', 'Hogwarts', 'Wizarding world']],
            ['The Hunger Games', ['Jennifer Lawrence', 'Josh Hutcherson', 'Liam Hemsworth'], ['Dystopian survival', 'Katniss Everdeen', 'Panem']],
            ['Iron Man', ['Robert Downey Jr.', 'Gwyneth Paltrow', 'Jeff Bridges'], ['Tony Stark', 'MCU starter', 'Arc Reactor']],
            ['Guardians of the Galaxy', ['Chris Pratt', 'Zoe Saldaña', 'Dave Bautista'], ['Space outlaws', 'Star-Lord', 'Awesome Mix Vol. 1']],
            ['Thor: Ragnarok', ['Chris Hemsworth', 'Tom Hiddleston', 'Cate Blanchett'], ['God of Thunder', 'Planet Sakaar', 'Hulk in the arena']],
            ['Doctor Strange', ['Benedict Cumberbatch', 'Chiwetel Ejiofor', 'Rachel McAdams'], ['Master of mystic arts', 'Multiverse magic', 'Stephen Strange']],
            ['Mission: Impossible - Fallout', ['Tom Cruise', 'Henry Cavill', 'Rebecca Ferguson'], ['Ethan Hunt', 'HALO jump', 'Stunt masterpiece']],
            ['Extraction', ['Chris Hemsworth', 'Randeep Hooda', 'Golshifteh Farahani'], ['Mercenary rescue', 'One-shot sequence', 'Action hit']],
            ['John Wick', ['Keanu Reeves', 'Michael Nyqvist', 'Alfie Allen'], ['Ex-assassin revenge', 'They killed his dog', 'Baba Yaga']],
            ['Suicide Squad', ['Will Smith', 'Margot Robbie', 'Jared Leto'], ['Villain team-up', 'Harley Quinn', 'Deadshot']],
            ['Everything Everywhere All at Once', ['Michelle Yeoh', 'Ke Huy Quan', 'Stephanie Hsu'], ['Multiverse madness', 'Everything bagel', 'Oscar winner']],
            ['The Menu', ['Anya Taylor-Joy', 'Nicholas Hoult', 'Ralph Fiennes'], ['Culinary horror', 'Chef Slowik', 'Cheeseburger!']],
            ['Kira & El Gin', ['Karim Abdel Aziz', 'Ahmed Ezz', 'Hend Sabry'], ['Egyptian resistance', 'Historical action', 'Top box office']],
            ['Welad Rizk', ['Ahmed Ezz', 'Amr Youssef', 'Ahmed El Fishawy'], ['Crime brothers', 'Action thriller', 'Egyptian hit']],
        ];

        Challenge::where('game_id', $game->id)->where('language', 'en')->delete();

        shuffle($players);
        shuffle($actorsChain);
        shuffle($moviesChain);

        $this->seedChain($game, $football, $players, 'player', 'Follow the transfer path!');
        $this->seedChain($game, $actors, $actorsChain, 'actor', 'Follow the filmography!');
        $this->seedChain($game, $movies, $moviesChain, 'movie', 'Who is the mystery movie?');
    }

    private function seedChain($game, $genre, $data, $answerType, $instruction)
    {
        $mapping = [
            'football' => ['type' => 'club', 'id_field' => 'external_id'],
            'actors' => ['type' => 'movie', 'id_field' => 'name'],
            'movies' => ['type' => 'actor', 'id_field' => 'name'],
        ];

        $nodeType = $mapping[$genre->slug]['type'] ?? 'item';

        foreach ($data as $item) {
            $answer = $item[0];
            $nodes = (array) $item[1];
            $hints = isset($item[2]) ? (array)$item[2] : [];

            // Register Answer in GameItem for Autocomplete
            \App\Models\GameItem::updateOrCreate(
                ['type' => $answerType, 'name_en' => $answer],
                ['is_active' => true]
            );

            $formattedNodes = array_map(function($nodeName) use ($nodeType) {
                // Register Node in GameItem for Autocomplete
                \App\Models\GameItem::updateOrCreate(
                    ['type' => $nodeType, 'name_en' => $nodeName],
                    ['is_active' => true]
                );
                return ['name' => $nodeName, 'type' => $nodeType];
            }, $nodes);

            $challenge = Challenge::create([
                'game_id' => $game->id,
                'genre_id' => $genre->id,
                'language' => 'en',
                'difficulty' => 'medium',
                'stimulus_type' => 'sequence',
                'stimulus_data' => [
                    'nodes' => $formattedNodes,
                    'instruction' => $instruction,
                ],
                'answer' => $answer,
                'answer_type' => $answerType,
                'autocomplete_type' => $answerType,
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
