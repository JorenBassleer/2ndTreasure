<?php

use Illuminate\Database\Seeder;
use App\UserStats;
class UserStatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserStats::updateOrCreate([
            'user_id' => 1,
            'highest_place_ever' => 15,
            'highest_number_of_treasures' => 6.4,
            'total_amount_of_kg_donated' => 5.6,

        ]);
    }
}
