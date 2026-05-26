<?php

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\Game;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class CategoryCrusherSeeder extends Seeder
{
    public function run(): void
    {
        $game = Game::where('slug', 'category-crusher')->first();
        if (!$game) return;

        $football = Genre::where('slug', 'football')->first();
        $actors = Genre::where('slug', 'actors')->first();
        $movies = Genre::where('slug', 'movies')->first();

        if (!$football || !$actors || !$movies) return;

        // 1. Football (50)
        $footballChallenges = [
            [['Lamine Yamal', 'Gavi', 'Pedri', 'Ansu Fati'], 'Youth graduates from a famous academy', 'La Masia', 'medium'],
            [['Inter Miami', 'Bayern Munich', 'Aston Villa', 'AC Milan'], 'Check their starting goalkeepers', 'World Cup Winners', 'hard'],
            [['Arsenal 03/04', 'Juventus 11/12', 'Bayer Leverkusen 23/24'], 'Historical league campaigns', 'Invincibles', 'hard'],
            [['Chelsea', 'Benfica', 'Real Madrid', 'Manchester United'], 'Former clubs of a Portuguese manager', 'Mourinho Clubs', 'medium'],
            [['Messi', 'Neymar', 'Luis Suarez'], 'Famous South American attacking trio at Barcelona', 'MSN', 'easy'],
            [['Bale', 'Benzema', 'Cristiano Ronaldo'], 'Legendary Real Madrid attacking trio', 'BBC', 'easy'],
            [['Xavi', 'Iniesta', 'Busquets'], 'Iconic Spanish midfield trio', 'Barca Midfield', 'easy'],
            [['Casemiro', 'Kroos', 'Modric'], 'Three-peat Champions League midfield core', 'KCM', 'easy'],
            [['Mane', 'Firmino', 'Salah'], 'Jurgen Klopp\'s title-winning frontline', 'Liverpool Trio', 'easy'],
            [['Rooney', 'Tevez', 'Ronaldo'], 'Sir Alex Ferguson\'s 2008 Champions League attack', 'United Holy Trinity', 'medium'],
            [['Henry', 'Bergkamp', 'Pires'], 'Arsene Wenger\'s attacking masterpieces', 'Arsenal Legends', 'medium'],
            [['Lewandowski', 'Muller', 'Gnabry'], 'Hansi Flick\'s sextuple-winning attack', 'Bayern Attack', 'medium'],
            [['Mbappe', 'Cavani', 'Neymar'], 'Record-breaking Ligue 1 attacking force', 'MCN', 'easy'],
            [['Haaland', 'Foden', 'De Bruyne'], 'Pep Guardiola\'s treble-winning spearheads', 'City Treble Core', 'easy'],
            [['Pele', 'Garrincha', 'Vava'], 'Brazil\'s 1958 & 1962 World Cup heroes', 'Brazil Legends', 'hard'],
            [['Maradona', 'Careca', 'Giordano'], 'Napoli\'s legendary late 80s attacking trio', 'Ma-Gi-Ca', 'hard'],
            [['Van Basten', 'Gullit', 'Rijkaard'], 'AC Milan\'s legendary Dutch trio', 'Dutch Trio', 'medium'],
            [['Ronaldo Nazario', 'Ronaldinho', 'Rivaldo'], 'Brazil\'s 2002 World Cup winning attack', 'Three Rs', 'medium'],
            [['Kaká', 'Shevchenko', 'Crespo'], 'Carlo Ancelotti\'s 2005 Milan attack', 'Milan 2005 Attack', 'medium'],
            [['Del Piero', 'Trezeguet', 'Nedved'], 'Juventus 2000s loyal icons', 'Juve Legends', 'medium'],
            [['Totti', 'Batistuta', 'Montella'], 'Roma\'s 2000/01 Scudetto winners', 'Roma Scudetto Attack', 'hard'],
            [['Gerrard', 'Lampard', 'Scholes'], 'England\'s golden generation midfield dilemma', 'Golden Generation Midfield', 'easy'],
            [['Pirlo', 'Gattuso', 'Seedorf'], 'Milan\'s diamond midfield under Ancelotti', 'Milan Diamond', 'medium'],
            [['Makelele', 'Vieira', 'Keane'], 'Premier League legendary defensive midfielders', 'Elite DMs', 'medium'],
            [['Buffon', 'Casillas', 'Neuer'], 'Dominant 21st century goalkeepers', 'Legendary Keepers', 'easy'],
            [['Maldini', 'Baresi', 'Costacurta'], 'AC Milan\'s impenetrable defensive wall', 'Milan Defense', 'medium'],
            [['Ramos', 'Pepe', 'Varane'], 'Real Madrid\'s 2010s defensive backbone', 'Madrid Defense', 'medium'],
            [['Pique', 'Puyol', 'Mascherano'], 'Pep Guardiola\'s defensive anchors', 'Barca Defense', 'medium'],
            [['Ferdinand', 'Vidic', 'Evra'], 'Sir Alex Ferguson\'s peak defensive line', 'United Defense', 'medium'],
            [['Terry', 'Carvalho', 'Cech'], 'Jose Mourinho\'s 15-goal conceded defense', 'Chelsea 04/05 Defense', 'medium'],
            [['Chiellini', 'Bonucci', 'Barzagli'], 'Juventus and Italy\'s famous defensive trio', 'BBC Defense', 'medium'],
            [['Kompany', 'Laporte', 'Stones'], 'Pep Guardiola\'s centurion defenders', 'City Centurions Defense', 'medium'],
            [['Van Dijk', 'Matip', 'Robertson'], 'Jurgen Klopp\'s Champions League winning defense', 'Liverpool 2019 Defense', 'medium'],
            [['Zanetti', 'Samuel', 'Lucio'], 'Jose Mourinho\'s 2010 treble winning defense', 'Inter Treble Defense', 'hard'],
            [['Cafu', 'Roberto Carlos', 'Marcelo'], 'Legendary attacking Brazilian fullbacks', 'Brazilian Fullbacks', 'easy'],
            [['Dani Alves', 'Maicon', 'Zambrotta'], 'Elite 2000s right-backs', 'Elite Right-Backs', 'medium'],
            [['Lahm', 'Cole', 'Evra'], 'Consistent 2000s/2010s fullbacks', 'Elite Fullbacks', 'medium'],
            [['Courtois', 'Alisson', 'Ederson'], 'Modern elite ball-playing & shot-stopping keepers', 'Modern Keepers', 'easy'],
            [['Kahn', 'Schmeichel', 'Van der Sar'], 'Fearless 90s/2000s goalkeepers', '90s Keepers', 'medium'],
            [['Yashin', 'Banks', 'Zoff'], '20th century goalkeeping pioneers', 'Classic Keepers', 'hard'],
            [['Guardiola', 'Cruyff', 'Michels'], 'Pioneers of Total Football and positional play', 'Total Football Managers', 'medium'],
            [['Ferguson', 'Wenger', 'Mourinho'], 'Premier League\'s most iconic managerial rivalries', 'Iconic PL Managers', 'easy'],
            [['Ancelotti', 'Zidane', 'Paisley'], 'Managers with 3+ Champions League titles', 'UCL Masterminds', 'medium'],
            [['Klopp', 'Simeone', 'Conte'], 'High-energy, passionate touchline managers', 'Passionate Managers', 'easy'],
            [['Haaland', 'Mbappe', 'Bellingham'], 'The next generation of Ballon d\'Or contenders', 'New Gen Stars', 'easy'],
            [['Musiala', 'Wirtz', 'Saka'], 'Elite young attacking midfielders/wingers', 'Young Ballers', 'medium'],
            [['Rodri', 'Rice', 'Tchouameni'], 'Modern world-class defensive midfielders', 'Modern DMs', 'medium'],
            [['Saliba', 'Dias', 'Bastoni'], 'Next generation elite center-backs', 'Modern CBs', 'medium'],
            [['Donnarumma', 'Maignan', 'Diogo Costa'], 'Next generation world-class goalkeepers', 'Modern Keepers', 'medium'],
            [['Endrick', 'Guler', 'Yamal'], 'Teenage sensations at Spanish giants', 'El Clasico Wonderkids', 'easy'],
        ];

        // 2. Actors (50)
        $actorsChallenges = [
            [['Robert De Niro', 'Al Pacino', 'Joe Pesci'], 'Legends of gangster and mob cinema', 'Mob Movie Icons', 'easy'],
            [['Brad Pitt', 'George Clooney', 'Matt Damon'], 'Members of Danny Ocean\'s heist crew', 'Ocean\'s Eleven Stars', 'easy'],
            [['Leonardo DiCaprio', 'Tom Hardy', 'Cillian Murphy'], 'Stars of Christopher Nolan\'s Inception', 'Inception Cast', 'medium'],
            [['Tom Hanks', 'Tim Allen', 'Joan Cusack'], 'Iconic voice actors from Toy Story', 'Toy Story Voices', 'easy'],
            [['Robert Downey Jr.', 'Chris Evans', 'Chris Hemsworth'], 'The founding members of the MCU Avengers', 'Original Avengers', 'easy'],
            [['Christian Bale', 'Michael Caine', 'Morgan Freeman'], 'Core cast of The Dark Knight trilogy', 'Dark Knight Trilogy Cast', 'easy'],
            [['Harrison Ford', 'Mark Hamill', 'Carrie Fisher'], 'The legendary original Star Wars trio', 'Original Star Wars Trio', 'easy'],
            [['Elijah Wood', 'Viggo Mortensen', 'Ian McKellen'], 'Members of the Fellowship of the Ring', 'Lord of the Rings Cast', 'easy'],
            [['Daniel Radcliffe', 'Emma Watson', 'Rupert Grint'], 'The famous Hogwarts golden trio', 'Harry Potter Trio', 'easy'],
            [['Keanu Reeves', 'Laurence Fishburne', 'Carrie-Anne Moss'], 'The core resistance fighters in The Matrix', 'Matrix Cast', 'easy'],
            [['Tom Cruise', 'Miles Teller', 'Val Kilmer'], 'Elite naval aviators in Top Gun cinema', 'Top Gun Cast', 'easy'],
            [['Johnny Depp', 'Orlando Bloom', 'Keira Knightley'], 'Stars of Pirates of the Caribbean', 'Pirates Cast', 'easy'],
            [['Matthew McConaughey', 'Woody Harrelson', 'Jessica Chastain'], 'Collaborators in Christopher Nolan/HBO prestige projects', 'Interstellar & True Detective Stars', 'hard'],
            [['Ryan Gosling', 'Emma Stone', 'John Legend'], 'Cast of Damien Chazelle\'s La La Land', 'La La Land Cast', 'medium'],
            [['Margot Robbie', 'Ryan Gosling', 'Simu Liu'], 'Stars of Greta Gerwig\'s Barbie', 'Barbie Cast', 'easy'],
            [['Joaquin Phoenix', 'Robert De Niro', 'Zazie Beetz'], 'Key figures in Todd Phillips\' Joker', 'Joker Cast', 'medium'],
            [['Samuel L. Jackson', 'John Travolta', 'Uma Thurman'], 'Stars of Quentin Tarantino\'s Pulp Fiction', 'Pulp Fiction Cast', 'easy'],
            [['Christoph Waltz', 'Brad Pitt', 'Michael Fassbender'], 'Stars of Inglourious Basterds', 'Inglourious Basterds Cast', 'medium'],
            [['Leonardo DiCaprio', 'Jonah Hill', 'Margot Robbie'], 'The high-rolling cast of The Wolf of Wall Street', 'Wolf of Wall Street Cast', 'easy'],
            [['Al Pacino', 'Michelle Pfeiffer', 'Steven Bauer'], 'Stars of Brian De Palma\'s Scarface', 'Scarface Cast', 'medium'],
            [['Marlon Brando', 'Al Pacino', 'James Caan'], 'The Corleone family key members', 'The Godfather Cast', 'easy'],
            [['Jack Nicholson', 'Shelley Duvall', 'Danny Lloyd'], 'The Torrance family in The Shining', 'The Shining Cast', 'medium'],
            [['Anthony Hopkins', 'Jodie Foster', 'Scott Glenn'], 'Key actors in The Silence of the Lambs', 'Silence of the Lambs Cast', 'medium'],
            [['Morgan Freeman', 'Tim Robbins', 'Bob Gunton'], 'Key figures at Shawshank State Penitentiary', 'Shawshank Redemption Cast', 'easy'],
            [['Russell Crowe', 'Joaquin Phoenix', 'Connie Nielsen'], 'Stars of Ridley Scott\'s Gladiator', 'Gladiator Cast', 'easy'],
            [['Liam Neeson', 'Ralph Fiennes', 'Ben Kingsley'], 'Lead actors in Schindler\'s List', 'Schindler\'s List Cast', 'hard'],
            [['Tom Hanks', 'Robin Wright', 'Gary Sinise'], 'Key figures in Forrest Gump\'s life journey', 'Forrest Gump Cast', 'easy'],
            [['Bruce Willis', 'Alan Rickman', 'Bonnie Bedelia'], 'Figures trapped in Nakatomi Plaza', 'Die Hard Cast', 'easy'],
            [['Arnold Schwarzenegger', 'Linda Hamilton', 'Michael Biehn'], 'The time-traveling cast of The Terminator', 'Terminator Cast', 'easy'],
            [['Sigourney Weaver', 'Tom Skerritt', 'John Hurt'], 'Crew members of the USCSS Nostromo', 'Alien Cast', 'medium'],
            [['Michael J. Fox', 'Christopher Lloyd', 'Lea Thompson'], 'Time travelers from Hill Valley', 'Back to the Future Cast', 'easy'],
            [['Bill Murray', 'Dan Aykroyd', 'Harold Ramis'], 'New York\'s famous paranormal investigators', 'Ghostbusters Cast', 'easy'],
            [['Eddie Murphy', 'Judge Reinhold', 'John Ashton'], 'Detectives in Beverly Hills Cop', 'Beverly Hills Cop Cast', 'medium'],
            [['Will Smith', 'Tommy Lee Jones', 'Rip Torn'], 'Agents protecting Earth from alien scum', 'Men in Black Cast', 'easy'],
            [['Jim Carrey', 'Jeff Daniels', 'Lauren Holly'], 'The hilarious cast of Dumb and Dumber', 'Dumb and Dumber Cast', 'easy'],
            [['Mike Myers', 'Cameron Diaz', 'Eddie Murphy'], 'Voices behind the kingdom of Far Far Away', 'Shrek Cast', 'easy'],
            [['Ben Stiller', 'Owen Wilson', 'Will Ferrell'], 'Icons of 2000s Frat Pack comedy', 'Frat Pack Icons', 'easy'],
            [['Steve Carell', 'Paul Rudd', 'Seth Rogen'], 'Judd Apatow comedy regulars', 'Apatow Comedy Stars', 'medium'],
            [['Adam Sandler', 'Kevin James', 'Chris Rock'], 'Stars of Grown Ups and Happy Madison films', 'Happy Madison Stars', 'easy'],
            [['Jonah Hill', 'Michael Cera', 'Christopher Mintz-Plasse'], 'High school seniors trying to buy alcohol', 'Superbad Cast', 'easy'],
            [['Zach Galifianakis', 'Bradley Cooper', 'Ed Helms'], 'The famous Wolfpack from Las Vegas', 'The Hangover Cast', 'easy'],
            [['Simon Pegg', 'Nick Frost', 'Martin Freeman'], 'Stars of Edgar Wright\'s Cornetto Trilogy', 'Cornetto Trilogy Cast', 'medium'],
            [['Daniel Craig', 'Javier Bardem', 'Judi Dench'], 'Key figures in Skyfall', 'Skyfall Cast', 'medium'],
            [['Hugh Jackman', 'Patrick Stewart', 'Ian McKellen'], 'The original X-Men cinematic leaders', 'Original X-Men Cast', 'easy'],
            [['Tobey Maguire', 'Kirsten Dunst', 'Willem Dafoe'], 'Stars of Sam Raimi\'s Spider-Man', 'Raimi Spider-Man Cast', 'easy'],
            [['Andrew Garfield', 'Emma Stone', 'Jamie Foxx'], 'Stars of The Amazing Spider-Man series', 'Amazing Spider-Man Cast', 'medium'],
            [['Tom Holland', 'Zendaya', 'Jacob Batalon'], 'The MCU Spider-Man high school trio', 'MCU Spider-Man Trio', 'easy'],
            [['Robert Pattinson', 'Zoë Kravitz', 'Paul Dano'], 'Stars of Matt Reeves\' The Batman', 'The Batman Cast', 'easy'],
            [['Cillian Murphy', 'Emily Blunt', 'Robert Downey Jr.'], 'Key historical figures in Oppenheimer', 'Oppenheimer Cast', 'easy'],
            [['Pedro Pascal', 'Bella Ramsey', 'Gabriel Luna'], 'Survivors in The Last of Us adaptation', 'The Last of Us Cast', 'easy'],
        ];

        // 3. Movies (50)
        $moviesChallenges = [
            [['Goodfellas', 'The Irishman', 'Casino', 'The Wolf of Wall Street'], 'Directed by a legendary Italian-American filmmaker', 'Martin Scorsese Movies', 'easy'],
            [['Pulp Fiction', 'Kill Bill', 'Django Unchained', 'Inglourious Basterds'], 'Known for sharp dialogue and stylized violence', 'Quentin Tarantino Movies', 'easy'],
            [['Inception', 'Interstellar', 'Dunkirk', 'Tenet'], 'Mind-bending blockbusters exploring time and space', 'Christopher Nolan Movies', 'easy'],
            [['Schindler\'s List', 'Saving Private Ryan', 'Jurassic Park', 'Jaws'], 'Masterpieces by Hollywood\'s most famous director', 'Steven Spielberg Movies', 'easy'],
            [['Avatar', 'Titanic', 'The Terminator', 'Aliens'], 'Box office record-breakers with groundbreaking VFX', 'James Cameron Movies', 'easy'],
            [['The Social Network', 'Gone Girl', 'Fight Club', 'Se7en'], 'Dark, psychological thrillers with precise editing', 'David Fincher Movies', 'medium'],
            [['The Grand Budapest Hotel', 'Fantastic Mr. Fox', 'Moonrise Kingdom', 'Rushmore'], 'Symmetrical compositions and quirky color palettes', 'Wes Anderson Movies', 'easy'],
            [['Blade Runner 2049', 'Dune', 'Arrival', 'Sicario'], 'Atmospheric modern sci-fi and thriller masterpieces', 'Denis Villeneuve Movies', 'medium'],
            [['Spirited Away', 'My Neighbor Totoro', 'Princess Mononoke', 'Howl\'s Moving Castle'], 'Legendary Japanese animation classics', 'Studio Ghibli Movies', 'easy'],
            [['Toy Story', 'Finding Nemo', 'The Incredibles', 'Inside Out'], 'Heartwarming and innovative 3D animated classics', 'Pixar Masterpieces', 'easy'],
            [['The Lion King', 'Aladdin', 'Beauty and the Beast', 'The Little Mermaid'], 'Classics from the Disney Renaissance era', 'Disney Renaissance', 'easy'],
            [['Shrek', 'Kung Fu Panda', 'How to Train Your Dragon', 'Madagascar'], 'Rival animation studio\'s biggest franchises', 'DreamWorks Animation', 'easy'],
            [['Despicable Me', 'Minions', 'The Secret Life of Pets', 'Sing'], 'Franchises known for yellow henchmen and catchy pop songs', 'Illumination Franchises', 'easy'],
            [['The Avengers', 'Guardians of the Galaxy', 'Black Panther', 'Iron Man'], 'Billion-dollar comic book shared universe films', 'MCU Blockbusters', 'easy'],
            [['The Dark Knight', 'Man of Steel', 'Wonder Woman', 'Aquaman'], 'DC Comics flagship cinematic adaptations', 'DC Cinematic Movies', 'easy'],
            [['Harry Potter', 'Lord of the Rings', 'The Chronicles of Narnia', 'Percy Jackson'], 'Epic fantasy novel cinematic adaptations', 'Fantasy Book Adaptations', 'easy'],
            [['The Hunger Games', 'Divergent', 'The Maze Runner', 'Twilight'], '2010s dystopian and supernatural YA adaptations', 'Young Adult Adaptations', 'easy'],
            [['Star Wars', 'Star Trek', 'Dune', 'The Fifth Element'], 'Epic space operas spanning entire galaxies', 'Space Operas', 'easy'],
            [['The Matrix', 'Blade Runner', 'Ghost in the Shell', 'Akira'], 'Dystopian futures exploring AI and virtual realities', 'Cyberpunk Classics', 'medium'],
            [['Alien', 'The Thing', 'Event Horizon', 'Annihilation'], 'Terrifying encounters with unknown cosmic lifeforms', 'Sci-Fi Horror', 'hard'],
            [['Halloween', 'A Nightmare on Elm Street', 'Friday the 13th', 'Scream'], 'Icons of masked killers and final girls', 'Slasher Classics', 'easy'],
            [['The Conjuring', 'Insidious', 'Sinister', 'Hereditary'], 'Modern terrifying supernatural and demon thrillers', 'Modern Supernatural Horror', 'medium'],
            [['Get Out', 'Us', 'Nope'], 'Jordan Peele\'s thought-provoking social thrillers', 'Jordan Peele Horror', 'easy'],
            [['The Exorcist', 'The Omen', 'Rosemary\'s Baby', 'The Shining'], 'Legendary 1970s/80s chilling horror masterpieces', 'Classic Psychological Horror', 'hard'],
            [['Die Hard', 'Lethal Weapon', 'Speed', 'The Rock'], 'High-octane 80s/90s explosive blockbusters', 'Classic Action Movies', 'easy'],
            [['John Wick', 'Mad Max: Fury Road', 'The Raid', 'Mission: Impossible - Fallout'], 'Masterpieces of modern stunt choreography', 'Modern Action Masterpieces', 'easy'],
            [['The Bourne Identity', 'Casino Royale', 'Kingsman', 'Mission: Impossible'], 'Elite secret agents saving the world', 'Spy Thrillers', 'easy'],
            [['Raiders of the Lost Ark', 'The Mummy', 'National Treasure', 'Tomb Raider'], 'Globetrotting archeological action adventures', 'Treasure Hunt Adventures', 'easy'],
            [['Gladiator', 'Braveheart', 'Troy', 'Kingdom of Heaven'], 'Epic historical battles and sword-and-sandal cinema', 'Historical Epics', 'medium'],
            [['The Godfather', 'Scarface', 'The Untouchables', 'Carlito\'s Way'], 'Dramatic rises and falls of organized crime bosses', 'Classic Crime Dramas', 'easy'],
            [['Heat', 'The Town', 'Inside Man', 'Baby Driver'], 'High-stakes bank robberies and intense getaways', 'Heist Movies', 'medium'],
            [['The Silence of the Lambs', 'Prisoners', 'Zodiac', 'Mystic River'], 'Dark investigations into serial killers and abductions', 'Investigative Thrillers', 'medium'],
            [['Forrest Gump', 'The Shawshank Redemption', 'The Green Mile', 'Good Will Hunting'], 'Uplifting and emotional 90s Oscar-winning dramas', '90s Prestige Dramas', 'easy'],
            [['12 Angry Men', 'To Kill a Mockingbird', 'A Few Good Men', 'The Trial of the Chicago 7'], 'Tense legal battles inside the courtroom', 'Courtroom Dramas', 'medium'],
            [['Rocky', 'Raging Bull', 'Million Dollar Baby', 'Creed'], 'Inspirational boxing dramas exploring grit and glory', 'Boxing Dramas', 'easy'],
            [['Remember the Titans', 'Moneyball', 'Coach Carter', 'Any Given Sunday'], 'Behind the scenes of management and team glory', 'Sports Dramas', 'medium'],
            [['La La Land', 'The Greatest Showman', 'Chicago', 'Moulin Rouge!'], 'Spectacular modern musical and theatrical productions', 'Modern Musicals', 'easy'],
            [['Singin\' in the Rain', 'The Sound of Music', 'West Side Story', 'The Wizard of Oz'], 'Legendary golden age Hollywood musical classics', 'Classic Musicals', 'easy'],
            [['When Harry Met Sally...', 'Pretty Woman', 'Notting Hill', 'Sleepless in Seattle'], 'Iconic 80s/90s romantic comedy staples', 'Classic Rom-Coms', 'easy'],
            [['The Palm Beach Story', 'It Happened One Night', 'Bringing Up Baby', 'His Girl Friday'], 'Fast-talking 1930s/40s screwball comedies', 'Screwball Comedies', 'hard'],
            [['Superbad', 'The Hangover', 'Step Brothers', 'Anchorman'], 'Hilarious, raunchy 2000s comedy classics', '2000s Comedy Classics', 'easy'],
            [['Airplane!', 'The Naked Gun', 'Blazing Saddles', 'Spaceballs'], 'Absurd, slapstick spoof comedy masterpieces', 'Spoof Comedies', 'medium'],
            [['Shaun of the Dead', 'Hot Fuzz', 'The World\'s End'], 'Edgar Wright and Simon Pegg\'s famous comedic trilogy', 'Cornetto Trilogy', 'easy'],
            [['Knives Out', 'Glass Onion', 'Murder on the Orient Express', 'Death on the Nile'], 'Whodunit murder mysteries with eccentric detectives', 'Modern Whodunits', 'easy'],
            [['Clue', 'Gosford Park', 'Sleuth', 'Deathtrap'], 'Classic theatrical and twisted murder mysteries', 'Classic Whodunits', 'hard'],
            [['Parasite', 'Oldboy', 'Memories of Murder', 'The Handmaiden'], 'Masterpieces of South Korean cinema', 'Korean Masterpieces', 'medium'],
            [['Crouching Tiger, Hidden Dragon', 'Hero', 'House of Flying Daggers', 'Ip Man'], 'Breathtaking martial arts and Wuxia epics', 'Martial Arts Epics', 'medium'],
            [['Pan\'s Labyrinth', 'The Orphanage', 'The Devil\'s Backbone', 'REC'], 'Chilling Spanish-language supernatural thrillers', 'Spanish Horror Dramas', 'hard'],
            [['City of God', 'Elite Squad', 'Amores Perros', 'Y Tu Mamá También'], 'Gritty, acclaimed Latin American cinema masterpieces', 'Latin American Classics', 'hard'],
            [['Amélie', 'The Intouchables', 'La Haine', 'Portrait of a Lady on Fire'], 'Celebrated French cinematic masterpieces', 'French Masterpieces', 'medium'],
        ];

        $all = [
            [$football->id, $footballChallenges],
            [$actors->id, $actorsChallenges],
            [$movies->id, $moviesChallenges],
        ];

        foreach ($all as [$genreId, $list]) {
            foreach ($list as [$items, $hint, $answer, $diff]) {
                Challenge::updateOrCreate(
                    [
                        'game_id' => $game->id,
                        'genre_id' => $genreId,
                        'language' => 'en',
                        'answer' => $answer
                    ],
                    [
                        'stimulus_type' => 'text',
                        'stimulus_data' => [
                            'items' => $items,
                            'hint' => $hint
                        ],
                        'difficulty' => $diff,
                        'answer_type' => 'term',
                        'is_active' => true
                    ]
                );
            }
        }
    }
}
