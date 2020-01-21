<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResortRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resort_restaurant', function (Blueprint $table) {
            $table->integer('resort_id')->unsigned()->nullable();
            $table->foreign('resort_id')->references('id')
                ->on('resorts')->onDelete('cascade');

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
        Schema::drop('resort_restaurant');
    }
}
