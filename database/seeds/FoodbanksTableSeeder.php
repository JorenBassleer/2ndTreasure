<?php

use Illuminate\Database\Seeder;
use App\Foodbank;
use Illuminate\Support\Facades\Hash;
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
            'user_id' => 2,
            'company_number' => 'BE54 0001 0968 7697',
        ]);
        Foodbank::create([
            'user_id' => 5,
            'company_number' => 'BE54 401 0968 7697',
        ]);
    }
}
