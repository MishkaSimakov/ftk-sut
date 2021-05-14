<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingPointCategoryImportNamesTable extends Migration
{
    public function up()
    {
        Schema::create('rating_point_category_import_names', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id');
            $table->string('import_name')->unique();

            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('rating_point_categories');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rating_point_category_import_names');
    }
}
