<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')
                    ->unique();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postalcode')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('isFoodbank')->nullable();
            $table->timestamp('email_verified_at')
                    ->nullable();
            $table->float('treasures')->nullable();
            $table->string('password');
            $table->decimal('lat', 10,7)->nullable();
            $table->decimal('lng',10,7)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
