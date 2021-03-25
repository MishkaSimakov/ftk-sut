<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleArticleTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_article_tag', function (Blueprint $table) {
            $table->foreignId('article_id');
            $table->foreignId('article_tag_id');

            $table->primary(['article_id', 'article_tag_id']);
            $table->foreign('article_id')->on('articles')->references('id')->onDelete('cascade');
            $table->foreign('article_tag_id')->on('article_tags')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_article_tag');
    }
}
