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
        Schema::create('paiements_factures', function (Blueprint $table) {
            $table->id();
            $table->string('commande_code');
            $table->double('montant_paiement');
            $table->integer('mode_paiement');
            $table->integer('client_id');
            $table->integer('depot_id');
            $table->double('avance');
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("paiements_factures");
    }
};
