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
            'type' => 'Water',
            'value' => 3,
        ]);
        Food::updateOrCreate([
            'type' => 'Fruits',
            'value' => 0.5,
        ]);
        Food::updateOrCreate([
            'type' => 'Vegetables',
            'value' => 0.5,
        ]);
        Food::updateOrCreate([
            'type' => 'Bread',
            'value' => 3,
        ]);
        Food::updateOrCreate([
            'type' => 'Dairy',
            'value' => 2,
        ]);
        Food::updateOrCreate([
            'type' => 'Fish',
            'value' => 4,
        ]);
        Food::updateOrCreate([
            'type' => 'Meat',
            'value' => 2.5,
        ]);
        Food::updateOrCreate([
            'type' => 'Body_care',
            'value' => 3,
        ]);
        Food::updateOrCreate([
            'type' => 'Other',
        ]);

    }
}
