<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('localisations')->insert([
            ['localisation' => 'Montréal', 'id_pays' => 1],
            ['localisation' => 'Paris', 'id_pays' => 2],
        ]);
    }
}
