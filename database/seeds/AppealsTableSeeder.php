<?php

use Illuminate\Database\Seeder;
use App\Appeal;
class AppealsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Appeal::updateOrCreate([
            'foodbank_id' => 1,
            'user_id' => 2,
            'status_id' => 2,
            'goodiebag_id' => 1,
        ]);
        Appeal::updateOrCreate([
            'foodbank_id' => 1,
            'user_id' => 3,
            'status_id' => 3,
            'goodiebag_id' => 2,
        ]);
        Appeal::updateOrCreate([
            'foodbank_id' => 1,
            'user_id' => 5,
            'status_id' => 3,
            'goodiebag_id' => 3,
        ]);
        Appeal::updateOrCreate([
            'foodbank_id' => 2,
            'user_id' => 1,
            'status_id' => 3,
            'goodiebag_id' => 4,
        ]);
    }
}
