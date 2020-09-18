<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortraitAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portrait_attributes', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('portrait_id')->references('id')->on('portraits');
            $table->string('value');
            $table->string('type')->default('size')->comment('size, type');
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
        Schema::dropIfExists('portrait_attributes');
    }
}
