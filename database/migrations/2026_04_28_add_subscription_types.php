<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Créer la table subscription_types
        Schema::create('subscription_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // 'de base' ou 'premium'
            $table->string('label')->nullable(); // Label pour l'affichage
            $table->timestamps();
        });

        // Insérer les données de base
        DB::table('subscription_types')->insert([
            ['id' => 1, 'name' => 'de base', 'label' => 'De Base', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'premium', 'label' => 'Premium', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Ajouter une colonne subscription_type_id à la table subscriptions
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->unsignedBigInteger('subscription_type_id')->nullable()->after('type');
            $table->foreign('subscription_type_id')->references('id')->on('subscription_types')->onDelete('set null');
        });

        // Migrer les données existantes de 'type' vers 'subscription_type_id'
        DB::table('subscriptions')->where('type', 'de base')->update(['subscription_type_id' => 1]);
        DB::table('subscriptions')->where('type', 'premium')->update(['subscription_type_id' => 2]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['subscription_type_id']);
            $table->dropColumn('subscription_type_id');
        });

        Schema::dropIfExists('subscription_types');
    }
};
