<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'admin@local.com',
            'name' => 'Admin Admin',
            'password' => bcrypt('12345678'),
            'avatar' => 'storage/uploads/avatars/1624700484.png',
            'role_id' => 1
        ]);

        User::create([
            'email' => 'jane@local.com',
            'name' => 'Jane Doe',
            'password' => bcrypt('12345678'),
            'avatar' => 'storage/uploads/avatars/1624700627.png',
            'role_id' => 2
        ]);

        User::create([
            'email' => 'johnsmith@local.com',
            'name' => 'John Smith',
            'password' => bcrypt('12345678'),
            'avatar' => 'storage/uploads/avatars/1624700775.png',
            'role_id' => 3
        ]);
    }
}
