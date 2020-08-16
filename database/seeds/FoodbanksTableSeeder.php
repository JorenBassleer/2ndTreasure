<?php

use Illuminate\Database\Seeder;
use App\Foodbank;
class FoodbanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Foodbank::create([
            'foodbank_name' => 'Daklozenhulp Antwerpen',
            'foodbank_email' => 'info@daklozenhulpantwerpen.be',
            'foodbank_address' => 'Lange Van Ruusbroecstraat 86',
            'foodbank_city' => 'Antwerpen',
            'foodbank_postalcode' => '2018',
            'foodbank_province' => 'Antwerpen',
            'foodbank_phone' => '0468 318 104',
            'company_number' => 'BE54 0001 0968 7697',
        ]);
        Foodbank::create([
            'foodbank_name' => 'Daklozenhulp Oostakker',
            'foodbank_email' => 'info@Oostakker.be',
            'foodbank_address' => 'Lange Van Ruusbroecstraat 86',
            'foodbank_city' => 'Oostakker',
            'foodbank_postalcode' => '2018',
            'foodbank_province' => 'Antwerpen',
            'foodbank_phone' => '0468 3158 104',
            'company_number' => 'BE54 401 0968 7697',
        ]);
    }
}
