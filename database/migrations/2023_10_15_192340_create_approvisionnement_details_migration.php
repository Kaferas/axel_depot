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
        Schema::create('approvisionnement_details', function (Blueprint $table) {
            $table->id();
            $table->string('code_appr');
            $table->string('codebar_article');
            $table->string('qty_article');
            $table->string('price_article');
            $table->string('total_article');
            $table->string('reason_delete')->nullable();
            $table->string('status_approv')->default(0)->comment("0: En attente,1: approuved,2: Rejeter");
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
        Schema::dropIfExists('approvisionnement_details');
    }
};
