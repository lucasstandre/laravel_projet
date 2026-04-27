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
        DB::table('countries')->insert([
        ['name_country' => 'Canada',],
        ['name_country' => 'France',],
        ['name_country' => 'Belgique', ],
        ['name_country' => 'Suisse', ],
    ]);
    }
}
