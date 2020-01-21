<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();

          $table->integer('site_id')->unsigned()->index();
          $table->foreign('site_id')->references('id')->on('sites');
          $table->integer('language_id')->unsigned()->index();
          $table->foreign('language_id')->references('id')->on('languages');
 
          $table->string('name');
          $table->string('textinmenu');
          $table->text('body');
          $table->string('tags');
          $table->string('link');
          $table->text('summary');
          $table->boolean('inmenu');
          $table->boolean('startpage');
          $table->boolean('published');
        });
    } 
    public function down()
    {
        Schema::drop('articles');
    }
}
