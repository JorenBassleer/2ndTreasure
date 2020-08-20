<?php

use Illuminate\Database\Seeder;
use App\Goodiebag;
class GoodiebagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Goodiebag::updateOrCreate([
            'user_id' => 1,
            'foodbank_id' => 1,
            'hasReceived' => 1,
            'treasures' => 0.360,
        ]);
        Goodiebag::updateOrCreate([
            'user_id' => 2,
            'foodbank_id' => 1,
            'hasReceived' => 1,
            'treasures' => 0.112,
        ]);
        Goodiebag::updateOrCreate([
            'user_id' => 3,
            'foodbank_id' => 1,
            'hasReceived' => 0,
            'treasures' => 0.250,
        ]);

        Goodiebag::updateOrCreate([
            'user_id' => 1,
            'foodbank_id' => 1,
            'hasReceived' => 1,
            'treasures' => 0.336,
        ]);
    }
}
