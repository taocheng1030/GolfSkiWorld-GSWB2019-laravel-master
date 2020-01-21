<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('language_id')->unsigned()->index();
            $table->foreign('language_id')->references('id')->on('languages');
            $table->integer('country_id')->unsigned()->index();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->integer('state_id')->unsigned()->index();
            $table->foreign('state_id')->references('id')->on('states');
            $table->integer('city_id')->unsigned()->index();
            $table->foreign('city_id')->references('id')->on('cities');  

            $table->string('firstname');
            $table->string('lastname');
            $table->string('address');
            $table->string('zip');
            $table->string('phone');
            $table->string('newsletter');
            $table->string('notify');            
            $table->integer('online_status');
            $table->integer('show_info');
            $table->integer('priority');
            $table->string('avatar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('profiles');
    }
}
