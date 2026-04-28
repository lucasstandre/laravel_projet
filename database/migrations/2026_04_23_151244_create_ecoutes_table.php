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
        Schema::create('ecoutes', function (Blueprint $table) {
        $table->engine = 'InnoDB'; // Pour pouvoir utiliser les clés étrangères et les transactions
        $table->bigIncrements('id_ecoute'); // Clé primaire automatiquement créée avec "bigIncrements()".
        // "usigned()" nécessaire pour éventuellement pouvoir définir une clé étrangère sur cette colonne.
        $table->integer('duree');
        $table->timestamp('timestamp')->useCurrent();
        $table->unsignedBigInteger('id_utilisateur');
        $table->unsignedInteger('id_chanson');

        $table->foreign('id_utilisateur')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('id_chanson')->references('id_chanson')->on('chansons')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecoutes');
    }
};
