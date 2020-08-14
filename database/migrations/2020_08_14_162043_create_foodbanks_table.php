<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodbanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foodbanks', function (Blueprint $table) {
            $table->id();
            $table->string('foodbank_name');
            $table->string('foodbank_email')
                    ->unique();
            $table->string('foodbank_address')->nullable();
            $table->string('foodbank_city')->nullable();
            $table->string('foodbank_postalcode')->nullable();
            $table->string('foodbank_province')->nullable();
            $table->string('foodbank_phone')->nullable();
            $table->string('company_number')->nullable();
            $table->string('details')->nullable();
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
        Schema::dropIfExists('foodbanks');
    }
}
