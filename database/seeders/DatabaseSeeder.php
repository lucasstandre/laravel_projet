<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pays;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            PaysSeeder::class,
            GenreSeeder::class,
        ]);

        //Prend canada aussi non le premier
        $canada = \App\Models\Country::first();

        \App\Models\User::factory()->create([
            'name' => 'Artiste Un',
            'email' => 'artiste1@example.com',
            'id_country' => $canada->id_country,
        ]); // Deviendra l'ID 1

        \App\Models\User::factory()->create([
            'name' => 'Artiste Deux',
            'email' => 'artiste2@example.com',
            'id_country' => $canada->id_country,
        ]); // Deviendra l'ID 2

        \App\Models\User::factory()->create([
            'name' => 'Artiste Trois',
            'email' => 'artiste3@example.com',
            'id_country' => $canada->id_country,
        ]);


        $this->call([
            // Vous pouvez ajouter d’autres "seeders" en les séparant par des virgules.
            PlaylistSeeder::class,
            AlbumSeeder::class,
            ChansonSeeder::class,
            PlaylistChansonSeeder::class,
            CountrySeeder::class,
            LocalisationSeeder::class,
        ]);
    }
}
