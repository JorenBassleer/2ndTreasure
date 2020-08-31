<?php

use Illuminate\Database\Seeder;
use App\AllTimeLeaderBoard;
class AllTimeLeaderBoardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AllTimeLeaderBoard::updateOrCreate([
            'user_id' => 1,
            'amount_of_kg' => 12.75,
        ]);
        AllTimeLeaderBoard::updateOrCreate([
            'user_id' => 11,
            'amount_of_kg' => 10.2,
        ]);
        AllTimeLeaderBoard::updateOrCreate([
            'user_id' => 17,
            'amount_of_kg' => 20.8,
        ]);
        AllTimeLeaderBoard::updateOrCreate([
            'user_id' => 12,
            'amount_of_kg' => 10.02,
        ]);
        AllTimeLeaderBoard::updateOrCreate([
            'user_id' => 13,
            'amount_of_kg' => 1.8,
        ]);
        AllTimeLeaderBoard::updateOrCreate([
            'user_id' => 14,
            'amount_of_kg' => 0.5,
        ]);
        AllTimeLeaderBoard::updateOrCreate([
            'user_id' => 15,
            'amount_of_kg' => 11,
        ]);
        AllTimeLeaderBoard::updateOrCreate([
            'user_id' => 16,
            'amount_of_kg' => 18,
        ]);
    }
}
