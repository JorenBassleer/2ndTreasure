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
        ]);
        User::updateOrCreate([
            'name' => 'Daklozenhulp Antwerpen ',
            'email' => 'daklozen@antwerpen.com',
            'password' => Hash::make('12345'),
            'address' => 'Belgiëlei 161/2',
            'city' => 'Antwerpen',
            'isFoodbank' => true,
            'postalcode' => '2018',
            'country' => 'België',
            'province' => 'Antwerpen',
            'phone' => '0485177696',
            'lat' => 51.2194475,
            'lng' => 4.4024643,
        ]);
        User::updateOrCreate([
            'name' => 'Dakhulp Antwerpen ',
            'email' => 'sss@antwerpen.com',
            'password' => Hash::make('12345'),
            'address' => 'Belgiëlei 161/2',
            'city' => 'Antwerpen',
            'isFoodbank' => true,
            'postalcode' => '2018',
            'country' => 'België',
            'province' => 'Antwerpen',
            'phone' => '0485177696',
            'lat' => 51.2034918,
            'lng' => 4.4151250,
        ]);
        for($i=5;$i<15; $i++) {
            User::updateOrCreate([
                'name' => 'Daklozenhulp Oostakker',
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
