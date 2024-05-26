<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventaires_details', function (Blueprint $table) {
            $table->id();
            $table->string('code_inventaire');
            $table->string('codebar_article');
            $table->string('name_article_inventaire');
            $table->integer('qty_theorique_inventaire');
            $table->integer('qty_physique_inventaire');
            $table->integer('price_inventaire');
            $table->integer('price_article');
            $table->integer('difference_inventaire');
            $table->string('reason_delete')->nullable();
            $table->string('status_inventaire')->default(0)->comment("0: En attente,1: approuved,2: Rejeter");
            $table->integer("created_by");
            $table->integer("modified_by")->nullable();
            $table->timestamp("modified_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists("inventaires_details");
    }
};
