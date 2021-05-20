<?php

use Illuminate\Database\Seeder;
use App\Song;

class SongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Song::create([
            'title' => 'Walang Natira',
            'lyrics' => "Ako'y isang sirena",
            'artist_id' => 1
        ]);
    }
}
