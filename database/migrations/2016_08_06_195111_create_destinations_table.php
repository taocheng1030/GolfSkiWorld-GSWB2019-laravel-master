<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinationsTable extends Migration
{
    public function up()
    { 
      Schema::create('destinations', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
            
          $table->integer('site_id')->unsigned()->index();
          $table->foreign('site_id')->references('id')->on('sites');
          $table->integer('user_id')->unsigned()->index();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          $table->integer('mediatype_id')->unsigned()->index();
          $table->foreign('mediatype_id')->references('id')->on('mediatypes');

          $table->string('name');
          $table->string('description');
          $table->double('longitude', 15, 8);
          $table->double('latitude', 15, 8);
          $table->string('thumbnail');
          $table->string('movie');
      });
    }
    public function down()
    {
        Schema::drop('destinations');
    }
}
