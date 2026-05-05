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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'id_country')) {
                $table->unsignedBigInteger('id_country')->nullable()->after('name');
                $table->foreign('id_country')->references('id_country')->on('countries')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'id_country')) {
                $table->dropForeign(['id_country']);
                $table->dropColumn('id_country');
            }
        });
    }
};
