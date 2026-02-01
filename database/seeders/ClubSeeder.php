<?php

namespace Database\Seeders;

use App\Models\Club;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clubs = [
            // Premier League (England)
            ['name' => 'Manchester United', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/7/7a/Manchester_United_FC_crest.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Manchester City', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/e/eb/Manchester_City_FC_badge.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Liverpool', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/0/0c/Liverpool_FC.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Chelsea', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/c/cc/Chelsea_FC.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Arsenal', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/5/53/Arsenal_FC.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Tottenham Hotspur', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/b/b4/Tottenham_Hotspur.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Newcastle United', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/5/56/Newcastle_United_Logo.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Aston Villa', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/f/f9/Aston_Villa_FC_crest_%282016%29.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'West Ham United', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/c/c2/West_Ham_United_FC_logo.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Brighton', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/f/fd/Brighton_%26_Hove_Albion_logo.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Wolverhampton', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/f/fc/Wolverhampton_Wanderers.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Crystal Palace', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/0/0c/Crystal_Palace_FC_logo.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Brentford', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/2/2a/Brentford_FC_crest.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Everton', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/7/7c/Everton_FC_logo.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Nottingham Forest', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/e/e5/Nottingham_Forest_F.C._logo.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Fulham', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/e/eb/Fulham_FC_%28shield%29.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Bournemouth', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/e/e5/AFC_Bournemouth_%282013%29.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Leeds United', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/5/54/Leeds_United_F.C._logo.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Leicester City', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/2/2d/Leicester_City_crest.svg', 'country' => 'England', 'league' => 'Premier League'],
            ['name' => 'Southampton', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/c/c9/FC_Southampton.svg', 'country' => 'England', 'league' => 'Premier League'],

            // La Liga (Spain)
            ['name' => 'Real Madrid', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/5/56/Real_Madrid_CF.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Barcelona', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/4/47/FC_Barcelona_%28crest%29.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Atletico Madrid', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/f/f4/Atletico_Madrid_2017_logo.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Sevilla', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/3/3b/Sevilla_FC_logo.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Real Sociedad', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/f/f1/Real_Sociedad_logo.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Real Betis', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/1/13/Real_betis_logo.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Villarreal', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/7/70/Villarreal_CF_logo.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Athletic Bilbao', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/9/98/Club_Athletic_Bilbao_logo.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Valencia', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/c/ce/Valenciacf.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Celta Vigo', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/1/12/RC_Celta_de_Vigo_logo.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Girona', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/9/90/For_article_Girona_FC.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Osasuna', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/d/db/CA_Osasuna_logo.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Getafe', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/4/46/Getafe_logo.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Rayo Vallecano', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/1/12/Rayo_Vallecano_logo.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Almeria', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/b/b5/UD_Almer%C3%ADa_logo.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Mallorca', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/e/e0/Rcd_mallorca.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Espanyol', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/d/d5/RCD_Espanyol_logo.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Cadiz', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/5/58/C%C3%A1diz_CF_logo.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Las Palmas', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/4/4c/UD_Las_Palmas_logo.svg', 'country' => 'Spain', 'league' => 'La Liga'],
            ['name' => 'Alaves', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/f/f8/Deportivo_Alav%C3%A9s_logo_%282020%29.svg', 'country' => 'Spain', 'league' => 'La Liga'],

            // Bundesliga (Germany)
            ['name' => 'Bayern Munich', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/1/1b/FC_Bayern_M%C3%BCnchen_logo_%282017%29.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'Borussia Dortmund', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/6/67/Borussia_Dortmund_logo.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'RB Leipzig', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/0/04/RB_Leipzig_2014_logo.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'Bayer Leverkusen', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/5/59/Bayer_04_Leverkusen_logo.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'Eintracht Frankfurt', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/0/04/Eintracht_Frankfurt_Logo.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'Wolfsburg', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/c/ce/VfL_Wolfsburg_Logo.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'Borussia Monchengladbach', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/8/81/Borussia_M%C3%B6nchengladbach_logo.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'Freiburg', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/6/6d/SC_Freiburg_logo.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'Hoffenheim', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/e/e7/Logo_TSG_Hoffenheim.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'Mainz', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/9/9e/Logo_Mainz_05.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'Union Berlin', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/4/44/1._FC_Union_Berlin_Logo.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'Augsburg', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/c/c5/FC_Augsburg_logo.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'Werder Bremen', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/b/be/SV-Werder-Bremen-Logo.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'VfB Stuttgart', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/e/eb/VfB_Stuttgart_1893_Logo.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'Koln', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/5/53/FC_Cologne_logo.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'Hertha Berlin', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/8/81/Hertha_BSC_Logo_2012.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'Schalke 04', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/6/6d/FC_Schalke_04_Logo.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],
            ['name' => 'Bochum', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/7/72/VfL_Bochum_logo.svg', 'country' => 'Germany', 'league' => 'Bundesliga'],

            // Serie A (Italy)
            ['name' => 'Juventus', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/b/bc/Juventus_FC_2017_icon_%28black%29.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Inter Milan', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/0/05/FC_Internazionale_Milano_2021.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'AC Milan', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/d/d0/Logo_of_AC_Milan.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Napoli', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/2/2d/SSC_Neapel.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Roma', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/f/f7/AS_Roma_logo_%282017%29.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Lazio', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/c/ce/S.S._Lazio_badge.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Atalanta', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/6/66/AtalantaBC.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Fiorentina', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/b/ba/ACF_Fiorentina_2022.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Torino', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/2/2e/Torino_FC_Logo.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Bologna', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/5/5b/Bologna_FC_1909_logo.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Sassuolo', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/a/a5/US_Sassuolo_Calcio_logo.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Udinese', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/c/ce/Udinese_Calcio_logo.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Sampdoria', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/d/d2/U.C._Sampdoria_logo.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Empoli', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/b/b5/Empoli_FC.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Hellas Verona', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/9/92/Hellas_Verona_FC_logo_%282020%29.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Lecce', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/1/17/US_Lecce_logo.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Monza', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/6/65/AC_Monza_logo.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Cagliari', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/6/61/Cagliari_Calcio_1920.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Genoa', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/3/34/Genoa_CFC_logo.svg', 'country' => 'Italy', 'league' => 'Serie A'],
            ['name' => 'Salernitana', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/1/18/US_Salernitana_1919_logo.svg', 'country' => 'Italy', 'league' => 'Serie A'],

            // Ligue 1 (France)
            ['name' => 'Paris Saint-Germain', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/a/a7/Paris_Saint-Germain_F.C..svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Marseille', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/d/d8/Olympique_Marseille_logo.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Monaco', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/b/ba/AS_Monaco_FC.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Lyon', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/a/a7/Olympique_Lyonnais.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Lille', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/6/62/Lille_OSC_2018_logo.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Nice', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/2/27/OGC_Nice_logo.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Lens', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/4/4b/Racing_Club_de_Lens_logo.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Rennes', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/9/9e/Stade_Rennais_FC.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Strasbourg', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/8/80/Racing_Club_de_Strasbourg_logo.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Nantes', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/4/4f/FC_Nantes_2019_logo.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Montpellier', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/a/a8/Montpellier_HSC_logo.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Reims', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/1/19/Stade_de_Reims_logo.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Brest', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/e/e9/Stade_Brestois_29_logo.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Toulouse', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/9/98/Toulouse_FC_2018_logo.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Lorient', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/b/bb/FC_Lorient_logo.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Clermont', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/b/ba/Clermont_Foot_63_logo.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Auxerre', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/3/34/AJ_Auxerre_logo.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Troyes', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/d/d5/ESTAC_Troyes_logo.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Angers', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/c/c0/Angers_SCO_logo.svg', 'country' => 'France', 'league' => 'Ligue 1'],
            ['name' => 'Ajaccio', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/c/c4/AC_Ajaccio_logo.svg', 'country' => 'France', 'league' => 'Ligue 1'],

            // Additional Notable Clubs (Other leagues - for career paths)
            ['name' => 'Al-Nassr', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/a/a2/Al-Nassr_FC_logo.svg', 'country' => 'Saudi Arabia', 'league' => 'Saudi Pro League'],
            ['name' => 'Al-Hilal', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/e/e9/Al-Hilal_FC_logo.svg', 'country' => 'Saudi Arabia', 'league' => 'Saudi Pro League'],
            ['name' => 'Al-Ittihad', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/2/27/Al-Ittihad_Club_Logo.svg', 'country' => 'Saudi Arabia', 'league' => 'Saudi Pro League'],
            ['name' => 'Sporting CP', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/3/3e/Sporting_Clube_de_Portugal_%28Logo%29.svg', 'country' => 'Portugal', 'league' => 'Primeira Liga'],
            ['name' => 'Porto', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/f/f1/FC_Porto.svg', 'country' => 'Portugal', 'league' => 'Primeira Liga'],
            ['name' => 'Benfica', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/a/a2/SL_Benfica_logo.svg', 'country' => 'Portugal', 'league' => 'Primeira Liga'],
            ['name' => 'Ajax', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/7/79/Ajax_Amsterdam.svg', 'country' => 'Netherlands', 'league' => 'Eredivisie'],
            ['name' => 'PSV Eindhoven', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/0/05/PSV_Eindhoven.svg', 'country' => 'Netherlands', 'league' => 'Eredivisie'],
            ['name' => 'Feyenoord', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/5/55/Feyenoord_logo.svg', 'country' => 'Netherlands', 'league' => 'Eredivisie'],
            ['name' => 'Inter Miami', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/8/8e/Inter_Miami_CF_logo.svg', 'country' => 'USA', 'league' => 'MLS'],
            ['name' => 'LA Galaxy', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/7/70/Los_Angeles_Galaxy_logo.svg', 'country' => 'USA', 'league' => 'MLS'],
            ['name' => 'New York Red Bulls', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/8/86/New_York_Red_Bulls_logo.svg', 'country' => 'USA', 'league' => 'MLS'],
            ['name' => 'Celtic', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/3/35/Celtic_FC.svg', 'country' => 'Scotland', 'league' => 'Scottish Premiership'],
            ['name' => 'Rangers', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/4/43/Rangers_FC.svg', 'country' => 'Scotland', 'league' => 'Scottish Premiership'],
            ['name' => 'Galatasaray', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/f/f6/Galatasaray_Sports_Club_Logo.svg', 'country' => 'Turkey', 'league' => 'Super Lig'],
            ['name' => 'Fenerbahce', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/5/5e/Fenerbah%C3%A7e_SK.svg', 'country' => 'Turkey', 'league' => 'Super Lig'],
            ['name' => 'Besiktas', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/2/20/Logo_of_Be%C5%9Fikta%C5%9F_JK.svg', 'country' => 'Turkey', 'league' => 'Super Lig'],
            ['name' => 'Flamengo', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/2/2e/Flamengo_braz_logo.svg', 'country' => 'Brazil', 'league' => 'Brasileirao'],
            ['name' => 'Santos', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/1/15/Santos_Logo.png', 'country' => 'Brazil', 'league' => 'Brasileirao'],
            ['name' => 'Palmeiras', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/1/10/Palmeiras_logo.svg', 'country' => 'Brazil', 'league' => 'Brasileirao'],
            ['name' => 'Corinthians', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/9/9a/Sport_Club_Corinthians_Paulista_crest.svg', 'country' => 'Brazil', 'league' => 'Brasileirao'],
            ['name' => 'Sao Paulo', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/6/6f/Brasao_do_Sao_Paulo_Futebol_Clube.svg', 'country' => 'Brazil', 'league' => 'Brasileirao'],
            ['name' => 'Boca Juniors', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/4/41/CABJ70.png', 'country' => 'Argentina', 'league' => 'Primera Division'],
            ['name' => 'River Plate', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/a/ac/Escudo_del_C_A_River_Plate.svg', 'country' => 'Argentina', 'league' => 'Primera Division'],
            ['name' => 'Newell\'s Old Boys', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/1/13/Newells_old_boys_logo.svg', 'country' => 'Argentina', 'league' => 'Primera Division'],
            ['name' => 'Rosario Central', 'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/9/92/Rosario_central_logo.svg', 'country' => 'Argentina', 'league' => 'Primera Division'],
        ];

        foreach ($clubs as $club) {
            Club::create($club);
        }
    }
}
