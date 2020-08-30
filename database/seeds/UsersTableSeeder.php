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
        User::updateOrCreate([
            'name' => 'Tele-Dienst ',
            'email' => 'Teledienst@skynet.be',
            'password' => Hash::make('12345'),
            'address' => 'Schermersstraat 7',
            'city' => 'Antwerpen',
            'isFoodbank' => true,
            'postalcode' => '2000',
            'country' => 'België',
            'province' => 'Antwerpen',
            'phone' => '0485177696',
            'lat' => 51.212310,
            'lng' => 4.404520,
        ]);


        for($i=5;$i<15; $i++) {
            User::updateOrCreate([
                'name' => 'Gebruiker',
                'email' => 'persson@email.com' . $i,
                'password' => Hash::make('12345'),
                'address' => 'Achter de Wereld' ,
                'city' => 'Antwerpen',
                'country' => 'België',
                'postalcode' => '2018' ,
                'province' => 'Antwerpen',
                'phone' => '0485177696',
            ]);
        }
    }
}
