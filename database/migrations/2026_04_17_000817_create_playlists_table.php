<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('playlists', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Pour pouvoir utiliser les clés étrangères et les transactions
            $table->bigIncrements('id_playlist'); // Clé primaire automatiquement créée avec "bigIncrements()".
            // "usigned()" nécessaire pour éventuellement pouvoir définir une clé étrangère sur cette colonne.
            $table->bigInteger('id_creator')->unsigned(); //id_utilisateur du creator
            $table->string('playlist');
            $table->string('description');
            $table->string('link');
            $table->boolean('original');
            // foreign key
            //Schema::table('playlists', function (Blueprint $table) {
           // $table->foreign('id_creator')->references('id_utilisateur')->on('utilisateur');
            //});
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlists');
    }
};
