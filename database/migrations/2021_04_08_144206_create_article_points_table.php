<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_points', function (Blueprint $table) {
            $table->primary(['article_id', 'user_id']);

            $table->foreignId('article_id');
            $table->foreignId('user_id');

            $table->foreign('article_id')->on('articles')->references('id')->onDelete('cascade');
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');

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
        Schema::dropIfExists('article_points');
    }
}
