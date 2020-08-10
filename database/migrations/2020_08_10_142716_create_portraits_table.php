<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortraitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portraits', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->string('sku')->unique();
            $table->string('slug');
            $table->unsignedInteger('qty')->default(10);

            $table->decimal('price', 12, 4)->nullable();

            $table->boolean('featured')->default(false);
            $table->boolean('new')->default(false);

            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();

            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('portraits');
    }
}
