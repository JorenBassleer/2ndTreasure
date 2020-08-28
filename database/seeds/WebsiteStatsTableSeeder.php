<?php

use Illuminate\Database\Seeder;
use App\WebsiteStats;
class WebsiteStatsTableSeeder extends Seeder
{     
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WebsiteStats::updateOrCreate([
            'amount_of_foodbanks' => 26,
            'amount_of_users' => 50,
            'amount_of_kg_donated' => 230,
            'amount_of_treasures_created' => 312,
        ]);
    }
}
