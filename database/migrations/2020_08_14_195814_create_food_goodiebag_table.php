<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodGoodiebagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_goodiebag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('goodiebag_id')->nullable();
            $table->unsignedBigInteger('food_id')->nullable();
            $table->decimal('amount',10,3);

            $table->foreign('goodiebag_id')->references('id')->on('goodiebags')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('food_id')->references('id')->on('foods')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('food_goodiebag');
    }
}
