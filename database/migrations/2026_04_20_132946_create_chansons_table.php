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
            $table->smallInteger('id_role')->unsigned();
            $table->smallInteger('id_status')->unsigned();
            $table->smallInteger('id_localisation')->unsigned();
            $table->smallInteger('id_social')->unsigned();
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
