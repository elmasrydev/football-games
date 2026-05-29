<?php

namespace Database\Seeders;

use App\Models\GameItem;
use App\Models\MazadQuestion;
use Illuminate\Database\Seeder;

class MazadQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            // ── Football ──
            [
                'text' => 'Football players who played for both Al Ahly and Zamalek',
                'text_ar' => 'لاعبين كرة قدم لعبوا للنادي الأهلي والزمالك',
                'category' => 'football',
                'difficulty' => 'medium',

                'accepted_answers' => [
                    // Ahmed Sayed Zizo
                    ['أحمد سيد زيزو', 'zizo', ['احمد سيد زيزو', 'زيزو', 'أحمد مصطفى محمد سيد']],

                    // Achraf Bencharki
                    ['أشرف بن شرقي', 'achraf bencharki', ['اشرف بن شرقي', 'بن شرقي', 'بنشرقي']],

                    // Hossam Hassan
                    ['حسام حسن', 'hossam hassan', ['كابتن حسام حسن']],

                    // Ibrahim Hassan
                    ['إبراهيم حسن', 'ibrahim hassan', ['ابراهيم حسن']],

                    // Reda Abdel Aal
                    ['رضا عبد العال', 'reda abdel aal', ['reda abdelaal', 'رضا عبدالعال']],

                    // Abdallah El Said
                    ['عبد الله السعيد', 'abdallah el said', ['abdallah el-said', 'عبدالله السعيد']],

                    // Mahmoud Kahraba
                    ['محمود عبد المنعم كهربا', 'kahraba', ['كهربا', 'mahmoud kahraba', 'محمود كهربا']],

                    // Imam Ashour
                    ['إمام عاشور', 'imam ashour', ['عاشور', 'emam ashour', 'امام عاشور']],

                    // Ahmed Hassan
                    ['أحمد حسن', 'ahmed hassan', ['احمد حسن', 'الصقر']],

                    // Essam El Hadary
                    ['عصام الحضري', 'essam el hadary', ['el hadary', 'الحضري', 'عصام الحضرى']],

                    // Momen Zakaria
                    ['مؤمن زكريا', 'momen zakaria', ['مؤمن']],

                    // Jamal Hamza
                    ['جمال حمزة', 'gamal hamza', ['جمال حمزه']],

                    // Tarek El Said
                    ['طارق السعيد', 'tarek el said', []],

                    // Mohamed Sedik
                    ['محمد صديق', 'mohamed sedik', []],

                    // Eslam El Shater
                    ['إسلام الشاطر', 'eslam el shater', ['اسلام الشاطر', 'الشاطر']],

                    // Sabry Raheel
                    ['صبري رحيل', 'sabry raheel', ['sabry rahil', 'صبرى رحيل']],

                    // Moataz Eno
                    ['معتز إينو', 'moataz eno', ['إينو', 'معتز اينو', 'اينو']],

                    // Hussein Yasser El Mohamady
                    ['حسين ياسر المحمدي', 'hussein yasser', ['حسين ياسر', 'حسين ياسر المحمدى']],

                    // Ahmed Hamoudi
                    ['أحمد حمودي', 'ahmed hamoudi', ['احمد حمودي', 'حمودي']],

                    // Dominique Da Silva
                    ['دومينيك دا سيلفا', 'dominique da silva', ['دومينيك']],

                    // Sherif Ashraf
                    ['شريف أشرف', 'sherif ashraf', ['شريف اشرف']],

                    // Nader El Sayed
                    ['نادر السيد', 'nader el sayed', []],

                    // Ibrahim Said
                    ['إبراهيم سعيد', 'ibrahim said', ['ابراهيم سعيد', 'هيما']],

                    // Nasser Maher
                    ['ناصر ماهر', 'nasser maher', []],

                    // Ahmed Ramadan Beckham
                    ['أحمد رمضان بيكهام', 'ahmed ramadan beckham', ['احمد رمضان بيكهام', 'بيكهام']],

                    // Hany Said
                    ['هاني سعيد', 'hany said', ['هاني سعيد']],

                    // Hassan Mostafa
                    ['حسن مصطفى', 'hassan mostafa', ['حسن مصطفي']],

                    // Ahmed Magdy
                    ['أحمد مجدي', 'ahmed magdy', ['احمد مجدي']],

                    // Amr Samaka
                    ['عمرو سماكة', 'amr samaka', ['عمرو سماكه']],

                    // Mohamed Abdallah
                    ['محمد عبد الله', 'mohamed abdallah', ['محمد عبدالله']],

                    // Said Abdel Aziz
                    ['سعيد عبد العزيز', 'said abdel aziz', ['سعيد عبدالعزيز']],

                    // Osama Hassan
                    ['أسامة حسن', 'osama hassan', ['اسامة حسن', 'أسامه حسن']],
                ],

            ],
            [
                'text' => 'Football players who won the Ballon d\'Or',
                'text_ar' => 'لاعبين كرة قدم فازوا بجائزة الكرة الذهبية',
                'category' => 'football',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    // Lionel Messi
                    ['ليونيل ميسي', 'lionel messi', ['ميسي', 'ليونيل ميسى', 'ميسى', 'messi']],

                    // Cristiano Ronaldo
                    ['كريستيانو رونالدو', 'cristiano ronaldo', ['رونالدو', 'الدون', 'cr7', 'ronaldo']],

                    // Luka Modric
                    ['لوكا مودريتش', 'luka modric', ['مودريتش', 'modric']],

                    // Karim Benzema
                    ['كريم بنزيما', 'karim benzema', ['بنزيما', 'كريم بنزيمة', 'بنزيمة', 'benzema']],

                    // Vinícius Júnior
                    ['فينيسيوس جونيور', 'vinicius junior', ['فينيسيوس', 'فيني', 'فيني جونيور', 'vinicius', 'vini']],

                    // Rodri
                    ['رودري', 'rodri', ['رودرى', 'رودريغو هرنانديز', 'rodri hernandez']],

                    // Kaká
                    ['كاكا', 'kaka', ['ريكاردو كاكا', 'kaka']],

                    // Fabio Cannavaro
                    ['فابيو كانافارو', 'fabio cannavaro', ['كانافارو', 'cannavaro']],

                    // Ronaldinho
                    ['رونالدينيو', 'ronaldinho', ['رونالدينهو', 'رونالدو دي أسيس موريرا', 'ronaldinho']],

                    // Andriy Shevchenko
                    ['أندري شيفشينكو', 'andriy shevchenko', ['شيفشينكو', 'اندري شيفشينكو', 'shevchenko']],

                    // Pavel Nedvěd
                    ['بافيل نيدفيد', 'pavel nedved', ['نيدفيد', 'nedved']],

                    // Ronaldo Nazário (Ronaldo Il Fenomeno)
                    ['رونالدو الظاهرة', 'ronaldo nazario', ['رونالدو البرازيلي', 'الظاهرة', 'رونالدو', 'رونالدو دي ليما', 'ronaldo']],

                    // Michael Owen
                    ['مايكل أوين', 'michael owen', ['أوين', 'مايكل اوين', 'اوين', 'owen']],

                    // Luís Figo
                    ['لويس فيجو', 'luis figo', ['فيجو', 'لويس فيغو', 'فيغو', 'figo']],

                    // Rivaldo
                    ['ريفالدو', 'rivaldo', ['rivaldo']],

                    // Zinedine Zidane
                    ['زين الدين زيدان', 'zinedine zidane', ['زيدان', 'زيزو', 'zidane', 'zizou']],

                    // Matthias Sammer
                    ['ماتياس زامر', 'matthias sammer', ['زامر', 'sammer']],

                    // George Weah (Only African winner)
                    ['جورج وياه', 'george weah', ['وياه', 'george weah', 'weah']],

                    // Hristo Stoichkov
                    ['خريستو ستويتشكوف', 'hristo stoichkov', ['ستويتشكوف', 'stoichkov']],

                    // Roberto Baggio
                    ['روبرتو باجيو', 'roberto baggio', ['باجيو', 'روبرتو باجو', 'باجو', 'baggio']],

                    // Marco van Basten
                    ['ماركو فان باستن', 'marco van basten', ['فان باستن', 'van basten']],

                    // Lothar Matthäus
                    ['لوثار ماتيوس', 'lothar matthaus', ['ماتيوس', 'لوتار ماتيوس', 'matthaus']],

                    // Ruud Gullit
                    ['رود خوليت', 'ruud gullit', ['خوليت', 'رود غوليت', 'غوليت', 'gullit']],

                    // Michel Platini
                    ['ميشيل بلاتيني', 'michel platini', ['بلاتيني', 'ميشيل بلاتينى', 'بلاتينى', 'platini']],

                    // Karl-Heinz Rummenigge
                    ['كارل هاينز رومينيغه', 'karl heinz rummenigge', ['رومينيغه', 'رومينيجه', 'rummenigge']],

                    // Kevin Keegan
                    ['كيفن كيغان', 'kevin keegan', ['كيفين كيغان', 'كيفن كيجن', 'keegan']],

                    // Allan Simonsen
                    ['ألان سيمونسن', 'allan simonsen', ['الان سيمونسن', 'simonsen']],

                    // Franz Beckenbauer
                    ['فرانتس بيكنباور', 'franz beckenbauer', ['بيكنباور', 'القيصر', 'beckenbauer']],

                    // Oleg Blokhin
                    ['أوليغ بلوخين', 'oleg blokhin', ['اوليغ بلوخين', 'بلوخين', 'blokhin']],

                    // Johan Cruyff
                    ['يوهان كرويف', 'johan cruyff', ['كرويف', 'cruyff']],

                    // Gerd Müller
                    ['جيرد مولر', 'gerd muller', ['مولر', 'جيرد مولير', 'muller']],

                    // Gianni Rivera
                    ['جياني ريفيرا', 'gianni rivera', ['ريفيرا', 'rivera']],

                    // George Best
                    ['جورج بست', 'george best', ['بست', 'george best', 'best']],

                    // Florian Albert
                    ['فلوريان ألبرت', 'florian albert', ['فلوريان البرت', 'albert']],

                    // Bobby Charlton
                    ['بوبي تشارلتون', 'bobby charlton', ['تشارلتون', 'بوبى تشارلتون', 'charlton']],

                    // Eusébio
                    ['أوزيبيو', 'eusebio', ['اوزيبيو', 'eusebio']],

                    // Denis Law
                    ['دنيس لو', 'denis law', ['دنيس لاو', 'law']],

                    // Lev Yashin (Only goalkeeper winner)
                    ['ليف ياشين', 'lev yashin', ['ياشين', 'العنكبوت الأسود', 'yashin']],

                    // Josef Masopust
                    ['جوزيف ماسوبوست', 'josef masopust', ['ماسوبوست', 'masopust']],

                    // Luis Suárez (The Spanish midfielder, not the Uruguayan striker)
                    ['لويس سواريز', 'luis suarez', ['سواريز', 'suarez']],

                    // Alfredo Di Stéfano
                    ['ألفريدو دي ستيفانو', 'alfredo di stefano', ['دي ستيفانو', 'الفريدو دي ستيفانو', 'di stefano']],

                    // Raymond Kopa
                    ['ريموند كوبا', 'raymond kopa', ['كوبا', 'kopa']],

                    // Stanley Matthews (The first ever winner)
                    ['ستانلي ماثيوس', 'stanley matthews', ['ماثيوس', 'ستانلى ماثيوس', 'matthews']],
                ],
            ],
            [
                'text' => 'Countries that won the FIFA World Cup',
                'text_ar' => 'دول فازت بكأس العالم لكرة القدم',
                'category' => 'football',
                'difficulty' => 'easy',
                'accepted_answers' => [
                    // Brazil (5 times)
                    ['البرازيل', 'brazil', ['برازيل', 'السيليساو', 'brazil']],

                    // Germany (4 times)
                    ['ألمانيا', 'germany', ['المانيا', 'ألمانيا الغربية', 'المانيا الغربية', 'germany', 'west germany']],

                    // Italy (4 times)
                    ['إيطاليا', 'italy', ['ايطاليا', 'الاتزوري', 'italy']],

                    // Argentina (3 times)
                    ['الأرجنتين', 'argentina', ['الارجنتين', 'أرجنتين', 'ارجنتين', 'التانجو', 'argentina']],

                    // France (2 times)
                    ['فرنسا', 'france', ['الديوك', 'france']],

                    // Uruguay (2 times)
                    ['الأوروغواي', 'uruguay', ['الاوروغواي', 'الأوروجواي', 'الاوروجواي', 'أوروغواي', 'أوروجواي', 'uruguay']],

                    // England (1 time)
                    ['إنجلترا', 'england', ['انجلترا', 'الأنجليز', 'الأنغليز', 'england']],

                    // Spain (1 time)
                    ['إسبانيا', 'spain', ['اسبانيا', 'الماتادور', 'spain']],
                ],
            ], [
                'text' => 'Clubs that won the UEFA Champions League',
                'text_ar' => 'أندية فازت بدوري أبطال أوروبا',
                'category' => 'football',
                'difficulty' => 'easy',
                'accepted_answers' => [
                    // Real Madrid
                    ['ريال مدريد', 'real madrid', ['الريال', 'مدريد', 'الملكي', 'real madrid']],

                    // AC Milan
                    ['ميلان', 'ac milan', ['إيه سي ميلان', 'اي سي ميلان', 'الروسونيري', 'milan', 'ac milan']],

                    // Bayern Munich
                    ['بايرن ميونخ', 'bayern munich', ['البايرن', 'بايرن ميونيخ', 'البافاري', 'bayern', 'bayern munich']],

                    // Liverpool
                    ['ليفربول', 'liverpool', ['الريدز', 'liverpool']],

                    // Barcelona
                    ['برشلونة', 'barcelona', ['برشلونه', 'البارسا', 'البلوغرانا', 'barca', 'barcelona']],

                    // Ajax
                    ['أياكس أمستردام', 'ajax', ['اياكس', 'أياكس', 'ajax']],

                    // Manchester United
                    ['مانشستر يونايتد', 'manchester united', ['اليونايتد', 'المان يونايتد', 'الشياطين الحمر', 'man united', 'manchester united']],

                    // Inter Milan
                    ['إنتر ميلان', 'inter milan', ['انتر ميلان', 'الإنتر', 'الانتر', 'النيراتزوري', 'inter', 'inter milan']],

                    // Juventus
                    ['يوفنتوس', 'juventus', ['اليوفي', 'اليوفنتوس', 'البيانكونيري', 'juve', 'juventus']],

                    // Chelsea
                    ['تشيلسي', 'chelsea', ['تشيلسى', 'البلوز', 'chelsea']],

                    // Nottingham Forest
                    ['نوتينغهام فورست', 'nottingham forest', ['نوتينجهام فورست', 'نوتنجهام', 'nottingham forest']],

                    // Porto
                    ['بورتو', 'porto', ['التنانين', 'porto']],

                    // Manchester City
                    ['مانشستر سيتي', 'manchester city', ['السيتي', 'المان سيتي', 'السيتيزنز', 'man city', 'manchester city']],

                    // Borussia Dortmund
                    ['بوروسيا دورتموند', 'borussia dortmund', ['دورتموند', 'dortmund', 'borussia dortmund']],

                    // Paris Saint-Germain
                    ['باريس سان جيرمان', 'paris saint germain', ['باريس', 'البي اس جي', 'psg', 'paris saint germain']],

                    // Marseille
                    ['مارسيليا', 'marseille', ['أولمبيك مارسيليا', 'olympique de marseille']],

                    // Celtic
                    ['سيلتيك', 'celtic', ['سيلتيك غلاسكو', 'celtic fc']],

                    // Feyenoord
                    ['فينورد', 'feyenoord', ['فاينورد', 'feyenoord']],

                    // Aston Villa
                    ['أستون فيلا', 'aston villa', ['استون فيلا', 'aston villa']],

                    // PSV Eindhoven
                    ['آيندهوفن', 'psv eindhoven', ['ايندهوفن', 'بي إس في آيندهوفن', 'psv']],

                    // Red Star Belgrade
                    ['النجم الأحمر ويدجراد', 'red star belgrade', ['النجم الاحمر', 'ريد ستار', 'red star']],

                    // Steaua București
                    ['ستيوا بوخارست', 'steaua bucuresti', ['ستيوا', 'steaua']],
                ],
            ], [
                'text' => 'Men\'s footballers who scored 100 or more international goals',
                'text_ar' => 'لاعبين رجال سجلوا 100 هدف أو أكثر مع منتخباتهم الوطنية',
                'category' => 'football',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    // Cristiano Ronaldo
                    ['كريستيانو رونالدو', 'cristiano ronaldo', ['رونالدو', 'الدون', 'صاروخ ماديرا', 'cr7', 'ronaldo']],

                    // Lionel Messi
                    ['ليونيل ميسي', 'lionel messi', ['ميسي', 'ليونيل ميسى', 'ميسى', 'البرغوث', 'messi']],

                    // Ali Daei
                    ['علي دائي', 'ali daei', ['على دائي', 'دائي', 'daei']],
                ],
            ], [
                'text' => 'Men\'s footballers who scored 75 or more international goals',
                'text_ar' => 'لاعبين رجال سجلوا 75 هدف أو أكثر مع منتخباتهم الوطنية',
                'category' => 'football',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    // Cristiano Ronaldo (140+ goals)
                    ['كريستيانو رونالدو', 'cristiano ronaldo', ['رونالدو', 'الدون', 'صاروخ ماديرا', 'cr7', 'ronaldo']],

                    // Lionel Messi (110+ goals)
                    ['ليونيل ميسي', 'lionel messi', ['ميسي', 'ليونيل ميسى', 'ميسى', 'البرغوث', 'messi']],

                    // Ali Daei (108 goals)
                    ['علي دائي', 'ali daei', ['على دائي', 'دائي', 'daei']],

                    // Sunil Chhetri (95 goals)
                    ['سونيل شيتري', 'sunil chhetri', ['شيتري', 'سونيل شيتري', 'chhetri']],

                    // Romelu Lukaku (89 goals)
                    ['روميلو لوكاكو', 'romelu lukaku', ['لوكاكو', 'الدبابة البلجيكية', 'lukaku']],

                    // Robert Lewandowski (89 goals)
                    ['روبرت ليفاندوفسكي', 'robert lewandowski', ['ليفاندوفسكي', 'ليفاندوفسكى', 'ليفا', 'lewandowski', 'lewa']],

                    // Ali Mabkhout (85 goals)
                    ['علي مبخوت', 'ali mabkhout', ['على مبخوت', 'مبخوت', 'mabkhout']],

                    // Neymar Jr. (79 goals)
                    ['نيمار دا سيلفا', 'neymar', ['نيمار', 'نيمار جونيور', 'جونيور', 'neymar jr']],

                    // Godfrey Chitalu (79 goals)
                    ['غودفري شيتالو', 'godfrey chitalu', ['غودفري شيتالو', 'جودفري شيتالو', 'شيتالو', 'chitalu']],
                ],
            ], [
                'text' => 'Midfielders who scored 100 or more English Premier League goals',
                'text_ar' => 'لاعبي خط وسط سجلوا 100 هدف أو أكثر في الدوري الإنجليزي الممتاز',
                'category' => 'football',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    // Frank Lampard (177 goals)
                    ['فرانك لامبارد', 'frank lampard', ['لامبارد', 'فرانك لامبارد', 'lampard']],

                    // Steven Gerrard (120 goals)
                    ['ستيفن جيرارد', 'steven gerrard', ['جيرارد', 'ستيفين جيرارد', 'gerrard']],

                    // Paul Scholes (107 goals)
                    ['بول سكولز', 'paul scholes', ['سكولز', 'scholes']],

                    // Matt Le Tissier (100 goals)
                    ['مات لو تيسيي', 'matt le tissier', ['لو تيسيي', 'مات لو تيسيه', 'le tissier']],
                ],
            ], [
                'text' => 'African players who won the UEFA Champions League',
                'text_ar' => 'لاعبين أفارقة فازوا بدوري أبطال أوروبا',
                'category' => 'football',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    // Mohamed Salah (Egypt - 2019)
                    ['محمد صلاح', 'mohamed salah', ['صلاح', 'ابو مكة', 'أبو مكة', 'salah', 'mo salah']],

                    // Sadio Mané (Senegal - 2019)
                    ['ساديو ماني', 'sadio mane', ['ماني', 'ساديو مانى', 'مانى', 'mane']],

                    // Didier Drogba (Ivory Coast - 2012)
                    ['ديدييه دروغبا', 'didier drogba', ['دروغبا', 'ديدييه دروجبا', 'دروجبا', 'drogba']],

                    // Samuel Eto'o (Cameroon - 2006, 2009, 2010)
                    ['صامويل إيتو', 'samuel etoo', ['إيتو', 'صامويل ايتو', 'ايتو', 'etoo']],

                    // Riyad Mahrez (Algeria - 2023)
                    ['رياض محرز', 'riyad mahrez', ['محرز', 'mahrez']],

                    // Edouard Mendy (Senegal - 2021)
                    ['إدوارد ميندي', 'edouard mendy', ['ميندي', 'إدوارد ميندى', 'ميندى', 'mendy']],

                    // Hakim Ziyech (Morocco - 2021)
                    ['حكيم زياش', 'hakim ziyech', ['زياش', 'ziyech']],

                    // Achraf Hakimi (Morocco - 2018)
                    ['أشرف حكيمي', 'achraf hakimi', ['حكيمي', 'اشرف حكيمي', 'حكيمى', 'hakimi']],

                    // Seydou Keita (Mali - 2009, 2011)
                    ['سيدو كيتا', 'seydou keita', ['كيتا', 'keita']],

                    // Yaya Touré (Ivory Coast - 2009)
                    ['يايا توريه', 'yaya toure', ['توريه', 'toure']],

                    // Michael Essien (Ghana - 2012)
                    ['مايكل إيسيان', 'michael essien', ['إيسيان', 'مايكل ايسيان', 'ايسيان', 'essien']],

                    // Nwankwo Kanu (Nigeria - 1995)
                    ['نوانكو كانو', 'nwankwo kanu', ['كانو', 'kanu']],

                    // Finidi George (Nigeria - 1995)
                    ['فينيدي جورج', 'finidi george', ['جورج', 'finidi']],

                    // Benni McCarthy (South Africa - 2004)
                    ['بيني مكارثي', 'benni mccarthy', ['مكارثي', 'mccarthy']],

                    // Sulley Muntari (Ghana - 2010)
                    ['سولي مونتاري', 'sulley muntari', ['مونتاري', 'مُنتاري', 'muntari']],

                    // Rabah Madjer (Algeria - 1987)
                    ['رابح ماجر', 'rabah madjer', ['ماجر', 'madjer']],
                ],
            ], [
                'text' => 'Managers who won the UEFA Champions League with more than one club',
                'text_ar' => 'مدربين فازوا بدوري أبطال أوروبا مع أكثر من نادٍ مختلف',
                'category' => 'football',
                'difficulty' => 'hard',
                'accepted_answers' => [
                    // Carlo Ancelotti (AC Milan & Real Madrid)
                    ['كارلو أنشيلوتي', 'carlo ancelotti', ['أنشيلوتي', 'كارلو انشيلوتي', 'انشيلوتي', 'ancelotti']],

                    // Pep Guardiola (Barcelona & Manchester City)
                    ['بيب غوارديولا', 'pep guardiola', ['غوارديولا', 'بيب جوارديولا', 'جوارديولا', 'بيب', 'pep', 'guardiola']],

                    // José Mourinho (Porto & Inter Milan)
                    ['جوزيه مورينيو', 'jose mourinho', ['مورينيو', 'السبيشال وان', 'mourinho']],

                    // Jupp Heynckes (Real Madrid & Bayern Munich)
                    ['يوست هاينكس', 'jupp heynckes', ['هاينكس', 'يوب هاينكس', 'heynckes']],

                    // Ottmar Hitzfeld (Borussia Dortmund & Bayern Munich)
                    ['أوتمار هيتسفيلد', 'ottmar hitzfeld', ['هيتسفيلد', 'اوتمار هيتسفيلد', 'hitzfeld']],

                    // Ernst Happel (Feyenoord & Hamburger SV)
                    ['إرنست هابيل', 'ernst happel', ['هابيل', 'ارنست هابيل', 'happel']],
                ],
            ], [
                'text' => 'Footballers who won the Ballon d\'Or 3 or more times',
                'text_ar' => 'لاعبين فازوا بجائزة الكرة الذهبية 3 مرات أو أكثر',
                'category' => 'football',
                'difficulty' => 'easy',
                'accepted_answers' => [
                    // Lionel Messi (8 times)
                    ['ليونيل ميسي', 'lionel messi', ['ميسي', 'ليونيل ميسى', 'ميسى', 'البرغوث', 'messi']],

                    // Cristiano Ronaldo (5 times)
                    ['كريستيانو رونالدو', 'cristiano ronaldo', ['رونالدو', 'الدون', 'cr7', 'ronaldo']],

                    // Michel Platini (3 times)
                    ['ميشيل بلاتيني', 'michel platini', ['بلاتيني', 'ميشيل بلاتينى', 'بلاتينى', 'platini']],

                    // Johan Cruyff (3 times)
                    ['يوهان كرويف', 'johan cruyff', ['كرويف', 'cruyff']],

                    // Marco van Basten (3 times)
                    ['ماركو فان باستن', 'marco van basten', ['فان باستن', 'van basten']],
                ],
            ], [
                'text' => 'African legends who won the African Footballer of the Year award 4 or more times',
                'text_ar' => 'لاعبين فازوا بجائزة أفضل لاعب في أفريقيا 4 مرات أو أكثر',
                'category' => 'football',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    // Samuel Eto'o (4 times)
                    ['صامويل إيتو', 'samuel etoo', ['إيتو', 'صامويل ايتو', 'ايتو', 'etoo']],

                    // Yaya Touré (4 times)
                    ['يايا توريه', 'yaya toure', ['توريه', 'يحيى توريه', 'toure']],
                ],
            ], [
                'text' => 'Italian clubs that won the UEFA Champions League',
                'text_ar' => 'أندية إيطالية فازت بدوري أبطال أوروبا',
                'category' => 'football',
                'difficulty' => 'easy',
                'accepted_answers' => [
                    // AC Milan
                    ['ميلان', 'ac milan', ['إيه سي ميلان', 'اي سي ميلان', 'الروسونيري', 'milan', 'ac milan']],

                    // Inter Milan
                    ['إنتر ميلان', 'inter milan', ['انتر ميلان', 'الإنتر', 'الانتر', 'النيراتزوري', 'inter', 'inter milan']],

                    // Juventus
                    ['يوفنتوس', 'juventus', ['اليوفي', 'اليوفنتوس', 'البيانكونيري', 'juve', 'juventus']],
                ],
            ],
            // Cinema and Entertainment
            [
                'text' => 'TV Series starring Yehia El-Fakharany',
                'text_ar' => 'مسلسلات من بطولة يحيى الفخراني',
                'category' => 'entertainment',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    // يتربى في عزو
                    ['يتربى في عزو', 'yetraba fi ezzo', ['يتربى فى عزو', 'حمادة عزو']],

                    // الليل وآخره
                    ['الليل وآخره', 'el leil wa akhro', ['الليل واخره', 'الليل وآخره']],

                    // دهشة
                    ['دهشة', 'dahsha', ['دهشه']],

                    // ونوس
                    ['ونوس', 'wanous', ['مسلسل ونوس']],

                    // خواجة عبد القادر
                    ['الخواجة عبد القادر', 'el khawaga abdel kader', ['الخواجه عبد القادر', 'خواجة عبد القادر', 'خواجه عبد القادر']],

                    // شيخ العرب همام
                    ['شيخ العرب همام', 'sheikh el arab hammam', ['همام', 'شيخ العرب']],

                    // نجيب زاهي زركش
                    ['نجيب زاهي زركش', 'naguib zahi zarkash', ['نجيب زاهى زركش']],

                    // عتبات البهجة
                    ['عتبات البهجة', 'atabat el bahga', ['عتبات البهجه']],

                    // عباس الأبيض في اليوم الأسود
                    ['عباس الأبيض في اليوم الأسود', 'abbas el abyad', ['عباس الابيض', 'عباس الأبيض']],

                    // سكة الهلالي
                    ['سكة الهلالي', 'sekket el hilali', ['سكه الهلالي', 'سكة الهلالى']],

                    // شرف فتح الباب
                    ['شرف فتح الباب', 'sharaf fat7 el bab', ['شرف فتح الباب']],

                    // ابن الأرندلي
                    ['ابن الأرندلي', 'ibn el arandali', ['ابن الارندلي']],

                    // أوبرا عايدة
                    ['أوبرا عايدة', 'opera aida', ['اوبرا عايدة', 'أوبرا عايده']],

                    // جحا المصري
                    ['جحا المصري', 'goha el masry', ['جحا المصرى']],

                    // نصف ربيع الآخر
                    ['نصف ربيع الآخر', 'nesf rabea el akhar', ['نصف ربيع الاخر']],

                    // زيزينيا
                    ['زيزينيا', 'zizinia', ['مسلسل زيزينيا']],

                    // لا
                    ['لا', 'la', ['مسلسل لا']],
                ],
            ], [
                'text' => 'TV Series starring Adel Emam',
                'text_ar' => 'مسلسلات من بطولة عادل إمام',
                'category' => 'entertainment',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    // فرقة ناجي عطا الله
                    ['فرقة ناجي عطا الله', 'ferqat nagi atallah', ['فرقه ناجي عطا الله', 'ناجي عطا الله', 'ناجى عطا الله']],

                    // العراف
                    ['العراف', 'el arraf', ['مسلسل العراف']],

                    // صاحب السعادة
                    ['صاحب السعادة', 'saheb el saada', ['صاحب السعاده']],

                    // مأمون وشركاه
                    ['مأمون وشركاه', 'mamoun wa shorkah', ['مامون وشركاه']],

                    // أستاذ ورئيس قسم
                    ['أستاذ ورئيس قسم', 'ostaz wa raees qesm', ['استاذ ورئيس قسم']],

                    // عفاريت عدلي علام
                    ['عفاريت عدلي علام', 'afareet adly allam', ['عدلي علام', 'عدلى علام']],

                    // عوالم خفية
                    ['عوالم خفية', 'awaleem khafeya', ['عوالم خفيه']],

                    // فلانتينو
                    ['فلانتينو', 'valentino', ['مسلسل فلانتينو']],

                    // دموع في عيون وقحة
                    ['دموع في عيون وقحة', 'domoo fi eyoon waqha', ['دموع فى عيون وقحة', 'جمعة الشوان', 'جمعه الشوان']],

                    // أحلام الفتى الطائر
                    ['أحلام الفتى الطائر', 'ahlam el fata el ta2er', ['احلام الفتى الطائر', 'الفتى الطائر']],
                ],
            ], [
                'text' => 'Movies directed by Marwan Hamed',
                'text_ar' => 'أفلام من إخراج مروان حامد',
                'category' => 'cinema',
                'difficulty' => 'hard',
                'accepted_answers' => [
                    // عمارة يعقوبيان
                    ['عمارة يعقوبيان', 'the yakoubian building', ['عماره يعقوبيان', 'يعقوبيان']],

                    // إبراهيم الأبيض
                    ['إبراهيم الأبيض', 'ibrahim el abyad', ['ابراهيم الابيض', 'ابراهيم الأبيض']],

                    // الفيل الأزرق
                    ['الفيل الأزرق', 'the blue elephant', ['الفيل الازرق', 'الفيل الأزرق 1']],

                    // الفيل الأزرق 2
                    ['الفيل الأزرق 2', 'the blue elephant 2', ['الفيل الازرق 2', 'الجزء الثاني من الفيل الازرق']],

                    // الأصليين
                    ['الأصليين', 'the originals', ['الاصليين']],

                    // تراب الماس
                    ['تراب الماس', 'diamond dust', ['فيلم تراب الماس']],

                    // كيرة والجن
                    ['كيرة والجن', 'kira wal gin', ['كيره والجن']],
                ],
            ], [
                'text' => 'Movies directed by Marwan Hamed',
                'text_ar' => 'أفلام من إخراج مروان حامد',
                'category' => 'cinema',
                'difficulty' => 'hard',
                'accepted_answers' => [
                    // عمارة يعقوبيان (2006)
                    ['عمارة يعقوبيان', 'the yacoubian building', ['عماره يعقوبيان', 'يعقوبيان']],

                    // إبراهيم الأبيض (2009)
                    ['إبراهيم الأبيض', 'ibrahim el abyad', ['ابراهيم الابيض', 'ابراهيم الأبيض']],

                    // 18 يوم (2011)
                    ['18 يوم', '18 days', ['ثمانية عشر يوماً', 'من ثمانية عشر يوما', '١٨ يوم']],

                    // الفيل الأزرق (2014)
                    ['الفيل الأزرق', 'the blue elephant', ['الفيل الازرق', 'الفيل الأزرق 1']],

                    // الأصليين (2017)
                    ['الأصليين', 'the originals', ['الاصليين']],

                    // تراب الماس (2018)
                    ['تراب الماس', 'diamond dust', ['فيلم تراب الماس']],

                    // الفيل الأزرق 2 (2019)
                    ['الفيل الأزرق 2', 'the blue elephant 2', ['الفيل الازرق 2', 'الجزء الثاني من الفيل الازرق']],

                    // كيرة والجن (2022)
                    ['كيرة والجن', 'kira wal gin', ['كيره والجن', 'كيرة والجن']],

                    // الست (2025/2026 Umm Kulthum Biopic)
                    ['الست', 'el sett', ['فيلم الست', 'ام كلثوم', 'أم كلثوم']],

                    // لي لي (2001 - Famous award-winning debut short film)
                    ['لي لي', 'lilly', ['ليلي', 'فيلم لي لي']],
                ],
            ],

            [
                'text' => 'Egyptian movies that grossed over 100 million EGP at the box office',
                'text_ar' => 'أفلام مصرية تخطت إيراداتها 100 مليون جنيه في شباك التذاكر',
                'category' => 'cinema',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    // بيت الروبي
                    ['بيت الروبي', 'beit el rouby', ['بيت الروبى', 'فيلم بيت الروبي']],

                    // كيرة والجن
                    ['كيرة والجن', 'kira wal gin', ['كيره والجن']],

                    // الفيل الأزرق 2
                    ['الفيل الأزرق 2', 'the blue elephant 2', ['الفيل الازرق 2']],

                    // ولاد رزق 3
                    ['ولاد رزق 3', 'welad rizk 3', ['ولاد رزق ٣', 'ولاد رزق الجزء الثالث']],

                    // السرب
                    ['السرب', 'el srab', ['فيلم السرب']],

                    // كازابلانكا
                    ['كازابلانكا', 'casablanca', ['فيلم كازابلانكا']],

                    // الممر
                    ['الممر', 'el mamar', ['فيلم الممر']],
                ],
            ], [
                'text' => 'TV Series starring Nour El-Sherif',
                'text_ar' => 'مسلسلات من بطولة نور الشريف',
                'category' => 'entertainment',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    // لن أعيش في جلباب أبي
                    ['لن أعيش في جلباب أبي', 'lan aeesh fi gelbab aby', ['لن اعيش في جلباب ابي', 'لن اعيش فى جلباب ابى', 'عبد الغفور البرعي', 'عبدالغفور البرعى']],

                    // عائلة الحاج متولي
                    ['عائلة الحاج متولي', '3aelat el hag metwally', ['عائله الحاج متولي', 'الحاج متولي', 'الحاج متولى']],

                    // الدالي
                    ['الدالي', 'el daly', ['مسلسل الدالي', 'الدالى']],

                    // متخافوش
                    ['متخافوش', 'matkhafoosh', ['مسلسل متخافوش']],

                    // حضرة المتهم أبي
                    ['حضرة المتهم أبي', 'hadrat el motaham aby', ['حضرة المتهم ابي', 'حضره المتهم ابى', 'عبد الحميد دراز']],

                    // العطار والسبع بنات
                    ['العطار والسبع بنات', 'el attar wal saba3 banat', ['الحاج صالح العطار', 'العطار والسبع بنات']],

                    // خلف الله
                    ['خلف الله', 'khalf allah', ['مسلسل خلف الله']],

                    // الرحايا
                    ['الرحايا', 'el rahaya', ['الرحايا حجر القلوب', 'مسلسل الرحايا']],

                    // عمر بن عبد العزيز
                    ['عمر بن عبد العزيز', 'omar ibn abdel aziz', ['مسلسل عمر بن عبد العزيز']],

                    // مارد الجبل
                    ['مارد الجبل', 'mared el gabal', ['مسلسل مارد الجبل']],

                    // هارون الرشيد
                    ['هارون الرشيد', 'haroon el rashid', ['مسلسل هارون الرشيد']],

                    // الثعلب
                    ['الثعلب', 'el tha3lab', ['مسلسل الثعلب']],

                    // عيش أيامك
                    ['عيش أيامك', '3eesh ayamrak', ['عيش ايامك']],
                ],
            ], [
                'text' => 'Egyptian a-list actors whose name starts with A',
                'text_ar' => 'ممثلين صف أول مصريين يبدأ اسمهم بحرف الألف',
                'category' => 'entertainment',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    // أحمد السقا
                    ['أحمد السقا', 'ahmed el sakka', ['احمد السقا', 'السقا']],

                    // أحمد حلمي
                    ['أحمد حلمي', 'ahmed helmy', ['احمد حلمي', 'احمد حلمى', 'حلمي']],

                    // أحمد عز
                    ['أحمد عز', 'ahmed ezz', ['احمد عز', 'عز']],

                    // أحمد مكي
                    ['أحمد مكي', 'ahmed mekky', ['احمد مكي', 'احمد مكى', 'مكي', 'مكى']],

                    // أمير كرارة
                    ['أمير كرارة', 'amir karara', ['امير كرارة', 'كرارة', 'امير كراره']],

                    // أحمد فهمي
                    ['أحمد فهمي', 'ahmed fahmy', ['احمد فهمي', 'احمد فهمى']],

                    // أحمد رمزي (Classic era mega-star protection)
                    ['أحمد رمزي', 'ahmed ramzy', ['احمد رمزي', 'احمد رمزى', 'رمزي']],

                    // أحمد زكي (Legendary status protection)
                    ['أحمد زكي', 'ahmed zaki', ['احمد زكي', 'احمد زكى', 'النمر الأسود']],

                    // آسر ياسين
                    ['آسر ياسين', 'asser yassin', ['اسر ياسين']],
                ],
            ], [
                'text' => 'Famous Egyptian male singers whose name starts with M',
                'text_ar' => 'مطربين مصريين رجال يبدأ اسمهم بحرف الميم',
                'category' => 'entertainment',
                'difficulty' => 'easy',
                'accepted_answers' => [
                    // محمد منير
                    ['محمد منير', 'mohamed mounir', ['منير', 'الكينج', 'الكينج محمد منير']],

                    // محمد حماقي
                    ['محمد حماقي', 'mohamed hamaki', ['حماقي', 'حماقى', 'محمد حماقى']],

                    // محمد رمضان
                    ['محمد رمضان', 'mohamed ramadan', ['نمبر وان', 'رمضان']],

                    // مدحت صالح
                    ['مدحت صالح', 'medhat saleh', ['مدحت صالح']],

                    // مصطفى قمر
                    ['مصطفى قمر', 'moustafa qamar', ['مصطفي قمر', 'قمر']],

                    // مصطفى حجاج
                    ['مصطفى حجاج', 'moustafa haggag', ['مصطفي حجاج']],

                    // محمد فؤاد
                    ['محمد فؤاد', 'mohamed fouad', ['فؤش', 'فؤاد']],

                    // محمد عبد الوهاب (Legacy protection)
                    ['محمد عبد الوهاب', 'mohamed abdel wahab', ['عبد الوهاب', 'عبد الوهاب', 'موسيقار الأجيال']],

                    // محمد رشدي (Legacy traditional protection)
                    ['محمد رشدي', 'mohamed roushdy', ['رشدي', 'محمد رشدى']],

                    // محمود العسيلي
                    ['محمود العسيلي', 'mahmoud el esseily', ['العسيلي', 'العسيلى', 'محمود العسيلى']],
                ],
            ], // Geography

            [
                'text' => 'African countries with a coastline on the Mediterranean Sea',
                'text_ar' => 'دول أفريقية تمتلك شريطاً ساحلياً على البحر الأبيض المتوسط',
                'category' => 'geography',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    // Egypt
                    ['مصر', 'egypt', ['جمهورية مصر العربية', 'جمهوريه مصر العربيه', 'egypt']],

                    // Libya
                    ['ليبيا', 'libya', ['دولة ليبيا', 'libya']],

                    // Tunisia
                    ['تونس', 'tunisia', ['الجمهورية التونسية', 'tunisia']],

                    // Algeria
                    ['الجزائر', 'algeria', ['بلد المليون شهيد', 'algeria']],

                    // Morocco
                    ['المغرب', 'morocco', ['المملكة المغربية', 'المملكه المغربيه', 'morocco']],
                ],
            ], [
                'text' => 'Arab countries located entirely within the continent of Asia',
                'text_ar' => 'دول عربية تقع بالكامل في قارة آسيا',
                'category' => 'geography',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    ['السعودية', 'saudi arabia', ['المملكة العربية السعودية', 'المملكه العربيه السعوديه', 'الرياض', 'ksa']],
                    ['الإمارات', 'uae', ['الامارات', 'الإمارات العربية المتحدة', 'الامارات العربيه المتحده', 'ابو ظبي']],
                    ['قطر', 'qatar', ['دولة قطر', 'الدوحة']],
                    ['البحرين', 'bahrain', ['مملكة البحرين', 'المنامة']],
                    ['عمان', 'oman', ['سلطنة عمان', 'سلطنه عمان', 'مسقط']],
                    ['الكويت', 'kuwait', ['دولة الكويت', 'الكويت']],
                    ['اليمن', 'yemen', ['الجمهورية اليمنية', 'صنعاء']],
                    ['العراق', 'iraq', ['بغداد']],
                    ['سوريا', 'syria', ['الجمهورية العربية السورية', 'دمشق']],
                    ['لبنان', 'lebanon', ['بيروت']],
                    ['الأردن', 'jordan', ['الاردن', 'المملكة الأردنية الهاشمية', 'عمان']],
                    ['فلسطين', 'palestine', ['القدس']],
                ],
            ], [
                'text' => 'Countries that share the Nile River Basin',
                'text_ar' => 'دول حوض النيل التي يمر عبرها نهر النيل أو روافده',
                'category' => 'geography',
                'difficulty' => 'hard',
                'accepted_answers' => [
                    ['مصر', 'egypt', ['egypt']],
                    ['السودان', 'sudan', ['sudan']],
                    ['جنوب السودان', 'south sudan', ['south sudan']],
                    ['إثيوبيا', 'ethiopia', ['اثيوبيا', 'ethiopia']],
                    ['أوغندا', 'uganda', ['اوغندا', 'uganda']],
                    ['كينيا', 'kenya', ['kenya']],
                    ['تنزانيا', 'tanzania', ['tanzania']],
                    ['رواندا', 'rwanda', ['rwanda']],
                    ['بوروندي', 'burundi', ['بوروندى', 'burundi']],
                    ['جمهورية الكونغو الديمقراطية', 'dr congo', ['الكونغو الديمقراطية', 'الكونغو', 'congo']],
                    ['إريتريا', 'eritrea', ['اريتريا', 'eritrea']],
                ],
            ],
            [
                'text' => 'Capital cities of European countries',
                'text_ar' => 'عواصم الدول الأوروبية',
                'category' => 'geography',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    // London (UK)
                    ['لندن', 'london', ['مدينة لندن', 'london']],

                    // Paris (France)
                    ['باريس', 'paris', ['عاصمة فرنسا', 'paris']],

                    // Berlin (Germany)
                    ['برلين', 'berlin', ['berlin']],

                    // Rome (Italy)
                    ['روما', 'rome', ['rome']],

                    // Madrid (Spain)
                    ['مدريد', 'madrid', ['madrid']],

                    // Moscow (Russia)
                    ['موسكو', 'moscow', ['moscow']],

                    // Kyiv (Ukraine)
                    ['كييف', 'kyiv', ['كييڤ', 'kiev', 'kyiv']],

                    // Amsterdam (Netherlands)
                    ['أمستردام', 'amsterdam', ['امستردام', 'amsterdam']],

                    // Brussels (Belgium)
                    ['بروكسل', 'brussels', ['بروكسل', 'brussels']],

                    // Vienna (Austria)
                    ['فيينا', 'vienna', ['فيينا', 'ڤيينا', 'vienna']],

                    // Lisbon (Portugal)
                    ['لشبونة', 'lisbon', ['لشبونه', 'lisbon']],

                    // Athens (Greece)
                    ['أثينا', 'athens', ['اثينا', 'athens']],

                    // Dublin (Ireland)
                    ['دبلن', 'dublin', ['dublin']],

                    // Copenhagen (Denmark)
                    ['كوبنهاجن', 'copenhagen', ['كوبنهاغين', 'كوبنهاغن', 'copenhagen']],

                    // Stockholm (Sweden)
                    ['ستوكهولم', 'stockholm', ['stockholm']],

                    // Oslo (Norway)
                    ['أوسلو', 'oslo', ['اوسلو', 'oslo']],

                    // Helsinki (Finland)
                    ['هلسنكي', 'helsinki', ['هلسنكى', 'helsinki']],

                    // Warsaw (Poland)
                    ['وارسو', 'warsaw', ['وارسو', 'warsaw']],

                    // Prague (Czech Republic)
                    ['براغ', 'prague', ['براغ', 'prague']],

                    // Budapest (Hungary)
                    ['بودابست', 'budapest', ['بودابست', 'budapest']],

                    // Bucharest (Romania)
                    ['بوخارست', 'bucharest', ['bucharest']],

                    // Sofia (Bulgaria)
                    ['صوفيا', 'sofia', ['sofia']],

                    // Belgrade (Serbia)
                    ['بلجراد', 'belgrade', ['بلغراد', 'belgrade']],

                    // Zagreb (Croatia)
                    ['زغرب', 'zagreb', ['zagreb']],

                    // Sarajevo (Bosnia and Herzegovina)
                    ['سراييفو', 'sarajevo', ['sarajevo']],

                    // Skopje (North Macedonia)
                    ['سكوبيه', 'skopje', ['سكوبيا', 'skopje']],

                    // Tirana (Albania)
                    ['تيرانا', 'tirana', ['tirana']],

                    // Pristina (Kosovo)
                    ['بريشتينا', 'pristina', ['pristina']],

                    // Podgorica (Montenegro)
                    ['بودغوريتسا', 'podgorica', ['بودغوريتشا', 'بودغوريتسا', 'podgorica']],

                    // Ljubljana (Slovenia)
                    ['ليوبليانا', 'ljubljana', ['ليوبليانا', 'ljubljana']],

                    // Bratislava (Slovakia)
                    ['براتيسلافا', 'bratislava', ['براتيسلاڤا', 'bratislava']],

                    // Minsk (Belarus)
                    ['مينسك', 'minsk', ['minsk']],

                    // Chisinau (Moldova)
                    ['كيشيناو', 'chisinau', ['chisinau']],

                    // Tallinn (Estonia)
                    ['تالين', 'tallinn', ['tallinn']],

                    // Riga (Latvia)
                    ['ريغا', 'riga', ['ريجا', 'riga']],

                    // Vilnius (Lithuania)
                    ['فيلنيوس', 'vilnius', ['ڤيلنيوس', 'vilnius']],

                    // Reykjavik (Iceland)
                    ['ريكيافيك', 'reykjavik', ['ريكياڤيك', 'reykjavik']],

                    // Valletta (Malta)
                    ['فاليتا', 'valletta', ['ڤاليتا', 'valletta']],

                    // Nicosia (Cyprus - Geopolitically European)
                    ['نيقوسيا', 'nicosia', ['نيقوسيا', 'nicosia']],

                    // Luxembourg City (Luxembourg)
                    ['لوكسمبورغ', 'luxembourg', ['لوكسمبورج', 'luxembourg']],

                    // Monaco (Monaco)
                    ['موناكو', 'monaco', ['monaco']],

                    // San Marino (San Marino)
                    ['سان مارينو', 'san marino', ['san marino']],

                    // Vatican City (Vatican)
                    ['الفاتيكان', 'vatican city', ['فاتيكان', 'مدينة الفاتيكان', 'vatican']],

                    // Vaduz (Liechtenstein)
                    ['فادوز', 'vaduz', ['ڤادوز', 'vaduz']],

                    // Andorra la Vella (Andorra)
                    ['أندورا لا فيلا', 'andorra la vella', ['اندورا لا فيلا', 'أندورا', 'andorra']],
                ],
            ],
            [
                'text' => 'Countries located in Africa',
                'text_ar' => 'دول تقع في قارة أفريقيا',
                'category' => 'geography',
                'difficulty' => 'easy',
                'accepted_answers' => [
                    // Egypt
                    ['مصر', 'egypt', ['جمهورية مصر العربية', 'جمهوريه مصر العربيه', 'egypt']],

                    // Sudan
                    ['السودان', 'sudan', ['جمهورية السودان', 'sudan']],

                    // Libya
                    ['ليبيا', 'libya', ['دولة ليبيا', 'libya']],

                    // Tunisia
                    ['تونس', 'tunisia', ['الجمهورية التونسية', 'تونس الخضراء', 'tunisia']],

                    // Algeria
                    ['الجزائر', 'algeria', ['جمهورية الجزائر', 'algeria']],

                    // Morocco
                    ['المغرب', 'morocco', ['المملكة المغربية', 'المملكه المغربيه', 'morocco']],

                    // South Sudan
                    ['جنوب السودان', 'south sudan', ['جمهورية جنوب السودان', 'south sudan']],

                    // Mauritania
                    ['موريتانيا', 'mauritania', ['موريتانيا', 'mauritania']],

                    // Somalia
                    ['الصومال', 'somalia', ['صومال', 'somalia']],

                    // Djibouti
                    ['جيبوتي', 'djibouti', ['جيبوتى', 'djibouti']],

                    // Comoros
                    ['جزر القمر', 'comoros', ['جزر القمر', 'comoros']],

                    // Ethiopia
                    ['إثيوبيا', 'ethiopia', ['اثيوبيا', 'الحبشة', 'ethiopia']],

                    // Eritrea
                    ['إريتريا', 'eritrea', ['اريتريا', 'eritrea']],

                    // Kenya
                    ['كينيا', 'kenya', ['kenya']],

                    // Uganda
                    ['أوغندا', 'uganda', ['اوغندا', 'uganda']],

                    // Tanzania
                    ['تنزانيا', 'tanzania', ['tanzania']],

                    // Rwanda
                    ['رواندا', 'rwanda', ['rwanda']],

                    // Burundi
                    ['بوروندي', 'burundi', ['بوروندى', 'burundi']],

                    // Democratic Republic of the Congo
                    ['جمهورية الكونغو الديمقراطية', 'dr congo', ['الكونغو الديمقراطية', 'الكونغو الديمقراطيه', 'كونغو الديمقراطية', 'drc', 'congo']],

                    // Republic of the Congo
                    ['جمهورية الكونغو', 'congo', ['الكونغو برازافيل', 'الكونغو', 'congo']],

                    // Central African Republic
                    ['جمهورية أفريقيا الوسطى', 'central african republic', ['افريقيا الوسطى', 'جمهورية افريقيا الوسطى', 'car']],

                    // Chad
                    ['تشاد', 'chad', ['جمهورية تشاد', 'chad']],

                    // Niger
                    ['النيجر', 'niger', ['نيجر', 'niger']],

                    // Nigeria
                    ['نيجيريا', 'nigeria', ['nigeria']],

                    // Mali
                    ['مالي', 'mali', ['مالى', 'mali']],

                    // Mauritania
                    ['موريتانيا', 'mauritania', ['موريتانيا', 'mauritania']],

                    // Senegal
                    ['السنغال', 'senegal', ['سنغال', 'senegal']],

                    // Gambia
                    ['غامبيا', 'gambia', ['غامبيا', 'gambia']],

                    // Guinea
                    ['غينيا', 'guinea', ['غينيا كوناكري', 'guinea']],

                    // Guinea-Bissau
                    ['غينيا بيساو', 'guinea bissau', ['guinea-bissau']],

                    // Sierra Leone
                    ['سيراليون', 'sierra leone', ['sierra leone']],

                    // Liberia
                    ['ليبيريا', 'liberia', ['liberia']],

                    // Ivory Coast (Côte d'Ivoire)
                    ['ساحل العاج', 'ivory coast', ['كوت ديفوار', 'كوت ديفوار', 'cote d ivoire']],

                    // Ghana
                    ['غانا', 'ghana', ['ghana']],

                    // Togo
                    ['توغو', 'togo', ['توجه', 'توغو', 'togo']],

                    // Benin
                    ['بنين', 'benin', ['بنين', 'benin']],

                    // Burkina Faso
                    ['بوركينا فاسو', 'burkina faso', ['بوركينا فاسو', 'burkina faso']],

                    // Cameroon
                    ['الكاميرون', 'cameroon', ['كاميرون', 'cameroon']],

                    // Equatorial Guinea
                    ['غينيا الاستوائية', 'equatorial guinea', ['غينيا الاستوائيه', 'equatorial guinea']],

                    // Gabon
                    ['الغابون', 'gabon', ['غابون', 'الجابون', 'gabon']],

                    // Angola
                    ['أنجولا', 'angola', ['انجولا', 'angola']],

                    // Zambia
                    ['زامبيا', 'zambia', ['zambia']],

                    // Zimbabwe
                    ['زيمبابوي', 'zimbabwe', ['زيمبابوى', 'zimbabwe']],

                    // Malawi
                    ['مالاوي', 'malawi', ['مالاوى', 'malawi']],

                    // Mozambique
                    ['موزمبيق', 'mozambique', ['الوزمبيق', 'mozambique']],

                    // Namibia
                    ['ناميبيا', 'namibia', ['namibia']],

                    // Botswana
                    ['بوتسوانا', 'botswana', ['botswana']],

                    // South Africa
                    ['جنوب أفريقيا', 'south africa', ['جنوب افريقيا', 'جنوب أفريقيا', 'rsa', 'south africa']],

                    // Lesotho
                    ['ليسوتو', 'lesotho', ['lesotho']],

                    // Eswatini (Swaziland)
                    ['إسواتيني', 'eswatini', ['اسواتيني', 'سوازيلاند', 'eswatini', 'swaziland']],

                    // Madagascar
                    ['مدغشقر', 'madagascar', ['madagascar']],

                    // Mauritius
                    ['موريشيوس', 'mauritius', ['mauritius']],

                    // Seychelles
                    ['سيشل', 'seychelles', ['جزر سيشل', 'seychelles']],

                    // Cape Verde
                    ['كاب فيردي', 'cape verde', ['الرأس الأخضر', 'الرأس الاخضر', 'كاب ڤيردي', 'cape verde']],

                    // Sao Tome and Principe
                    ['ساو تومي وبرينسيب', 'sao tome', ['ساو تومي', 'sao tome and principe']],
                ],
            ],
            // General Knowledge
            [
                'text' => 'Colors of the rainbow',
                'text_ar' => 'ألوان قوس قزح',
                'category' => 'general',
                'difficulty' => 'easy',
                'accepted_answers' => [
                    ['أحمر', 'red', ['احمر', 'الأحمر', 'الاحمر']],
                    ['برتقالي', 'orange', ['برتقالى', 'البرتقالي', 'البرتقالى']],
                    ['أصفر', 'yellow', ['اصفر', 'الأصفر', 'الاصفر']],
                    ['أخضر', 'green', ['اخضر', 'الأخضر', 'الاخضر']],
                    ['أزرق', 'blue', ['ازرق', 'الأزرق', 'الازرق']],
                    ['نيلي', 'indigo', ['نيلى', 'النيلي', 'النيلى']],
                    ['بنفسجي', 'violet', ['بنفسجى', 'البنفسجي', 'البنفسجى', 'purple']],
                ],
            ],
            [
                'text' => 'Planets in the solar system',
                'text_ar' => 'كواكب المجموعة الشمسية',
                'category' => 'general',
                'difficulty' => 'easy',
                'accepted_answers' => [
                    ['عطارد', 'mercury', ['عطارد', 'عطارد', 'ميركوري', 'عطارد']],
                    ['الزهرة', 'venus', ['الزهرة', 'الزهرة', 'فينوس', 'الزهره']],
                    ['الأرض', 'earth', ['الارض', 'الارض', 'إيرث', 'الكرة الارضية']],
                    ['المريخ', 'mars', ['المريخ', 'المريخ', 'مارس']],
                    ['المشتري', 'jupiter', ['المشتري', 'المشتري', 'مشتري', 'المشترى']],
                    ['زحل', 'saturn', ['زحل', 'زحل', 'ساتورن']],
                    ['أورانوس', 'uranus', ['اورانوس', 'أورانوس', 'يورانس']],
                    ['نبتون', 'neptune', ['نبتون', 'نبتون', 'نيبتون']],
                ],
            ],
            [
                'text' => 'SI base units of measurement',
                'text_ar' => 'الوحدات الأساسية في النظام الدولي للقياس',
                'category' => 'general',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    // Mass
                    ['كيلوغرام', 'kilogram', ['كيلوجرام', 'الكيلوغرام', 'الكيلوجرام', 'كجم', 'kg']],

                    // Length
                    ['متر', 'meter', ['المتر', 'متر', 'm']],

                    // Time
                    ['ثانية', 'second', ['الثانية', 'ثانيه', 'الثانيه', 'ث', 's']],

                    // Electric Current
                    ['أمبير', 'ampere', ['امبير', 'الأمبير', 'الامبير', 'A']],

                    // Temperature
                    ['كلفن', 'kelvin', ['الكلفن', 'كالفن', 'الكالفن', 'K']],

                    // Amount of substance
                    ['مول', 'mole', ['المول', 'mol']],

                    // Luminous intensity
                    ['شمعة', 'candela', ['الشمعة', 'شمعه', 'الشامعة', 'كانديلا', 'cd']],
                ],
            ],
            [
                'text' => 'The major oceans of the world',
                'text_ar' => 'المحيطات الرئيسية في العالم',
                'category' => 'general',
                'difficulty' => 'easy',
                'accepted_answers' => [
                    ['المحيط الهادئ', 'pacific ocean', ['المحيط الهادئ', 'الهادئ', 'الهادئ', 'pacific']],
                    ['المحيط الأطلسي', 'atlantic ocean', ['المحيط الاطلسي', 'الأطلسي', 'الاطلسي', 'الأطلنطي', 'الاطلنطي', 'atlantic']],
                    ['المحيط الهندي', 'indian ocean', ['الهندي', 'الهندى', 'indian']],
                    ['المحيط المتجمد الشمالي', 'arctic ocean', ['المحيط الشمالي', 'المتجمد الشمالي', 'arctic']],
                    ['المحيط المتجمد الجنوبي', 'antarctic ocean', ['المحيط الجنوبي', 'المتجمد الجنوبي', 'antarctic', 'southern ocean']],
                ],
            ], [
                'text' => 'Internal organs of the human body',
                'text_ar' => 'أعضاء داخلية في جسم الإنسان',
                'category' => 'general',
                'difficulty' => 'easy',
                'accepted_answers' => [
                    // Core Heavies
                    ['القلب', 'heart', ['قلب', 'heart']],
                    ['الدماغ', 'brain', ['دماغ', 'المخ', 'مخ', 'العقل', 'brain']],
                    ['الرئتان', 'lungs', ['الرئة', 'الرئتين', 'رئة', 'رئتين', 'lungs']],
                    ['الكبد', 'liver', ['كبد', 'liver']],
                    ['الكلى', 'kidneys', ['الكلية', 'الكليتين', 'كلية', 'كلى', 'kidneys']],

                    // Gastrointestinal System
                    ['المعدة', 'stomach', ['المعده', 'معدة', 'معده', 'stomach']],
                    ['الأمعاء', 'intestines', ['الامعاء', 'الأمعاء الدقيقة', 'الأمعاء الغليظة', 'intestine']],
                    ['البنكرياس', 'pancreas', ['بنكرياس', 'pancreas']],
                    ['المرارة', 'gallbladder', ['المراره', 'مرارة', 'مراره', 'gallbladder']],

                    // Other Common Internal Organs
                    ['الطحال', 'spleen', ['طحال', 'spleen']],
                    ['المثانة', 'bladder', ['المثانه', 'مثانة', 'مثانه', 'bladder']],
                    ['البلعوم', 'pharynx', ['بلعوم', 'pharynx']],
                    ['المريء', 'esophagus', ['المريء', 'المريء', 'esophagus']],
                    ['الغدة الدرقية', 'thyroid', ['الدرقية', 'الغده الدرقيه', 'thyroid']],
                    ['الرحم', 'uterus', ['رحم', 'uterus']],
                ],
            ],
            [
                'text' => 'Famous scientists and their primary fields',
                'text_ar' => 'علماء مشهورون ومجالاتهم الرئيسية',
                'category' => 'general',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    // Physics
                    ['ألبرت أينشتاين', 'albert einstein', ['اينشتاين', 'اينشتاين', 'einstein']],
                    ['إسحاق نيوتن', 'isaac newton', ['نيوتن', 'نيوتن', 'newton']],
                    ['ماكس بلانك', 'max planck', ['بلانك', 'max planck']],
                    ['نيلز بور', 'niels bohr', ['بور', 'niels bohr']],

                    // Chemistry & Physics
                    ['ماري كوري', 'marie curie', ['ماري كوري', 'curie']],

                    // Chemistry
                    ['أنتوان لافوازييه', 'antoine lavoisier', ['لافوازييه', 'lavoisier']],
                    ['ديميتري مندليف', 'dmitri mendeleev', ['مندليف', 'mendeleev']],
                    ['روبرت بويل', 'robert boyle', ['بويل', 'robert boyle']],

                    // Biology
                    ['تشارلز داروين', 'charles darwin', ['داروين', 'darwin']],
                    ['جريجور مندل', 'gregor mendel', ['مندل', 'mendel']],
                    ['لويس باستور', 'louis pasteur', ['باستور', 'pasteur']],

                    // Astronomy
                    ['غاليليو غاليلي', 'galileo galilei', ['غاليليو', 'galileo']],
                    ['نيكولاس كوبرنيكوس', 'nicolaus copernicus', ['كوبرنيكوس', 'copernicus']],
                    ['يوهانس كيبلر', 'johannes kepler', ['كيبلر', 'kepler']],
                    ['ستيفن هوكينغ', 'stephen hawking', ['ستيفن هوكنغ', 'هوكنغ', 'hawking']],

                    // Mathematics
                    ['أرخميدس', 'archimedes', ['ارخميدس', 'archimedes']],
                    ['إقليدس', 'euclid', ['اقليدس', 'euclid']],
                    ['ليونارد أويلر', 'leonhard euler', ['اويلر', 'euler']],
                    ['كارل فريدريش غاوس', 'carl friedrich gauss', ['غاوس', 'gauss']],
                    ['برنارد ريمان', 'bernhard riemann', ['ريمان', 'riemann']],

                    // Psychology
                    ['سيغموند فرويد', 'sigmund freud', ['فرويد', 'فرويد', 'freud']],

                    // Other Fields
                    ['جابر بن حيان', 'jabir ibn hayyan', ['جابر بن حيان', 'جابر ابن حيان']],
                    ['ابن سينا', 'ibn sina', ['ابن سينا', 'ابن سينا', 'avicenna']],
                ],
            ], [
                'text' => 'The main human sense organs',
                'text_ar' => 'أعضاء الحواس الخمس الرئيسية عند الإنسان',
                'category' => 'general',
                'difficulty' => 'easy',
                'accepted_answers' => [
                    // Sight
                    ['العين', 'eye', ['العينين', 'عين', 'عينين', 'eyes']],

                    // Hearing
                    ['الأذن', 'ear', ['الاذن', 'الأذنير', 'أذن', 'اذن', 'ears']],

                    // Smell
                    ['الأنف', 'nose', ['الانف', 'أنف', 'انف', 'nose']],

                    // Taste
                    ['اللسان', 'tongue', ['لسان', 'tongue']],

                    // Touch
                    ['الجلد', 'skin', ['جلد', 'البشرة', 'اللمس', 'skin']],
                ],
            ],

            [
                'text' => 'Core sports featured in the Summer Olympic Games',
                'text_ar' => 'الألعاب الرياضية الأساسية في الألعاب الأولمبية الصيفية',
                'category' => 'sports',
                'difficulty' => 'easy',
                'accepted_answers' => [
                    // Athletics / Track and field
                    ['ألعاب القوى', 'athletics', ['العاب القوى', 'الجري', 'المضمار والميدان', 'track and field']],

                    // Swimming / Aquatics
                    ['السباحة', 'swimming', ['السباحه', 'سباحة', 'aquatics']],

                    // Gymnastics
                    ['الجمباز', 'gymnastics', ['جمباز']],

                    // Football / Soccer
                    ['كرة القدم', 'football', ['الكرة', 'كرة قدم', 'soccer']],

                    // Basketball
                    ['كرة السلة', 'basketball', ['كرة سلة', 'سلة', 'basketball']],

                    // Boxing
                    ['الملاكمة', 'boxing', ['الملاكمه', 'ملاكمة', 'بوكسينغ', 'بوكسينج']],

                    // Tennis
                    ['التنس', 'tennis', ['تنس', 'كرة المضرب']],

                    // Weightlifting
                    ['رفع الأثقال', 'weightlifting', ['رفع الاثقال', 'الأثقال']],

                    // Cycling
                    ['ركوب الدراجات', 'cycling', ['الدراجات', 'العجل']],

                    // Fencing
                    ['المبارزة', 'fencing', ['المبارزه', 'مبارزة السيف']],

                    // Judo
                    ['الجودو', 'judo', ['جودو']],

                    // Wrestling
                    ['المصارعة', 'wrestling', ['المصارعه', 'مصارعة']],

                    // Volleyball
                    ['كرة الطائرة', 'volleyball', ['الكرة الطائرة', 'طايرة', 'طائرة']],

                    // Handball
                    ['كرة اليد', 'handball', ['يد', 'كرة يد']],

                    // Archery
                    ['الرماية بالقوس', 'archery', ['القوس والسهم', 'الرماية']],

                    // Rowing
                    ['التجديف', 'rowing', ['تجديف']],
                ],
            ],
            [
                'text' => 'Official sports featured in the Winter Olympic Games',
                'text_ar' => 'الألعاب الرياضية الرسمية في الألعاب الأولمبية الشتوية',
                'category' => 'sports',
                'difficulty' => 'medium',
                'accepted_answers' => [
                    // Ice Hockey
                    ['هوكي الجليد', 'ice hockey', ['هوكي', 'هوكى الجليد', 'hockey']],

                    // Figure Skating
                    ['التزلج الفني على الجليد', 'figure skating', ['التزلج الفني', 'figure skating']],

                    // Speed Skating
                    ['التزلج السريع', 'speed skating', ['speed skating']],

                    // Alpine Skiing
                    ['التزلج الألبي', 'alpine skiing', ['التزلج على المنحدرات', 'alpine skiing']],

                    // Cross-Country Skiing
                    ['تزلج ريف الكانتري', 'cross country skiing', ['تزلج ريفي', 'التزلج الريفي', 'cross-country']],

                    // Ski Jumping
                    ['قفز تزلجي', 'ski jumping', ['القفز التزلجي', 'القفز على الجليد', 'ski jumping']],

                    // Snowboarding
                    ['لوح التزلج', 'snowboarding', ['سنيوبورد', 'التزلج على اللوح', 'snowboard']],

                    // Curling
                    ['الكورلينج', 'curling', ['كورلينج', 'الشطرنج على الجليد']],

                    // Bobsleigh
                    ['البوبسلي', 'bobsleigh', ['عربة التزلج', 'زلاجة جماعية', 'bobsled']],

                    // Luge
                    ['الزحافات الثلجية', 'luge', ['لوج', 'الزحافات الثلجيه']],

                    // Skeleton
                    ['الهيكل العظمي سباق', 'skeleton', ['الزلاجات الصدرية', 'سباق السير العظمي']],

                    // Biathlon
                    ['البياتلون', 'biathlon', ['التزلج والرماية', 'البياثلون']],

                    // Ski Mountaineering (Official entry)
                    ['تزلج تسلق الجبال', 'ski mountaineering', ['التسلق التزلجي', 'ski mountaineering']],
                ],
            ],
            [
                'text' => 'Famous Egyptian dishes',
                'text_ar' => 'أكلات مصرية شهيرة',
                'category' => 'food',
                'difficulty' => 'easy',
                'accepted_answers' => [

                    ['كشري', 'koshari', ['koshary']],
                    ['فول', 'foul', ['ful']],
                    ['طعمية', 'taamiya', ['falafel']],
                    ['ملوخية', 'molokhia', []],
                    ['محشي', 'mahshi', []],
                    ['فتة', 'fattah', []],
                    ['حمام محشي', 'stuffed pigeon', []],
                    ['بسبوسة', 'basbousa', []],
                    ['كنافة', 'kunafa', []],
                    ['أم علي', 'om ali', []],
                    ['شوربة لسان عصفور', 'orzo soup', []],

                ],
            ],
        ];

        $categoryToType = [
            'football' => 'player',
            'entertainment' => 'actor',
            'cinema' => 'movie',
            'geography' => 'country',
            'sports' => 'competition',
            'food' => 'general',
            'history' => 'general',
            'music' => 'player',
            'science' => 'general',
            'language' => 'general',
            'animals' => 'general',
            'general' => 'general',
        ];

        foreach ($questions as $q) {
            $type = $categoryToType[$q['category']] ?? 'general';
            $resolvedIds = [];

            foreach ($q['accepted_answers'] as $ansRow) {
                if (empty($ansRow)) {
                    continue;
                }

                $nameAr = $ansRow[0] ?? '';
                $nameEn = $ansRow[1] ?? '';
                $fuzzy = $ansRow[2] ?? [];

                // Find if this GameItem already exists
                $existing = GameItem::where('type', $type)
                    ->where(function ($query) use ($nameAr, $nameEn) {
                        if ($nameAr && $nameEn) {
                            $query->where('name_ar', $nameAr)->orWhere('name_en', $nameEn);
                        } elseif ($nameAr) {
                            $query->where('name_ar', $nameAr);
                        } elseif ($nameEn) {
                            $query->where('name_en', $nameEn);
                        }
                    })->first();

                if ($existing) {
                    // Update name_ar, name_en, and fuzzy_variants / synonyms if missing
                    $updateData = [];
                    if (! $existing->name_ar && $nameAr) {
                        $updateData['name_ar'] = $nameAr;
                    }
                    if (! $existing->name_en && $nameEn) {
                        $updateData['name_en'] = $nameEn;
                    }

                    // Sync to synonyms and fuzzy_variants
                    $currentFuzzy = $existing->fuzzy_variants ?? [];
                    $newFuzzy = array_values(array_unique(array_merge($currentFuzzy, $fuzzy)));
                    if ($newFuzzy !== $currentFuzzy) {
                        $updateData['fuzzy_variants'] = $newFuzzy;
                    }

                    $metadata = $existing->metadata ?? [];
                    $synonyms = $metadata['synonyms'] ?? [];
                    $newSynonyms = array_values(array_unique(array_merge($synonyms, $fuzzy)));
                    if ($newSynonyms !== $synonyms) {
                        $metadata['synonyms'] = $newSynonyms;
                        $updateData['metadata'] = $metadata;
                    }

                    if (! empty($updateData)) {
                        $existing->update($updateData);
                    }

                    $resolvedIds[] = $existing->id;
                } else {
                    // Create new
                    $item = GameItem::create([
                        'type' => $type,
                        'name_ar' => $nameAr ?: null,
                        'name_en' => $nameEn ?: '',
                        'fuzzy_variants' => $fuzzy,
                        'metadata' => ['synonyms' => $fuzzy],
                        'is_active' => true,
                    ]);
                    $resolvedIds[] = $item->id;
                }
            }

            MazadQuestion::updateOrCreate(
                ['text' => $q['text']],
                [
                    'text_ar' => $q['text_ar'],
                    'category' => $q['category'],
                    'difficulty' => $q['difficulty'],
                    'accepted_answers' => array_values(array_unique($resolvedIds)),
                ]
            );
        }

        $this->command->info('Seeded '.count($questions).' Mazad questions linked to GameItems.');
    }
}
