<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartPortraitAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_portrait_attributes', function (Blueprint $table) {
            $table->foreignId('cart_portrait_id')->references('id')->on('cart_portraits')->onDelete('cascade');
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
        Schema::dropIfExists('cart_portrait_attributes');
    }
}
