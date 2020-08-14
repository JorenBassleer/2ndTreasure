<?php

use Illuminate\Database\Seeder;
use App\FoodGoodiebag;
class FoodGoodiebagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FoodGoodiebag::updateOrCreate([
            'goodiebag_id' => 1,
            'food_id' => 2,
            'amount' => 10,
        ]);

        for($i=1;$i<5;$i++) {
            FoodGoodiebag::updateOrCreate([
                'goodiebag_id' => 1,
                'food_id' => $i,
                'amount' => 1.5 + $i,
            ]);
        }
    }
}
