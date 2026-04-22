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
        Schema::create('chansons', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->Increments('id_chanson');

            $table->string('nom');
            $table->smallInteger('duree');
            $table->TEXT('description')->nullable();
            $table->date('date_sortie');
            $table->string('fichier',256);
            $table->integer('like')->default(0);
            $table->Integer('id_album')->unsigned();
            $table->unsignedBigInteger('id_genre');
            $table->bigInteger('id_artiste')->unsigned();
        });
        Schema::table('chansons', function (Blueprint $table){
            $table->foreign('id_album')->references('id_album')->on('albums');
            $table->foreign('id_genre')->references('id_genre')->on('genres');
            //$table->foreign('id_artiste')->references('id_utilisateur')->on('utilisateurs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chansons');
    }
};
