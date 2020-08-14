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
            'first_name' => 'Joren',
            'last_name' => 'Bassleer ',
            'email' => 'joren@bassleer.com',
            'password' => Hash::make('12345'),
            'address' => 'Belgiëlei 161/2',
            'city' => 'Antwerpen',
            'postalcode' => '2018',
            'province' => 'Antwerpen',
            'phone' => '0485177696',
        ]);
        User::updateOrCreate([
            'first_name' => 'David',
            'last_name' => 'Frederickx ',
            'email' => 'David@Frederickx.com',
            'password' => Hash::make('12345'),
            'address' => 'Belgiëlei 161/2',
            'city' => 'Antwerpen',
            'postalcode' => '2018',
            'province' => 'Antwerpen',
            'phone' => '0485177696',
        ]);
        for($i=0;$i<15; $i++) {
            User::updateOrCreate([
                'first_name' => 'Een',
                'last_name' => 'Persoon ',
                'email' => 'persson@email.com' . $i,
                'password' => Hash::make('12345'),
                'address' => 'Achter de Wereld' ,
                'city' => 'Antwerpen',
                'postalcode' => '2018' ,
                'province' => 'Antwerpen',
                'phone' => '0485177696',
            ]);
        }
    }
}
