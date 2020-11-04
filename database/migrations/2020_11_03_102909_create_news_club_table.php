<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsClubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_club', function (Blueprint $table) {
            $table->foreignId('news_id');
            $table->foreignId('club_id');


            $table->primary(['news_id', 'club_id']);
            $table->foreign('news_id')->on('news')->references('id')->onDelete('cascade');
            $table->foreign('club_id')->on('clubs')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_club');
    }
}
