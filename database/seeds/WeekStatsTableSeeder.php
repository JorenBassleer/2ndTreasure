<?php

use Illuminate\Database\Seeder;
use App\WeekStats;
class WeekStatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Weekstats::updateOrCreate([
            'amount_of_foodbanks' => 26,
            'amount_of_users' => 50,
            'amount_of_kg_donated' => 67.8,
            'amount_of_treasures_created' => 12.7,
        ]);
    }
}
