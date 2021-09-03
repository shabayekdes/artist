<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPortraitAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_portrait_attributes', function (Blueprint $table) {
            $table->foreignId('order_protrait_id')->references('id')->on('order_protraits')->onDelete('cascade');
            $table->foreignId('portrait_attribute_id')->references('id')->on('portrait_attributes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_portrait_attributes');
    }
}
