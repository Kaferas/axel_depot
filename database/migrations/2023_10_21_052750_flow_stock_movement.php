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
        Schema::create('flow_stock_movement', function (Blueprint $table) {
            $table->id();
            $table->text('ref_article');
            $table->integer('qty_flow');
            $table->integer('unite_price_movement');
            $table->integer('total_price_movement');
            $table->integer('created_by');
            $table->timestamp("modified_at")->nullable();
            $table->string('movement_type')->comment("MV_invetory: Inventaire, MV_supplies: Approvisionnemnet, MV_out: Sorties, MV_back: Retour");
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
        Schema::dropIfExists('flow_stock_movement');
    }
};
