<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventUserTable extends Migration
{
    public function up()
    {
        Schema::create('event_user', function (Blueprint $table) {
            $table->primary(['event_id', 'user_id']);

            $table->foreignId('event_id');
            $table->foreignId('user_id');

            $table->float('distance_traveled')->nullable();

            $table->foreign('event_id')->on('events')->references('id')->onDelete('cascade');
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_user');
    }
}
