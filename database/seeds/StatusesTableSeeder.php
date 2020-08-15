<?php

use Illuminate\Database\Seeder;
use App\Status;
class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::updateOrCreate([
            'status' => 'Accepted',
        ]);
        Status::updateOrCreate([
            'status' => 'Pending',
        ]);
        Status::updateOrCreate([
            'status' => 'Declined',
        ]);
        Status::updateOrCreate([
            'status' => 'Completed',
        ]);

    }
}
