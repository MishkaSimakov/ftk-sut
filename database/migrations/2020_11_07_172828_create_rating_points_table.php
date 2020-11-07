<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating_points', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rating_id');
            $table->foreignId('rating_point_category_id');
            $table->foreignId('user_id');

            $table->integer('amount')->unsigned();

            $table->timestamps();

            $table->foreign('rating_id')->on('ratings')->references('id')->onDelete('cascade');
            $table->foreign('rating_point_category_id')->references('id')->on('rating_point_categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rating_points');
    }
}
