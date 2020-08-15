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
            'status_id' => 1,
        ]);
        Goodiebag::updateOrCreate([
            'user_id' => 2,
            'foodbank_id' => 1,
            'status_id' => 2,
        ]);
        Goodiebag::updateOrCreate([
            'user_id' => 3,
            'foodbank_id' => 1,
            'status_id' => 3,

        ]);
    }
}
