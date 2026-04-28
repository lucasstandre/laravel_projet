<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Sonora',
            'email' => 'test@example.com',
            'password' => Hash::make('password'), // forcer a faire un password password pcq ca marchait pu
            'role' => 1,
        ]);
        User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'password' => Hash::make('password'),
            'role' => 1,
        ]);
        $this->call([
        // Vous pouvez ajouter d’autres "seeders" en les séparant par des virgules.
            GenreSeeder::class,
            PlaylistSeeder::class,
            AlbumSeeder::class,
            ChansonSeeder::class,
            PlaylistChansonSeeder::class,
            CountrySeeder::class
        ]);
    }
}
