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
        DB::table('playlists')->insert([
            [
                //user, dans ce cas lier a lui meme
            //'id_creator' => $user->id_utilisateur, lier a lui meme
            'id_creator' => 1,
            'playlist' => 'Liked',
            'description' => 'Mes chansons aimers',
            'link' => '', //fonction de creation de link, seulement cree si la playlist est public
            'original' => true,
            ],
            [
                //user, dans ce cas lier a lui meme
            //'id_creator' => $user->id_utilisateur, lier a lui meme
            'id_creator' => 2,

            'playlist' => 'Liked',
            'description' => 'Mes chansons aimers',
            'link' => '', //fonction de creation de link, seulement cree si la playlist est public
            'original' => true,
            ],
            [
                //user, dans ce cas lier a lui meme
            //'id_creator' => $user->id_utilisateur, lier a lui meme
            'id_creator' => 1,

            'playlist' => 'Playlist public de test',
            'description' => 'Playlist public de test',
            'link' => 'TEST', //fonction de creation de link, seulement cree si la playlist est public
            'original' => true,
            ]
        ]);
    }
}
