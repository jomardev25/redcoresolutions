<?php

use Illuminate\Database\Seeder;
use App\Artist;

class ArtistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artist::create([
            'name' => 'Gloc 9'
        ]);

        Artist::create([
            'name' => 'Prokya ni Edgar'
        ]);

        Artist::create([
            'name' => 'Sponge Cola'
        ]);

        Artist::create([
            'name' => 'Cueshe'
        ]);
    }
}
