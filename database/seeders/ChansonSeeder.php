<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ChansonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chansons')->insert([
        [
            'nom' => 'Midnight Vibes',
            'duree' => 210,
            'description' => 'Chanson chill pour relaxer.',
            'date_sortie' => '2024-01-10',
            'fichier' => 'midnight_vibes.mp3',
            'like' => 120,
            'id_album' => 1,
            'id_genre' => 2,
            'id_artiste' => 1,
        ],
        [
            'nom' => 'Summer Heat',
            'duree' => 185,
            'description' => 'Son parfait pour l’été.',
            'date_sortie' => '2023-07-22',
            'fichier' => 'summer_heat.mp3',
            'like' => 540,
            'id_album' => 2,
            'id_genre' => 3,
            'id_artiste' => 2,
        ],
        [
            'nom' => 'Dark Waves',
            'duree' => 240,
            'description' => 'Ambiance sombre et profonde.',
            'date_sortie' => '2022-11-05',
            'fichier' => 'dark_waves.mp3',
            'like' => 980,
            'id_album' => 3,
            'id_genre' => 1,
            'id_artiste' => 1,
        ],
        [
            'nom' => 'Neon Nights',
            'duree' => 200,
            'description' => 'Vibe électronique futuriste.',
            'date_sortie' => '2024-03-18',
            'fichier' => 'neon_nights.mp3',
            'like' => 320,
            'id_album' => 1,
            'id_genre' => 4,
            'id_artiste' => 3,
        ],
        [
            'nom' => 'Acoustic Dreams',
            'duree' => 195,
            'description' => 'Guitare douce et émotion.',
            'date_sortie' => '2021-09-30',
            'fichier' => 'acoustic_dreams.mp3',
            'like' => 760,
            'id_album' => 2,
            'id_genre' => 5,
            'id_artiste' => 2,
        ],
        [
            'nom' => 'Urban Flow',
            'duree' => 230,
            'description' => 'Rap urbain énergique.',
            'date_sortie' => '2023-05-14',
            'fichier' => 'urban_flow.mp3',
            'like' => 1500,
            'id_album' => 4,
            'id_genre' => 3,
            'id_artiste' => 1,
        ],
        [
            'nom' => 'Ocean Eyes',
            'duree' => 205,
            'description' => 'Atmosphère calme et émotionnelle.',
            'date_sortie' => '2020-12-01',
            'fichier' => 'ocean_eyes.mp3',
            'like' => 2300,
            'id_album' => 5,
            'id_genre' => 2,
            'id_artiste' => 3,
        ],
        [
            'nom' => 'Electric Soul',
            'duree' => 225,
            'description' => 'Fusion électro et soul.',
            'date_sortie' => '2024-02-14',
            'fichier' => 'electric_soul.mp3',
            'like' => 890,
            'id_album' => 1,
            'id_genre' => 4,
            'id_artiste' => 2,
        ]
    ]);
    }
}
