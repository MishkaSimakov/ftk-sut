<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_users', function (Blueprint $table) {
            $table->primary(['user_id', 'travel_id']);

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('travel_id');

            $table->float('distance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_users');
    }
}
