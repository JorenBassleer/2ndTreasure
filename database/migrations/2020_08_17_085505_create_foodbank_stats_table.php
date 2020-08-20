<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodbankStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foodbank_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('foodbank_id')->nullable();
            $table->decimal('total_amount_of_kg_received', 10,3);
            $table->decimal('total_amount_of_treasures_generated',10,3);
            $table->integer('total_amount_of_goodiebags_received');
            $table->foreign('foodbank_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('foodbank_stats');
    }
}
