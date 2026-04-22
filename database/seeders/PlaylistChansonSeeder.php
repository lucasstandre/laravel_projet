<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaylistChansonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            DB::table('ta_playlist_chanson')->insert([
            //seed les chanson dans la playlist top10 id playlist 1
            [
                'id_playlist' => 1,
                'id_chanson' => 1,
                //'chanson_playlist' => ? jen ai tu besoin
                'date_ajout' => now(),
            ],
            [
                'id_playlist' => 1,
                'id_chanson' => 2,
                //'chanson_playlist' => ? jen ai tu besoin
                'date_ajout' => now(),
            ],

            // seed dune autre playlist
            [
                'id_playlist' => 2,
                'id_chanson' => 1,
                //'chanson_playlist' => ? jen ai tu besoin
                'date_ajout' => now(),
            ],
            [
                'id_playlist' => 2,
                'id_chanson' => 4,
                //'chanson_playlist' => ? jen ai tu besoin
                'date_ajout' => now(),
            ]
        ]);
    }
}
