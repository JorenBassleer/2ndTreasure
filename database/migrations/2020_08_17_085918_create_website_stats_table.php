<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsiteStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_stats', function (Blueprint $table) {
            $table->id();
            $table->integer('amount_of_foodbanks');
            $table->integer('amount_of_users');
            $table->decimal('amount_of_kg_donated', 10,3);
            $table->decimal('amount_of_treasures_created',10,3);
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
        Schema::dropIfExists('website_stats');
    }
}
