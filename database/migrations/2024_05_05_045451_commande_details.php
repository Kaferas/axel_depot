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
        Schema::create('commandes_details', function (Blueprint $table) {
            $table->id();
            $table->string('commande_code');
            $table->string('ref_produit');
            $table->integer('quantity');
            $table->double('price_product');
            $table->string('name_produit');
            $table->double('total_details');
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes_details');
    }
};
