<?php

use Illuminate\Database\Seeder;
use App\WeeklyLeaderBoard;
class WeeklyLeaderBoardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WeeklyLeaderBoard::updateOrCreate([
            'user_id' => 1,
            'amount_of_kg' => 0.5
        ]);
        WeeklyLeaderBoard::updateOrCreate([
            'user_id' => 11,
            'amount_of_kg' => 2
        ]);
    }
}
