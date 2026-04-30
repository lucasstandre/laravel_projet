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
    {   // cree la table dassosiation
        Schema::create('ta_playlist_chanson', function (Blueprint $table) {
            //pk
            $table->unsignedBigInteger('id_playlist');
            $table->unsignedInteger('id_chanson');
            //autre
            //$table->string('chanson_playlist'); pas besoin pour linstant mait dans le model de db
            $table->date('date_ajout');
            //pk
            $table->primary(['id_playlist', 'id_chanson']);
            //fk
            $table->foreign('id_playlist')->references('id_playlist')->on('playlists')->onDelete('cascade');
            $table->foreign('id_chanson')->references('id_chanson')->on('chansons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chanson_playlist');
    }
};
