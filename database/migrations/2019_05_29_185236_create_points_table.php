<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id');
            $table->integer('rating_id');

            $table->integer('points');

            $table->integer('points_travels');
            $table->integer('points_local_competition');
            $table->integer('points_global_competition');
            $table->integer('points_games');
            $table->integer('points_lessons');
            $table->integer('points_press');

            $table->integer('place');

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
        Schema::dropIfExists('point');
    }
}
