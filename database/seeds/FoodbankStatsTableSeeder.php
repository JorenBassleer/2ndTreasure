<?php

use Illuminate\Database\Seeder;
use App\FoodbankStats;
class FoodbankStatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FoodbankStats::updateOrCreate([
            'foodbank_id' => 3,
            'total_amount_of_kg_received' => 36,
            'total_amount_of_treasures_generated' => 3.5,
            'total_amount_of_goodiebags_received' => 45,
        ]);
    }
}
