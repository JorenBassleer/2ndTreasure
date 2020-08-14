<?php

use Illuminate\Database\Seeder;
use App\Role;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::updateOrCreate([
            'role' => 'Chairman',
        ]);
        Role::updateOrCreate([
            'role' => 'Vice-chairman',
        ]);
        Role::updateOrCreate([
            'role' => 'Board member',
        ]);
        Role::updateOrCreate([
            'role' => 'Secretary',
        ]);
        Role::updateOrCreate([
            'role' => 'Worker',
        ]);
        Role::updateOrCreate([
            'role' => 'Other',
        ]);
    }
}
