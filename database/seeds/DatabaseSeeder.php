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
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(FoodbanksTableSeeder::class);
        $this->call(FoodbankUserTableSeeder::class);
        $this->call(FoodsTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(GoodiebagsTableSeeder::class);
        $this->call(FoodGoodiebagTableSeeder::class);

    }
}
