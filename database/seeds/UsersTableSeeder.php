<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::updateOrCreate([
            'name' => 'Joren Bassleer ',
            'email' => 'joren@bassleer.com',
            'password' => Hash::make('12345'),
            'address' => 'Belgiëlei 161/2',
            'city' => 'Antwerpen',
            'postalcode' => '2018',
            'province' => 'Antwerpen',  
            'country' => 'België',
            'phone' => '0485177696',
            'treasures' => 810,
        ]);
        User::updateOrCreate([
            'name' => 'Daklozenhulp Antwerpen vzw ',
            'email' => 'info@daklozenhulpantwerpen.be',
            'password' => Hash::make('12345'),
            'address' => 'Minkelersstraat 2',
            'city' => 'Antwerpen',
            'isFoodbank' => true,
            'postalcode' => '2018',
            'country' => 'België',
            'province' => 'Antwerpen',
            'phone' => '+3232362263',
            'lat' => 51.207370,
            'lng' => 4.437280,
        ]);
        $foodbank = User::find(2);
        $foodbank->foodbank()->create([
         'company_number' => 'BE54 0001 0968 7697',
         'details' => 'De vzw Daklozenhulp Antwerpen heeft als doel concrete hulp te bieden aan mensen uit Antwerpen en omstreken die om welke reden dan ook op of onder de armoedegrens leven en daardoor soms onvoldoende middelen (over)hebben om voldoende voedsel te kunnen kopen. De organisatie stelt zich slechts als doel om via een wekelijkse voedselbedeling een kwalitatieve aanvulling te bieden.',
         'website' => 'http://www.daklozenhulpantwerpen.be/',
         'opening_hours' => 'Voorbereiding: 12u00 - 17u00
                            Deuren open: 15u00
                            Bedeling: 17u00
                            Eind bedeling: 18u00',
        ]);
        User::updateOrCreate([
            'name' => 'Tele-Dienst',
            'email' => 'Teledienst@skynet.be',
            'password' => Hash::make('12345'),
            'address' => 'Schermersstraat 7',
            'city' => 'Antwerpen',
            'isFoodbank' => true,
            'postalcode' => '2000',
            'country' => 'België',
            'province' => 'Antwerpen',
            'phone' => '+3232307879',
            'lat' => 51.212310,
            'lng' => 4.404520,
        ]);
        $foodbank = User::find(3);
        $foodbank->foodbank()->create([
         'company_number' => 'BE54 401 0968 7697',
         'details' => 'De activiteiten van Tele-Dienst vzw, opgericht in 1968, situeren zich binnen het sociaal en maatschappelijk werkveld en worden uitsluitend gedragen door vrijwilligers. Tele-Dienst is een vaste waarde binnen het Antwerpse netwerk van organisaties die zich concentreren op armoedebestrijding.',
         'website' => 'https://www.tele-dienst.be/',
         'opening_hours' => 'OP AFSPRAAK  op dinsdag en op vrijdag, telkens van 9.30 uur tot 12.30 uur.',
        ]);
        User::updateOrCreate([
            'name' => 'Zenith vzw',
            'email' => 'info@zenithvzw.be',
            'password' => Hash::make('12345'),
            'address' => 'De Marbaixstraat 22',
            'city' => 'Antwerpen',
            'isFoodbank' => true,
            'postalcode' => '2060',
            'country' => 'België',
            'province' => 'Antwerpen',
            'phone' => '+3232131575',
            'lat' => 51.227800,
            'lng' => 4.437640,
        ]);
        $foodbank = User::find(4);
        $foodbank->foodbank()->create([
         'company_number' => 'BE92 2200 3229 0023',
         'details' => 'Zenith biedt elke week morele en materiële hulpverlening aan behoeftigen, politieke vluchtelingen en kandidaat-vluchtelingen.',
         'website' => 'http://www.zenithvzw.be/',
         'opening_hours' => 'Maandag van 13u tot 15.30u. Donderdag van 13u tot 15.30u. Binnenbrengen van kleding en/of ander materiaal: maandag en donderdag tussen 10u & 12u.',

        ]);
        User::updateOrCreate([
            'name' => 'S.O.S - H.A.M.I.N.',
            'email' => 'sos.hamin.vzw@gmail.com',
            'password' => Hash::make('12345'),
            'address' => 'Leeuwlantstraat 129',
            'city' => 'Antwerpen',
            'isFoodbank' => true,
            'postalcode' => '2100',
            'country' => 'België',
            'province' => 'Antwerpen',
            'phone' => '+3233261040',
            'lat' => 51.224120,
            'lng' => 4.465760,
        ]);
        $foodbank = User::find(5);
        $foodbank->foodbank()->create([
         'company_number' => 'BE92 2212 3589 0023',
         'details' => 'SOS HAMIN vzw zet zich sinds 1989 in voor de armsten in Deurne.  Met vrijwilligers verdelen we materiaal en voeding aan gezinnen en alleenstaanden die het financieel zeer moeilijk hebben.', 
         'website' => 'https://sites.google.com/view/soshaminvzw',
         'opening_hours' => 'dinsdagvoormiddag van 10:00 tot 12:00 
                            donderdagnamiddag van 14:00 tot 16:30
                            vrijdagnamiddag van 14:00 tot 16:30 ',
         ]);
        User::updateOrCreate([
            'name' => 'Welzijnsschakel Wilrijk',
            'email' => 'welzijnsschakelwilrijk@gmail.com',
            'password' => Hash::make('12345'),
            'address' => 'Koornbloemstraat 57',
            'city' => 'Antwerpen',
            'isFoodbank' => true,
            'postalcode' => '2610',
            'country' => 'België',
            'province' => 'Antwerpen',
            'phone' => '0475 58 81 74',
            'lat' => 51.170020,
            'lng' => 4.384710,
        ]);
        $foodbank = User::find(6);
        $foodbank->foodbank()->create([
         'company_number' => 'BE92 2212 3589 1023',
         'website' => 'https://welzijnsschakelwilrijk.weebly.com/',
         'opening_hours' => 'Maandag van 18u00 tot 19u00
                            Woensdag van 10u30 tot 12u00
                            Donderdag van 10u30 tot 12u00',
         ]);
        User::updateOrCreate([
            'name' => '\'t Verhoog',
            'email' => 'samenleving-gezin@hamme.be',
            'password' => Hash::make('12345'),
            'address' => 'Hoogstraat 20',
            'city' => 'Hamme',
            'isFoodbank' => true,
            'postalcode' => '9220',
            'country' => 'België',
            'province' => 'Oost-Vlaanderen',
            'phone' => '052 47 55 31',
            'lat' => 51.0985385,
            'lng' => 4.13139105115804,
        ]);
        $foodbank = User::find(7);
        $foodbank->foodbank()->create([
            'company_number' => 'BE41 2212 3589 0654',
            'details' => 'Het sociaal ontmoetingscentrum \'t Verhoog is een plaats waar kansengroepen gebruik maken van de voedselbedeling, elkaar kunnen ontmoeten, vorming volgen en hun sociaal netwerk uitbouwen.',
            'website' => 'https://www.hamme.be/soc-t-verhoog',
            'opening_hours' => 'Maandag	van 09:00 tot 12:00 (enkel op afspraak)
                                Dinsdag	van 09:00 tot 12:00 (enkel op afspraak)
                                Woensdag	van 09:00 tot 12:00 (enkel op afspraak), van 13:30 tot 16:30 (enkel op afspraak)
                                Donderdag	van 09:00 tot 12:00 (enkel op afspraak)
                                Vrijdag	van 09:00 tot 12:00 (enkel op afspraak)
                                Zaterdag	van 09:00 tot 12:00 (enkel op afspraak)
                                Zondag	gesloten',
         ]);
        User::updateOrCreate([
            'name' => 'Lava Consult NV',
            'email' => 'lava-nv@consult.be',
            'password' => Hash::make('12345'),
            'address' => 'Lokerenbaan 20',
            'city' => 'Zele',
            'isFoodbank' => true,
            'postalcode' => '9240',
            'country' => 'België',
            'province' => 'Oost-Vlaanderen',
            'phone' => '+3252458370',
            'lat' => 51.07155185,
            'lng' => 4.04050642519191,
        ]);
        $foodbank = User::find(8);
        $foodbank->foodbank()->create();
        User::updateOrCreate([
            'name' => 'Voedselbank stichting Goed Ontmoet',
            'email' => 'info@goedontmoet.com',
            'password' => Hash::make('12345'),
            'address' => 'Abraham de Haanstraat 14',
            'city' => 'Bergen op Zoom',
            'isFoodbank' => true,
            'postalcode' => '9240',
            'country' => 'Nederland',
            'province' => 'Noord-Brabant',
            'phone' => '0164–270290',
            'lat' => 51.483194,
            'lng' => 4.299243,
        ]);
        $foodbank = User::find(9);
        $foodbank->foodbank()->create([
            'details' => 'Ook in West-Brabant en Zeeland leven veel mensen op of onder de armoedegrens. De voedselbanken helpen deze mensen door ze tijdelijk voedselpakketten te geven. Om onze klanten voldoende voedsel te kunnen geven, werken wij samen met bedrijven, instellingen en overheden. Zo zorgen we er samen voor dat armoede wordt bestreden, voedselverspilling wordt voorkomen en het milieu minder wordt belast.',
            'website' => 'https://www.goedontmoet.com/',
            'opening_hours' => 'Vrijdag tussen 14.00 – 18.30 uur',
         ]);
        User::updateOrCreate([
            'name' => 'Stichting Voedselbank Bevelanden',
            'email' => 'coordinator@voedselbankdebevelanden.nl',
            'password' => Hash::make('12345'),
            'address' => 'Middelburgsestraat 23',
            'city' => 'Goes',
            'isFoodbank' => true,
            'postalcode' => '4461',
            'country' => 'Nederland',
            'province' => 'Zeeland',
            'phone' => '0164–270290',
            'lat' => 51.505453,
            'lng' => 3.881958,
        ]);
        $foodbank = User::find(10);
        $foodbank->foodbank()->create([
            'company_number' => 'NL48RABO0101312296',
            'website' => 'http://www.voedselbankdebevelanden.nl/',
            'opening_hours' => 'Maandag-,  woensdag en vrijdagmiddag van 13:00 uur tot 15:00 uur.
                                Uitgifte voedselpakketten van 15:30 uur – 17:00 uur .',
         ]);
        User::updateOrCreate([
            'name' => 'Berend Bassleer ',
            'email' => 'berend@bassleer.com',
            'password' => Hash::make('12345'),
            'address' => 'Achter de Wereld 1',
            'city' => 'Herselt',
            'postalcode' => '2020',
            'province' => 'Antwerpen',  
            'country' => 'België',
            'phone' => '048557696',
            'treasures' => 222,
        ]);
        User::updateOrCreate([
            'name' => 'Katinka Bassleer ',
            'email' => 'katinka@bassleer.com',
            'password' => Hash::make('12345'),
            'address' => 'Achter de Wereld 1',
            'city' => 'Herselt',
            'postalcode' => '2020',
            'province' => 'Antwerpen',  
            'country' => 'België',
            'phone' => '048557696',
            'treasures' => 11,
        ]);
        User::updateOrCreate([
            'name' => 'Gerald Bassleer ',
            'email' => 'gerald@bassleer.com',
            'password' => Hash::make('12345'),
            'address' => 'Achter de Wereld 1',
            'city' => 'Herselt',
            'postalcode' => '2020',
            'province' => 'Antwerpen',  
            'country' => 'België',
            'phone' => '048557696',
            'treasures' => 11,
        ]);
        User::updateOrCreate([
            'name' => 'Tom Verschueren ',
            'email' => 'tom@verschueren.com',
            'password' => Hash::make('12345'),
            'address' => 'Achter de Wereld 1',
            'city' => 'Herselt',
            'postalcode' => '2020',
            'province' => 'Antwerpen',  
            'country' => 'België',
            'phone' => '048557696',
            'treasures' => 11,
        ]);
        User::updateOrCreate([
            'name' => 'Mark van den broek ',
            'email' => 'mark@vandenbroek.com',
            'password' => Hash::make('12345'),
            'address' => 'Achter de Wereld 1',
            'city' => 'Herselt',
            'postalcode' => '2020',
            'province' => 'Antwerpen',  
            'country' => 'België',
            'phone' => '048557696',
            'treasures' => 11,
        ]);
        User::updateOrCreate([
            'name' => 'Frank Gillhaus ',
            'email' => 'frank@gillhaus.com',
            'password' => Hash::make('12345'),
            'address' => 'Achter de Wereld 1',
            'city' => 'Herselt',
            'postalcode' => '2020',
            'province' => 'Antwerpen',  
            'country' => 'België',
            'phone' => '048557696',
            'treasures' => 11,
        ]);
        User::updateOrCreate([
            'name' => 'Rudy Verboven ',
            'email' => 'rudy@verboven.com',
            'password' => Hash::make('12345'),
            'address' => 'Achter de Wereld 1',
            'city' => 'Herselt',
            'postalcode' => '2020',
            'province' => 'Antwerpen',  
            'country' => 'België',
            'phone' => '048557696',
            'treasures' => 11,
        ]);
    }
}
