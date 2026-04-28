<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insertOrIgnore([
            ['id_country' => 1, 'nom' => 'France'],
            ['id_country' => 2, 'nom' => 'Belgique'],
            ['id_country' => 3, 'nom' => 'Suisse'],
            ['id_country' => 4, 'nom' => 'Canada'],
            ['id_country' => 5, 'nom' => 'Allemagne'],
            ['id_country' => 6, 'nom' => 'Espagne'],
            ['id_country' => 7, 'nom' => 'Italie'],
            ['id_country' => 8, 'nom' => 'Pays-Bas'],
            ['id_country' => 9, 'nom' => 'Portugal'],
            ['id_country' => 10, 'nom' => 'Québec'],
            ['id_country' => 11, 'nom' => 'États-Unis'],
            ['id_country' => 12, 'nom' => 'Royaume-Uni'],
            ['id_country' => 13, 'nom' => 'Suède'],
            ['id_country' => 14, 'nom' => 'Norvège'],
            ['id_country' => 15, 'nom' => 'Danemark'],
        ]);
    }
}
