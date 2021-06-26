<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Super Administrator',
            'description' => 'Super Administrator'
        ]);

        Role::create([
            'name' => 'Editor',
            'description' => 'Editor'
        ]);

        Role::create([
            'name' => 'Writer',
            'description' => 'Writer'
        ]);
    }
}
