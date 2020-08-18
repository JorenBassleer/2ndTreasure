<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeekStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('week_stats', function (Blueprint $table) {
            $table->id();
            $table->integer('amount_of_foodbanks');
            $table->integer('amount_of_users');
            $table->integer('amount_of_kg_donated');
            $table->float('amount_of_treasures_created');
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
        Schema::dropIfExists('week_stats');
    }
}
