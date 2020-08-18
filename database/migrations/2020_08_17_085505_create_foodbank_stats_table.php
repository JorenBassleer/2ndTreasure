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
            $table->float('total_amount_of_kg_received');
            $table->float('total_amount_of_treasures_generated');
            $table->integer('total_amount_of_goodiebags_received');
            $table->foreign('foodbank_id')->references('id')->on('foodbanks')->onUpdate('cascade')->onDelete('cascade');
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
