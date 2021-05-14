<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelsTable extends Migration
{
    public function up()
    {
        Schema::create('travels', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id');
            $table->enum('type', \App\Enums\TravelType::getValues());
            $table->float('distance')->unsigned();

            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('travels');
    }
}
