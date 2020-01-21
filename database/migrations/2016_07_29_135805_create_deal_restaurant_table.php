<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_restaurant', function (Blueprint $table) {
            $table->integer('deal_id')->unsigned()->nullable();
            $table->foreign('deal_id')->references('id')
                ->on('deals')->onDelete('cascade');

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
        Schema::drop('deal_restaurant');
    }
}
