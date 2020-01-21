<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('site_id')->unsigned()->index();
            $table->foreign('site_id')->references('id')->on('sites');
            $table->integer('type_id')->unsigned()->index();
            $table->foreign('type_id')->references('id')->on('restaurant_types');
            $table->integer('country_id')->unsigned()->index();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->integer('state_id')->unsigned()->index();
            $table->foreign('state_id')->references('id')->on('states');
            $table->integer('city_id')->unsigned()->index();
            $table->foreign('city_id')->references('id')->on('cities');    

            $table->string('name');
            $table->string('thumbnail');//image path
            $table->string('description', 144);
            $table->string('owner');
            $table->double('longitude', 15, 8);
            $table->double('latitude', 15, 8);
            $table->text('street');
            $table->text('zip');
            $table->text('phone');
            $table->text('email');
            $table->text('link');
            $table->boolean('sponser');
            $table->boolean('published');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('restaurants');
    }
}
