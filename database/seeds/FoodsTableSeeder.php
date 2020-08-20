<?php

use Illuminate\Database\Seeder;
use App\Food;
class FoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Food::updateOrCreate([
            'type' => 'water',
            'value' => 0.2700,
            'avgWeightPer' => 1,
        ]);
        Food::updateOrCreate([
            'type' => 'fruits',
            'value' => 0.1000,
            'avgWeightPer' =>0.658,
        ]);
        Food::updateOrCreate([
            'type' => 'vegetables',
            'value' => 0.1000,
            'avgWeightPer' =>0.168,
        ]);
        Food::updateOrCreate([
            'type' => 'bread',
            'value' => 0.1600,
            'avgWeightPer' => 0.038,
        ]);
        Food::updateOrCreate([
            'type' => 'dairy',
            'value' => 0.0140,
            'avgWeightPer' => 1.029,
        ]);
        Food::updateOrCreate([
            'type' => 'fish',
            'value' => 0.0071,
        ]);
        Food::updateOrCreate([
            'type' => 'meat',
            'value' => 0.0064,
        ]);
        Food::updateOrCreate([
            'type' => 'body_care',
            'value' => 0.5000,
        ]);
        Food::updateOrCreate([
            'type' => 'other',
            'value' => 0.1510,
        ]);

    }
}
