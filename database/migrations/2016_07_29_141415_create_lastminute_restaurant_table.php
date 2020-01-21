<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLastminuteRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lastminute_restaurant', function (Blueprint $table) {
            $table->integer('lastminute_id')->unsigned()->nullable();
            $table->foreign('lastminute_id')->references('id')
                ->on('lastminutes')->onDelete('cascade');

            $table->integer('restaurant_id')->unsigned()->nullable();
            $table->foreign('restaurant_id')->references('id')
                ->on('restaurants')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lastminute_restaurant');
    }
}
