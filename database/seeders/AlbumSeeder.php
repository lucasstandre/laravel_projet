<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlbumSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('albums')->insert([
            [
                'nom' => 'Midnight Collection',
                'photo' => 'midnight.jpg',
            ],
            [
                'nom' => 'Summer Hits',
                'photo' => 'summer.jpg',
            ],
            [
                'nom' => 'Dark Waves Album',
                'photo' => 'dark_waves.jpg',
            ],
            [
                'nom' => 'Neon Dreams',
                'photo' => 'neon.jpg',
            ],
            [
                'nom' => 'Acoustic Sessions',
                'photo' => 'acoustic.jpg',
            ],
            [
                'nom' => 'Urban Flow Vol.1',
                'photo' => 'urban.jpg',
            ],
            [
                'nom' => 'Ocean Eyes Project',
                'photo' => 'ocean.jpg',
            ],
            [
                'nom' => 'Electric Soul EP',
                'photo' => 'electric.jpg',
            ],
        ]);
    }
}
