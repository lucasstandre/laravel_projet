<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genres')->insert([
            //generation
            // --- ROCK & METAL ---
            ['genre' => 'Rock Alternatif', 'description' => 'Style de rock né de la scène underground des années 80.'],
            ['genre' => 'Hard Rock', 'description' => 'Rock caractérisé par des voix agressives et des guitares saturées.'],
            ['genre' => 'Punk Rock', 'description' => 'Musique rapide et brute, souvent associée à des messages politiques.'],
            ['genre' => 'Heavy Metal', 'description' => 'Style puissant avec des tempos variés et des solos de guitare complexes.'],
            ['genre' => 'Indie Rock', 'description' => 'Rock indépendant mettant l\'accent sur l\'expérimentation.'],
            ['genre' => 'Grunge', 'description' => 'Mélange de punk et de heavy metal, popularisé à Seattle.'],
            ['genre' => 'Psychédélique', 'description' => 'Musique cherchant à reproduire les effets des expériences sensorielles.'],

            // --- URBAIN & HIP-HOP ---
            ['genre' => 'Rap Français', 'description' => 'Hip-hop produit en France avec une emphase sur les textes.'],
            ['genre' => 'Trap', 'description' => 'Sous-genre du hip-hop avec des beats lourds et des charlestons rapides.'],
            ['genre' => 'Lo-fi Hip Hop', 'description' => 'Musique relaxante avec des imperfections sonores volontaires.'],
            ['genre' => 'R&B Moderne', 'description' => 'Mélange de rythmes hip-hop et de voix soul/pop.'],
            ['genre' => 'Old School Hip Hop', 'description' => 'Le style originel du rap des années 70 et 80.'],
            ['genre' => 'Boom Bap', 'description' => 'Style de production hip-hop centré sur le kick et le snare.'],

            // --- ÉLECTRONIQUE ---
            ['genre' => 'Techno', 'description' => 'Musique électronique répétitive conçue pour les clubs.'],
            ['genre' => 'House', 'description' => 'Musique dansante née à Chicago avec un rythme 4/4 constant.'],
            ['genre' => 'Drum and Bass', 'description' => 'Rythmes de batterie très rapides avec des lignes de basse profondes.'],
            ['genre' => 'Dubstep', 'description' => 'Musique électronique avec des lignes de basse oscillantes ("wobble").'],
            ['genre' => 'Trance', 'description' => 'Style mélodique et hypnotique avec un tempo rapide.'],
            ['genre' => 'Synthwave', 'description' => 'Musique moderne inspirée par les bandes sonores des années 80.'],
            ['genre' => 'Deep House', 'description' => 'Variante plus mélodique et atmosphérique de la House.'],

            // --- JAZZ, BLUES & SOUL ---
            ['genre' => 'Blues', 'description' => 'Genre vocal et instrumental basé sur des notes bleues et la répétition.'],
            ['genre' => 'Bebop', 'description' => 'Style de jazz rapide avec des harmonies complexes.'],
            ['genre' => 'Soul', 'description' => 'Musique combinant le gospel et le rhythm and blues.'],
            ['genre' => 'Funk', 'description' => 'Musique très rythmée mettant l\'accent sur la ligne de basse.'],
            ['genre' => 'Swing', 'description' => 'Forme de jazz populaire dans les années 30 faite pour la danse.'],
            ['genre' => 'Gospel', 'description' => 'Musique religieuse chrétienne aux racines afro-américaines.'],

            // --- POP & MONDE ---
            ['genre' => 'Pop Latino', 'description' => 'Musique pop influencée par les rythmes d\'Amérique latine.'],
            ['genre' => 'K-Pop', 'description' => 'Musique populaire originaire de Corée du Sud.'],
            ['genre' => 'Reggaeton', 'description' => 'Mélange de reggae, dancehall et hip-hop d\'Amérique latine.'],
            ['genre' => 'Salsa', 'description' => 'Musique de danse rythmée originaire de Cuba et Porto Rico.'],
            ['genre' => 'Afrobeats', 'description' => 'Genre contemporain africain mêlant pop, dancehall et highlife.'],
            ['genre' => 'Bossa Nova', 'description' => 'Style de musique brésilienne dérivé de la samba et du jazz.'],
            ['genre' => 'Ska', 'description' => 'Précurseur du reggae avec un rythme rapide et des cuivres.'],

            // --- AUTRES & VARIÉTÉS ---
            ['genre' => 'Variété Française', 'description' => 'Chanson populaire de langue française.'],
            ['genre' => 'Country', 'description' => 'Musique traditionnelle américaine avec guitare et harmonica.'],
            ['genre' => 'Folk', 'description' => 'Musique acoustique basée sur les traditions populaires.'],
            ['genre' => 'Disco', 'description' => 'Musique de danse phare des années 70.'],
            ['genre' => 'Opéra', 'description' => 'Œuvre dramatique mise en musique pour chanteurs et orchestre.'],
            ['genre' => 'Musique de Film', 'description' => 'Compositions créées pour accompagner des œuvres cinématographiques.'],
            ['genre' => 'Ambient', 'description' => 'Musique atmosphérique mettant l\'accent sur les textures sonores.'],
            ['genre' => 'Bluegrass', 'description' => 'Forme de musique country jouée sur des instruments à cordes.'],
            ['genre' => 'Slam', 'description' => 'Poésie orale scandée sur un rythme minimaliste.'],
            ['genre' => 'Metalcore', 'description' => 'Fusion entre le heavy metal et le punk hardcore.'],
            ['genre' => 'Electro Swing', 'description' => 'Mélange de jazz vintage et de beats électroniques.'],
            ['genre' => 'New Wave', 'description' => 'Mouvement pop-rock utilisant beaucoup les synthétiseurs.'],
            ['genre' => 'Post-Rock', 'description' => 'Rock expérimental utilisant les instruments de façon non conventionnelle.'],
            ['genre' => 'Trip-Hop', 'description' => 'Mélange de hip-hop et d\'électronique atmosphérique.'],
            ['genre' => 'EBM', 'description' => 'Electronic Body Music, style industriel et dansant.'],
            ['genre' => 'Flamenco', 'description' => 'Musique traditionnelle espagnole chargée d\'émotion.'],
            ['genre' => 'Zouk', 'description' => 'Musique de danse originaire des Antilles françaises.']
        ]);
    }
}
