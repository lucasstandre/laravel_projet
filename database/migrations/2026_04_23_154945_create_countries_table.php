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
    Schema::create('countries', function (Blueprint $table) {
        $table->bigIncrements('id_country');
        $table->string('name_country');
        $table->string('code')->nullable(); // obliger pour la map
    });
}


};
