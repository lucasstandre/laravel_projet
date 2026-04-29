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
                'photo' => 'public/images/midnight.jpg',
            ],
            [
                'nom' => 'Summer Hits',
                'photo' => 'public/images/summer.jpg',
            ],
            [
                'nom' => 'Dark Waves Album',
                'photo' => 'public/images/dark_waves.jpg',
            ],
            [
                'nom' => 'Neon Dreams',
                'photo' => 'public/images/neon.jpg',
            ],
            [
                'nom' => 'Acoustic Sessions',
                'photo' => 'public/images/acoustic.jpg',
            ],
            [
                'nom' => 'Urban Flow Vol.1',
                'photo' => 'public/images/urban.jpg',
            ],
            [
                'nom' => 'Ocean Eyes Project',
                'photo' => 'public/images/ocean.jpg',
            ],
            [
                'nom' => 'Electric Soul EP',
                'photo' => 'public/images/electric.jpg',
            ],
        ]);
    }
}
