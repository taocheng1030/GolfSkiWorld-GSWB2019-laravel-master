<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLastminutesTable extends Migration
{

    public function up()
    {
        Schema::create('lastminutes', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();

          $table->integer('site_id')->unsigned()->index();
          $table->foreign('site_id')->references('id')->on('sites');
          $table->integer('limiter_id')->unsigned()->index();
          $table->foreign('limiter_id')->references('id')->on('lastminute_limiters');

          $table->string('name');
          $table->text('shortdescription', 144);
          $table->text('description');
          $table->string('owner');
          $table->string('currency');
          $table->string('thumbnail');
          $table->string('movie');
          $table->string('link');
          $table->datetime('starts');
          $table->datetime('ends');
          $table->double('originalprice');
          $table->double('price');
          $table->integer('numberofpurchases');
          $table->integer('remaining');          
          $table->integer('views');
          $table->integer('hits');
          $table->double('longitude', 15, 8);
          $table->double('latitude', 15, 8);
          $table->boolean('email');
          $table->boolean('sms');
          $table->boolean('push');
          $table->boolean('published');
        });
    }

    public function down()
    {
        Schema::drop('lastminutes');
    }
}
