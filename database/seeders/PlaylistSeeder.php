<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //maitenant dans booted de user
        DB::table('playlists')->insert([
            [
            // ca va etre sonora id_creator 1
            'id_creator' => 1,
            'playlist' => 'Top 10 de la semaine',
            'description' => 'Top 10 chanson de la semaine',
            'link' => 'TOP10', //fonction de creation de link, seulement cree si la playlist est public
            'original' => true,
            ],
            [

            'id_creator' => 1,
            'playlist' => 'Favoris des dev',
            'description' => 'Les tounes favorites des developeur',
            'link' => 'Dev_fav', //fonction de creation de link, seulement cree si la playlist est public
            'original' => true,
            ],
            [
            'id_creator' => 1,
            'playlist' => 'Playlist public de test',
            'description' => 'Playlist public de test',
            'link' => 'TEST', //fonction de creation de link, seulement cree si la playlist est public
            'original' => true,
            ]
        ]);
    }
}
