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
            ['id_country' => 1, 'name_country' => 'France', 'code' => 'FR'],
            ['id_country' => 2, 'name_country' => 'Belgique', 'code' => 'BE'],
            ['id_country' => 3, 'name_country' => 'Suisse', 'code' => 'CH'],
            ['id_country' => 4, 'name_country' => 'Canada', 'code' => 'CA'],
            ['id_country' => 5, 'name_country' => 'Allemagne', 'code' => 'DE'],
            ['id_country' => 6, 'name_country' => 'Espagne', 'code' => 'ES'],
            ['id_country' => 7, 'name_country' => 'Italie', 'code' => 'IT'],
            ['id_country' => 8, 'name_country' => 'Pays-Bas', 'code' => 'NL'],
            ['id_country' => 9, 'name_country' => 'Portugal', 'code' => 'PT'],
            ['id_country' => 10, 'name_country' => 'Québec', 'code' => 'CA'], // Note: jVectorMap utilise le code pays (CA) pour le Québec
            ['id_country' => 11, 'name_country' => 'États-Unis', 'code' => 'US'],
            ['id_country' => 12, 'name_country' => 'Royaume-Uni', 'code' => 'GB'],
            ['id_country' => 13, 'name_country' => 'Suède', 'code' => 'SE'],
            ['id_country' => 14, 'name_country' => 'Norvège', 'code' => 'NO'],
            ['id_country' => 15, 'name_country' => 'Danemark', 'code' => 'DK'],
        ]);
    }
}
