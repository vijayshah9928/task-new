<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Role::insert([
            ['name' => 'Super Admin', 'description' => 'Super Admin Role'],
            ['name' => 'Admin', 'description' => 'Admin Role'],
            ['name' => 'User', 'description' => 'User Role'],
        ]);

    }
}
