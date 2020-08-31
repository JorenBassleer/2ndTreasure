<?php

use Illuminate\Database\Seeder;
use App\WeeklyFoodbankStats;
use Carbon\Carbon;
class WeeklyFoodbankStatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fourWeeksAgo = Carbon::now()->subWeeks(4);
        $threeWeeksAgo = Carbon::now()->subWeeks(3);
        $twoWeeksAgo = Carbon::now()->subWeeks(2);
        $oneWeeksAgo = Carbon::now()->subWeeks(1);

        WeeklyFoodbankStats::updateOrCreate([
            'user_id' => 2,
            'amount_of_kg_received' => 32,
            'amount_of_treasures_generated' => 58,
            'amount_of_goodiebags_received' => 66,
            'created_at' => $oneWeeksAgo,
            'updated_at' => $oneWeeksAgo,
        ]);
        WeeklyFoodbankStats::updateOrCreate([
            'user_id' => 2,
            'amount_of_kg_received' => 14,
            'amount_of_treasures_generated' => 22,
            'amount_of_goodiebags_received' => 18,
            'created_at' => $twoWeeksAgo,
            'updated_at' => $twoWeeksAgo,
        ]);
        WeeklyFoodbankStats::updateOrCreate([
            'user_id' => 2,
            'amount_of_kg_received' => 18,
            'amount_of_treasures_generated' => 25,
            'amount_of_goodiebags_received' => 30,
            'created_at' => $threeWeeksAgo,
            'updated_at' => $threeWeeksAgo,
        ]);
        WeeklyFoodbankStats::updateOrCreate([
            'user_id' => 2,
            'amount_of_kg_received' => 15,
            'amount_of_treasures_generated' => 28,
            'amount_of_goodiebags_received' => 33,
            'created_at' => $fourWeeksAgo,
            'updated_at' => $fourWeeksAgo,
        ]);
    }
}
