<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // je suis obliger pour la map davoir des code
        DB::table('countries')->insertOrIgnore([
            ['id_country' => 1, 'name_country' => 'France'],
            ['id_country' => 2, 'name_country' => 'Belgique'],
            ['id_country' => 3, 'name_country' => 'Suisse'],
            ['id_country' => 4, 'name_country' => 'Canada'],
        ]);
    }
}
