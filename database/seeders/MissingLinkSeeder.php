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
            ['Lionel Messi', ['Argentina', 'Barcelona', 'Inter Miami', 'GOAT'], ['World Cup 2022 winner', '7 Ballon d\'Ors', 'Left-footed magician']],
            ['Cristiano Ronaldo', ['Portugal', 'Real Madrid', 'Al Nassr', 'CR7'], ['UCL All-time top scorer', 'Siuuu celebration', 'Mr. Champions League']],
            ['Mohamed Salah', ['Egypt', 'Liverpool', 'Roma', 'Pharaoh'], ['Premier League Golden Boot winner', 'The Egyptian King', 'Anfield hero']],
            ['Erling Haaland', ['Norway', 'Dortmund', 'Man City', 'Robot'], ['Scored 36 goals in a PL season', 'Tall and powerful striker', 'Born in Leeds']],
            ['Kylian Mbappe', ['France', 'Monaco', 'PSG', 'Speed'], ['World Cup 2018 champion', 'Hat-trick in 2022 final', 'Bondy born star']],
            ['Neymar Jr', ['Brazil', 'Santos', 'Barcelona', 'Al Hilal'], ['Most expensive player ever', 'Joga Bonito', 'Dribbling master']],
            ['Kevin De Bruyne', ['Belgium', 'Wolfsburg', 'Man City', 'Assist King'], ['Visionary playmaker', 'Let me talk!', 'Two-time PFA Player of the Year']],
            ['Robert Lewandowski', ['Poland', 'Dortmund', 'Bayern', 'Barca'], ['The Body', 'Scored 5 goals in 9 minutes', 'Goal machine']],
            ['Karim Benzema', ['France', 'Real Madrid', 'Ballon d\'Or', 'Al Ittihad'], ['KB9', 'Champions League clutch king', 'Nueve']],
            ['Luka Modric', ['Croatia', 'Tottenham', 'Real Madrid', 'Maestro'], ['Ended Messi-Ronaldo streak', 'Midfield genius', '2018 World Cup Finalist']],
            ['Harry Kane', ['England', 'Tottenham', 'Bayern', 'Captain'], ['England\'s all-time top scorer', 'World-class finisher', 'Hurricane']],
            ['Zinedine Zidane', ['France', 'Juventus', 'Real Madrid', 'Headbutt'], ['1998 World Cup winner', 'Galactico', 'Zizou']],
            ['Ronaldinho', ['Brazil', 'PSG', 'Barcelona', 'Magic'], ['Smiling assassin', 'World Cup 2002 winner', 'Skill king']],
            ['Pele', ['Brazil', 'Santos', '3 World Cups', 'King'], ['O Rei', 'Over 1000 goals', 'Eternal legend']],
            ['Diego Maradona', ['Argentina', 'Napoli', 'Barcelona', 'Hand of God'], ['El Pibe de Oro', '1986 World Cup hero', 'Dribbled past 5 English players']],
            ['Johan Cruyff', ['Netherlands', 'Ajax', 'Barcelona', 'Total Football'], ['The Flying Dutchman', 'Revolutionized Ajax', '3 Ballon d\'Ors']],
            ['Thierry Henry', ['France', 'Monaco', 'Arsenal', 'Invincible'], ['Va Va Voom', 'Statue outside Emirates', 'Titi']],
            ['Wayne Rooney', ['England', 'Everton', 'Man United', 'Wazza'], ['White Pele', 'Man Utd all-time top scorer', 'Youngest Euro 2004 scorer']],
            ['Steven Gerrard', ['England', 'Liverpool', 'LA Galaxy', 'Captain Fantastic'], ['Istanbul 2005 hero', 'Legendary number 8', 'Stevie G']],
            ['Frank Lampard', ['England', 'West Ham', 'Chelsea', 'Super Frank'], ['Highest scoring PL midfielder', 'Chelsea legend', 'Genius IQ']],
            ['David Beckham', ['England', 'Man United', 'Real Madrid', 'Free Kicks'], ['Bend it like...', 'Goldenballs', 'Manchester United 7']],
            ['Luis Suarez', ['Uruguay', 'Liverpool', 'Barcelona', 'El Pistolero'], ['Bite incident', 'MSN trio member', 'Golden Shoe winner']],
            ['Zlatan Ibrahimovic', ['Sweden', 'Ajax', 'Milan', 'The Lion'], ['God of Milan', 'Scored overhead kick vs England', 'Dare to Zlatan']],
            ['Virgil van Dijk', ['Netherlands', 'Celtic', 'Liverpool', 'Wall'], ['UCL winner 2019', 'Defense leader', 'Big Virg']],
            ['Vinicius Jr', ['Brazil', 'Flamengo', 'Real Madrid', 'Vini'], ['Scored in 2022 UCL final', 'Brazilian trickster', 'Dance celebration']],
            ['Jude Bellingham', ['England', 'Dortmund', 'Real Madrid', 'Golden Boy'], ['Rising star', 'Midfield engine', 'Birmingham City number 22 retired']],
            ['Antoine Griezmann', ['France', 'Sociedad', 'Atletico', 'Grizou'], ['Euro 2016 top scorer', 'World Cup 2018 winner', 'Dancing celebration']],
            ['Son Heung-min', ['South Korea', 'Leverkusen', 'Tottenham', 'Sonny'], ['Asian icon', 'Puskas award winner', 'Fast winger']],
            ['Sadio Mane', ['Senegal', 'Southampton', 'Liverpool', 'Bayern'], ['AFCON 2021 winner', 'Speed and finishing', 'Senegal hero']],
            ['Riyad Mahrez', ['Algeria', 'Leicester', 'Man City', 'Al Ahli'], ['Leicester miracle winner', 'Desert Fox', 'Skillful left foot']],
            ['Gianluigi Buffon', ['Italy', 'Parma', 'Juventus', 'Gigi'], ['2006 World Cup winner', 'Goalkeeper longevity', 'Legendary number 1']],
            ['Manuel Neuer', ['Germany', 'Schalke', 'Bayern', 'Sweeper-Keeper'], ['Changed goalkeeping', '2014 World Cup winner', 'Bayern captain']],
            ['Lev Yashin', ['Soviet Union', 'Dynamo Moscow', 'Ballon d\'Or', 'Black Spider'], ['Only keeper to win Ballon d\'Or', 'Black jersey', 'Legendary reflexes']],
            ['Samuel Eto\'o', ['Cameroon', 'Barcelona', 'Inter', 'Chelsea'], ['Back-to-back trebles with 2 clubs', 'Indomitable Lion', 'Pichichi winner']],
            ['Didier Drogba', ['Ivory Coast', 'Marseille', 'Chelsea', 'Legend'], ['Champions League 2012 hero', 'King of Wembley', 'The African leader']],
            ['Kaka', ['Brazil', 'Milan', 'Real Madrid', 'Ballon d\'Or'], ['2007 Ballon d\'Or winner', 'Elegant playmaker', 'Brazil legend']],
            ['Andrea Pirlo', ['Italy', 'Milan', 'Juventus', 'Architect'], ['No party without...', 'Free-kick master', 'Calm under pressure']],
            ['Xavi Hernandez', ['Spain', 'Barcelona', 'Al Sadd', 'Brain'], ['Tiki-taka master', 'World Cup 2010 winner', 'Barcelona manager']],
            ['Andres Iniesta', ['Spain', 'Barcelona', 'Vissel Kobe', 'The Illusionist'], ['Scored World Cup final winning goal', 'La Masia legend', 'Don Andres']],
            ['Roberto Carlos', ['Brazil', 'Palmeiras', 'Real Madrid', 'Bullet Man'], ['Legendary free kick vs France', 'Speedy left back', 'Powerful left foot']],
            ['Paolo Maldini', ['Italy', 'AC Milan', 'One Club Man', 'Il Capitano'], ['Defensive elegance', '5-time UCL winner', 'Milan family legend']],
            ['Sergio Ramos', ['Spain', 'Sevilla', 'Real Madrid', '92:48'], ['Clutch header goals', 'Real Madrid captain', 'SR4']],
            ['Casemiro', ['Brazil', 'Real Madrid', 'Man United', 'Tank'], ['Midfield destroyer', 'UCL multi-winner', 'Brazil anchor']],
            ['Rodri', ['Spain', 'Atletico', 'Man City', 'Anchor'], ['Scored UCL final 2023 winner', 'Best DM in the world', 'Intelligent play']],
            ['NGolo Kante', ['France', 'Leicester', 'Chelsea', 'Al Ittihad'], ['Covers 70% of Earth', 'World Cup 2018 winner', 'Humble engine']],
            ['Paul Pogba', ['France', 'Man United', 'Juventus', 'Pogboom'], ['World Cup 2018 winner', 'Skillful midfielder', 'Dance celebration']],
            ['Gareth Bale', ['Wales', 'Tottenham', 'Real Madrid', 'Sprint'], ['Golf. Wales. Madrid. In that order.', 'UCL final overhead kick', 'Speedster']],
            ['Marco Reus', ['Germany', 'Gladbach', 'Dortmund', 'Captain'], ['Loyal Dortmund legend', 'Creative attacker', 'Rolls Reus']],
            ['Ronaldo Nazario', ['Brazil', 'Inter', 'Real Madrid', 'O Fenomeno'], ['Two World Cups', 'Inter and Milan star', 'Best number 9 ever']],
            ['Iker Casillas', ['Spain', 'Real Madrid', 'Porto', 'San Iker'], ['2010 World Cup winning save', 'Madrid legend', 'Best Spanish keeper']],
        ];

        // 2. Actors (50)
        $egyActors = [
            ['Adel Emam', ['The Leader', 'Comedy', 'School of Rioters', 'Zaeem'], ['Most famous Egyptian actor', 'Starred in "The Terrorist"', 'Cultural icon']],
            ['Ahmed Zaki', ['Black Tiger', 'Escape', 'Master', 'Sadat'], ['The Great Actor', 'Known for character transformations', 'Egyptian cinema legend']],
            ['Nour El Sherif', ['Haj Metwali', 'The Night of the Baby Doll', 'Kit Kat', 'Culture'], ['Intellectual actor', 'Legendary TV star', 'Known for diverse roles']],
            ['Mahmoud Abdel Aziz', ['The Magician', 'Raafat Al-Hagan', 'Kit Kat', 'Gentleman'], ['The Magician of Egyptian cinema', 'Legendary spy role', 'Beloved star']],
            ['Ismail Yassine', ['Classic', 'Funny Face', 'Army', 'Comedy'], ['The King of Comedy', 'Known for his unique expressions', 'Iconic film series']],
            ['Fouad El Mohandes', ['Mr. X', 'Professor', 'My Fair Lady', 'Comedy'], ['The Professor of comedy', 'Stage legend', 'Known for linguistic humor']],
            ['Omar Sharif', ['International', 'Doctor Zhivago', 'Lawrence of Arabia', 'Bridge'], ['Egyptian Oscar nominee', 'Global movie star', 'Bridge champion']],
            ['Yousra', ['Diva', 'Adel Emam', 'Birds of Darkness', 'Cairo'], ['The Queen of Egyptian screen', 'UN Goodwill Ambassador', 'Long career with Adel Emam']],
            ['Faten Hamama', ['Lady', 'Empire M', 'I Want a Solution', 'Screen'], ['The Lady of Arabic screen', 'Wife of Omar Sharif', 'Advocated for women\'s rights']],
            ['Souad Hosny', ['Cinderella', 'Zouzou', 'Small for Love', 'Moon'], ['The Cinderella of Arabic cinema', 'Multi-talented star', 'Iconic in the 60s and 70s']],
            ['Ahmed Helmy', ['X-Large', 'Zaki Chan', 'Black Honey', 'Comedy'], ['Modern comedy king', 'Known for relatable roles', 'Wife is Mona Zaki']],
            ['Mona Zaki', ['Sahar El Layali', 'Newton\'s Cradle', 'Diva', 'Egypt'], ['Top female star of her generation', 'Started as a child actress', 'Married to Ahmed Helmy']],
            ['Karim Abdel Aziz', ['Blue Elephant', 'The Choice', 'Kira & El Gin', 'Action'], ['Action and drama star', 'Son of a director', 'Top box office star']],
            ['Ahmed Ezz', ['Welad Rizk', 'The Passage', 'Kira & El Gin', 'Action'], ['Modern action star', 'Known for handsome looks', 'Star of "The Passage"']],
            ['Amir Karara', ['Bashar Masr', 'The Choice', 'Kalabsh', 'Action'], ['The "Pasha" of Egypt', 'Action hero', 'Famous for "The Choice"']],
            ['Mohamed Ramadan', ['Number One', 'Legend', 'The Prince', 'Action'], ['The controversial superstar', 'Singer and actor', 'Known as "The Legend"']],
            ['Tamer Hosny', ['Star', 'Singer', 'Omar & Salma', 'Suit'], ['Star of the generation', 'Successful singer/actor', 'Pop icon']],
            ['Menna Shalaby', ['Newton\'s Cradle', 'The Choice', 'After the Battle', 'Diva'], ['International award winner', 'Versatile actress', 'Daughter of Zizi Mostafa']],
            ['Hend Sabry', ['Tunisia', 'Blue Elephant', 'Ayza Atgawez', 'Star'], ['Tunisian-Egyptian star', 'Lawyer and actress', 'Socially conscious roles']],
            ['Mohamed Henedy', ['Sa\'idi', 'Timon', 'Voleur', 'Comedy'], ['Comedy revolution leader', 'Small in size, big in talent', 'Voice of Disney characters']],
            ['Alaa Waley El Din', ['Aboud', 'El Nazer', 'Beloved', 'Comedy'], ['Pure-hearted comedian', 'Died young', 'Star of "El Nazer"']],
            ['Hassan Hosny', ['Father', 'Comedy', 'Supporting', 'Legend'], ['The father figure of modern comedy', 'Most prolific actor', 'Mentor to stars']],
            ['Samir Ghanem', ['Fatouta', 'Three Lights', 'Comedy', 'Legend'], ['The improvisation king', 'Fawazir legend', 'Husband of Dalal Abdel Aziz']],
            ['Dalal Abdel Aziz', ['Beloved', 'Mother', 'Legend', 'Diva'], ['The kind mother of cinema', 'Star of drama', 'Mother of Donia and Amy']],
            ['Nelly Karim', ['That', 'Segn El Nessa', 'Blue Elephant', 'Drama'], ['The drama queen', 'Former ballerina', 'Intense emotional roles']],
            ['Asser Yassin', ['100 Faces', 'Diva', 'Action', 'Star'], ['Versatile and handsome', 'Action and comedy star', 'Engineering graduate']],
            ['Maged El Kedwany', ['Brilliant', 'Comedy', 'Character', 'Star'], ['The actor\'s actor', 'Deep emotional performance', 'Comedy and drama master']],
            ['Mohamed Saad', ['Limby', 'Booha', 'Comedy', 'Characters'], ['Known for extreme characters', 'Physical comedy expert', 'The "Limby" creator']],
            ['Ahmed Mekky', ['Al Kabeer', 'H-Dabbour', 'Rap', 'Comedy'], ['Multi-talented star', 'Rapper and actor', '"Al Kabeer Awy" creator']],
            ['Akram Hosny', ['Abu Hafeezah', 'Maktoub Alaya', 'Comedy', 'Writer'], ['Started as a radio personality', 'Comedy writer and actor', 'Creator of Abu Hafeezah']],
            ['Ruby', ['Segn El Nessa', 'Singer', 'Diva', 'Egypt'], ['Natural beauty', 'Successful singer and actress', 'Egyptian star']],
            ['Sherihan', ['Fawazir', 'Stage', 'Legend', 'Diva'], ['The Fawazir legend', 'Stage icon', 'Survivor and star']],
            ['Khaled El Nabawy', ['International', 'Kingdom of Heaven', 'Mamluks', 'Star'], ['Egyptian global talent', 'Serious and intellectual roles', 'Kingdom of Heaven star']],
            ['Bassem Samra', ['Raw', 'That', 'Action', 'Star'], ['The realistic actor', 'Powerful presence', 'Known for gritty roles']],
            ['Mohamed Farag', ['Newton\'s Cradle', 'Method', 'Star', 'Actor'], ['Intense performance', 'Modern talent', 'The master of expressions']],
            ['Eyad Nassar', ['Jordan', 'The Choice', 'Diva', 'Star'], ['Jordanian talent in Egypt', 'Historical and modern roles', 'Star of "The Choice"']],
            ['Dina El Sherbiny', ['Malika', 'Diva', 'Star', 'Egypt'], ['Rising female star', 'Diverse TV roles', 'Egyptian talent']],
            ['Amina Khalil', ['Grand Hotel', 'Diva', 'Star', 'Egypt'], ['Modern fashion icon', 'Versatile actress', 'Star of "Grand Hotel"']],
            ['Chico', ['Trio', 'Al Laba', 'Comedy', 'Star'], ['Part of the comedy trio', 'Big heart and talent', 'Star of "Al Laba"']],
            ['Hesham Maged', ['Trio', 'Writer', 'Comedy', 'Star'], ['Writer and actor', 'Intellectual comedian', 'Part of the trio']],
            ['Shadia', ['Voice', 'Diva', 'Singer', 'Legend'], ['The idol of millions', 'Iconic singer and actress', 'Known for patriotism']],
            ['Abdel Halim Hafez', ['Nightingale', 'Singer', 'Legend', 'Star'], ['The Black Nightingale', 'Legendary singer', 'Star of many films']],
            ['Rushdy Abaza', ['Don Juan', 'Man', 'Legend', 'Star'], ['Egyptian Don Juan', 'Masculine charm', 'Golden Age star']],
            ['Laila Elwi', ['Beauty', 'Diva', 'Star', 'Legend'], ['The beautiful diva', 'Long successful career', 'Cinema icon']],
            ['Elham Shahin', ['Talent', 'Diva', 'Star', 'Legend'], ['Strong personality actress', 'Diverse roles', 'Egyptian star']],
            ['Nelly', ['Fawazir', 'Diva', 'Star', 'Legend'], ['The Fawazir queen', 'Fashion and grace', 'Star of many shows']],
            ['Donia Samir Ghanem', ['Multi-talented', 'Lahfa', 'Diva', 'Star'], ['Singer and actress', 'Comedy and drama star', 'Daughter of Samir Ghanem']],
            ['Bayoumi Fouad', ['Busy', 'Comedy', 'Father', 'Star'], ['Most frequent actor', 'The Joker', 'Modern comedian']],
            ['Hala Shiha', ['Pearl', 'Diva', 'Star', 'Legend'], ['The pearl of screen', 'Known for delicate roles', 'Egyptian star']],
            ['Donia Abd Elaziz', ['Child Star', 'Diva', 'Star', 'Legend'], ['Started very young', 'Consistent presence', 'Egyptian talent']],
        ];

        // 3. Movies (50)
        $movieData = [
            ['The Godfather', ['Mafia', 'Corleone', 'Italy', 'Horse Head'], ['"I\'ll make him an offer..."', 'Directed by Coppola', 'Starring Marlon Brando']],
            ['Inception', ['Dreams', 'Spinning Top', 'Nolan', 'Layers'], ['"We need to go deeper"', 'Christopher Nolan directed it', 'Leonardo DiCaprio stars']],
            ['Titanic', ['Ship', 'Iceberg', 'Jack & Rose', 'Blue Diamond'], ['Directed by James Cameron', 'Won 11 Oscars', 'Theme by Celine Dion']],
            ['Joker', ['Arthur Fleck', 'Clown', 'Gotham', 'Stairs'], ['Joaquin Phoenix won Oscar', 'Psychological thriller', 'DC origins']],
            ['Pulp Fiction', ['Tarantino', 'Suitcase', 'Dancing', 'Royale with Cheese'], ['Quentin Tarantino masterwork', 'John Travolta comeback', 'Non-linear story']],
            ['Forrest Gump', ['Chocolate Box', 'Running', 'Bubba Gump', 'Feather'], ['"Life is like a..."', 'Tom Hanks stars', 'Won Best Picture']],
            ['The Dark Knight', ['Batman', 'Joker', 'Why So Serious', 'Two-Face'], ['Heath Ledger\'s Joker', 'Best superhero movie', 'The Caped Crusader']],
            ['Gladiator', ['Maximus', 'Rome', 'Colosseum', 'Spaniard'], ['"Are you not entertained?"', 'Russell Crowe stars', 'Ridley Scott directed']],
            ['Avatar', ['Pandora', 'Na\'vi', 'Blue', 'Flying'], ['James Cameron sci-fi', 'Highest-grossing movie', '3D revolution']],
            ['Interstellar', ['Space', 'Black Hole', 'Cooper', 'TARS'], ['Scientific accuracy', 'Time dilation', 'Matthew McConaughey stars']],
            ['Parasite', ['Peach', 'Basement', 'Pizza Box', 'Rain'], ['First foreign Best Picture', 'South Korean social thriller', 'Bong Joon-ho']],
            ['Avengers', ['Stones', 'Snap', 'Thanos', 'Assemble'], ['Marvel culmination', 'Iron Man and Cap', 'Universal stakes']],
            ['Iron Man', ['Suit', 'Jarvis', 'Arc Reactor', 'Stark'], ['Started the MCU', 'Robert Downey Jr.', 'Tony Stark']],
            ['Spider Man', ['Web', 'Bite', 'Uncle Ben', 'New York'], ['"With great power..."', 'Peter Parker', 'Marvel wall-crawler']],
            ['Star Wars', ['Light Saber', 'Vader', 'Force', 'Death Star'], ['Space Opera', 'May the force be with you', 'George Lucas created it']],
            ['Jurassic Park', ['Dinosaurs', 'Island', 'DNA', 'Jeep'], ['Spielberg classic', 'T-Rex breakout', 'Science gone wrong']],
            ['The Matrix', ['Neo', 'Red Pill', 'Agent Smith', 'Phone Booth'], ['Sci-fi philosophy', 'Keanu Reeves', 'Simulation world']],
            ['Fight Club', ['Soap', 'First Rule', 'Project Mayhem', 'Tyler'], ['Edward Norton and Brad Pitt', 'Do not talk about it', 'David Fincher']],
            ['Se7en', ['Box', 'Sins', 'Rainy City', 'Detective'], ['Brad Pitt and Morgan Freeman', 'The seven deadly sins', 'David Fincher thriller']],
            ['Braveheart', ['Freedom', 'Scotland', 'Blue Face', 'Wallace'], ['Mel Gibson stars/directed', 'Scottish independence', 'William Wallace']],
            ['Scarface', ['Tony Montana', 'Cocaine', 'Chainsaw', 'Little Friend'], ['Al Pacino legendary role', '"Say hello to my..."', 'Brian De Palma']],
            ['Goodfellas', ['Mob', 'Wise Guy', 'Funny How?', 'Copacabana'], ['Scorsese crime masterpiece', 'Ray Liotta and Joe Pesci', 'True story of Henry Hill']],
            ['Toy Story', ['Woody', 'Buzz', 'Andy', 'Pizza Planet'], ['First CGI movie', 'Pixar\'s debut', 'Toys come to life']],
            ['Lion King', ['Simba', 'Pride Rock', 'Scar', 'Circle of Life'], ['Disney animation masterpiece', 'Hamlet in the Savanna', 'Music by Elton John']],
            ['Shrek', ['Ogre', 'Donkey', 'Swamp', 'Onions'], ['Dreamworks satire', 'Dreaming of a fairytale', 'Eddie Murphy as Donkey']],
            ['Frozen', ['Elsa', 'Let it Go', 'Snowman', 'Anna'], ['"Do you want to build a...?"', 'Disney modern classic', 'Idina Menzel singing']],
            ['Ratatouille', ['Rat', 'Chef', 'Paris', 'Anyone Can Cook'], ['Pixar cooking movie', 'Remy the rat', 'Culinary masterpiece']],
            ['Coco', ['Guitar', 'Dead', 'Grandma', 'Orange Bridge'], ['Day of the Dead', 'Mexican culture', 'Beautiful Pixar story']],
            ['Up', ['Balloons', 'House', 'Adventure', 'Wilderness'], ['Moving opening sequence', 'Flying house', 'Carl and Russell']],
            ['Wall E', ['Robot', 'Trash', 'Plant', 'Eve'], ['Nearly silent first half', 'Future of humanity', 'Pixar sci-fi']],
            ['Finding Nemo', ['Clownfish', 'Dory', 'Sydney', 'Shark'], ['"Just keep swimming"', 'Lost in the ocean', 'Marlin and Dory']],
            ['Jaws', ['Shark', 'Boat', 'Teeth', 'Island'], ['The original blockbuster', 'John Williams iconic theme', 'Man vs Shark']],
            ['Psycho', ['Shower', 'Motel', 'Mother', 'Knife'], ['Alfred Hitchcock masterpiece', 'Bates Motel', 'Famous shower scene']],
            ['Alien', ['Spaceship', 'Chestburster', 'Egg', 'Xenomorph'], ['Sci-fi horror', 'Ridley Scott', 'Sigourney Weaver as Ripley']],
            ['Predator', ['Hunter', 'Jungle', 'Chopper', 'Infrared'], ['Arnold Schwarzenegger', '"Get to the chopper!"', 'Intergalactic hunter']],
            ['Terminator', ['Cyborg', 'I\'ll Be Back', 'Judgment Day', 'Sarah'], ['James Cameron and Arnie', 'Robot from the future', 'John Connor']],
            ['Die Hard', ['Nakatomi', 'Christmas', 'Vent', 'McClane'], ['Bruce Willis action', 'Yippee-ki-yay', 'Is it a Christmas movie?']],
            ['Rambo', ['Knife', 'Jungle', 'Soldier', 'Forest'], ['Stallone character', 'Vietnam veteran', 'First Blood']],
            ['Rocky', ['Boxing', 'Steps', 'Eye of the Tiger', 'Philly'], ['The underdog story', 'Written by Stallone', 'Boxer from Philadelphia']],
            ['Top Gun', ['Maverick', 'Fighter Jet', 'Speed', 'Volleyball'], ['Tom Cruise classic', 'Danger Zone', 'F-14 Tomcats']],
            ['Mad Max', ['Desert', 'Cars', 'Fury', 'Water'], ['Post-apocalyptic action', 'Tom Hardy and Charlize Theron', 'Desert road warrior']],
            ['Dune', ['Arrakis', 'Worm', 'Spice', 'Paul'], ['Frank Herbert adaptation', 'Denis Villeneuve sci-fi', 'Sand planet']],
            ['Oppenheimer', ['Bomb', 'Atomic', 'Los Alamos', 'Physics'], ['Father of the Atomic Bomb', 'Christopher Nolan biopic', 'Cillian Murphy']],
            ['Barbie', ['Pink', 'Dreamhouse', 'Ken', 'Mattel'], ['Greta Gerwig directed', 'Margot Robbie', 'Social satire']],
            ['Tenet', ['Time', 'Inversion', 'Opera', 'Protagonist'], ['Inverted entropy', 'Time manipulation sci-fi', 'Nolan complexity']],
            ['Memento', ['Polaroid', 'Tattoo', 'Memory', 'Backward'], ['Short term memory loss', 'Told in reverse', 'Christopher Nolan breakout']],
            ['Whiplash', ['Drums', 'Tempo', 'Fletcher', 'Blood'], ['"Not quite my tempo"', 'Intense musical drama', 'J.K. Simmons Oscar role']],
            ['La La Land', ['Musical', 'Stars', 'Piano', 'Purple Sky'], ['Damien Chazelle musical', 'Emma Stone and Ryan Gosling', 'Hollywood story']],
            ['Moonlight', ['Beach', 'Blue', 'Chiron', 'Oscar'], ['Coming of age story', 'Beautiful cinematography', 'Best Picture winner']],
            ['Green Book', ['Travel', 'Piano', 'Chicken', 'Friendship'], ['True friendship story', 'Viggo Mortensen and Mahershala Ali', '60s deep south']],
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
            $hints = isset($item[2]) ? (array)$item[2] : [];

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

            foreach ($hints as $hintContent) {
                ChallengeHint::create([
                    'challenge_id' => $challenge->id,
                    'content' => $hintContent,
                ]);
            }
        }
    }
}
