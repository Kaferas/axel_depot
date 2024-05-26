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
        Schema::create('approvisionnements', function (Blueprint $table) {
            $table->id();
            $table->string("approv_title");
            $table->string("approv_code");
            $table->double("approv_amount", 8, 2)->nullable();
            $table->integer("approv_fournisseur");
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
        Schema::dropIfExists('approvisionnements');
    }
};
