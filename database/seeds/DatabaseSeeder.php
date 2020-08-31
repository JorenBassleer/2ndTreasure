<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(FoodsTableSeeder::class);
        $this->call(GoodiebagsTableSeeder::class);
        $this->call(FoodGoodiebagTableSeeder::class);
        $this->call(FoodbankStatsTableSeeder::class);
        $this->call(UserStatsTableSeeder::class);
        $this->call(WebsiteStatsTableSeeder::class);
        $this->call(WeeklyUserStatsTableSeeder::class);
        $this->call(WeeklyFoodbankStatsTableSeeder::class);
        $this->call(AllTimeLeaderBoardsTableSeeder::class);
        $this->call(WeeklyLeaderBoardsTableSeeder::class);
    }
}
