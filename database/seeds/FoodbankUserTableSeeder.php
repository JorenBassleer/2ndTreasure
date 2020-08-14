<?php

use Illuminate\Database\Seeder;
use App\FoodbankUser;
class FoodbankUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FoodbankUser::updateOrCreate([
            'foodbank_id' => 1,
            'user_id' => 2,
            'role_id' => 1,
        ]);
        FoodbankUser::updateOrCreate([
            'foodbank_id' => 1,
            'user_id' => 1,
            'role_id' => 2,
        ]);
    }
}
