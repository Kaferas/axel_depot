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
        Schema::create('Inventaires', function (Blueprint $table) {
            $table->id();
            $table->string('title_inventory');
            $table->string('description_inventory');
            $table->integer("created_by");
            $table->string('status_inventaire')->default(0)->comment("0: En attente,1: approuved,2: Rejeter");
            $table->string('reason_delete')->nullable();
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
        Schema::dropIfExists('Inventaires');
    }
};
