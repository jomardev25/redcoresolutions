<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'admin@cms.local',
            'name' => 'Jane Doe',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'email' => 'jane@cms.local',
            'name' => 'Jane Doe',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'email' => 'john@cms.local',
            'name' => 'John Doe',
            'password' => bcrypt('123456')
        ]);
    }
}
