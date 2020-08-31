<?php

use Illuminate\Database\Seeder;
use App\WeeklyUserStats;
use Carbon\Carbon;
class WeeklyUserStatsTableSeeder extends Seeder
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
        
        WeeklyUserStats::updateOrCreate([
            'user_id' => 1,
            'number_of_treasures' => 12.10,
            'amount_of_kg_donated' => 2.3,
            'created_at' => $oneWeeksAgo,
            'updated_at' => $oneWeeksAgo,
        ]);
        WeeklyUserStats::updateOrCreate([
            'user_id' => 1,
            'number_of_treasures' => 4.20,
            'amount_of_kg_donated' => 1.3,
            'created_at' => $twoWeeksAgo,
            'updated_at' => $twoWeeksAgo,
        ]);
        WeeklyUserStats::updateOrCreate([
            'user_id' => 1,
            'number_of_treasures' => 11,
            'amount_of_kg_donated' => 4,
            'created_at' => $threeWeeksAgo,
            'updated_at' => $threeWeeksAgo,
        ]);
        WeeklyUserStats::updateOrCreate([
            'user_id' => 1,
            'number_of_treasures' => 18,
            'amount_of_kg_donated' => 12,
            'created_at' => $fourWeeksAgo,
            'updated_at' => $fourWeeksAgo,
        ]);
    }
}
