<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationResortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_resort', function (Blueprint $table) {
            $table->integer('resort_id')->unsigned()->nullable();
            $table->foreign('resort_id')->references('id')
                ->on('resorts')->onDelete('cascade');

            $table->integer('accommodation_id')->unsigned()->nullable();
            $table->foreign('accommodation_id')->references('id')
                ->on('accommodations')->onDelete('cascade');

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
        Schema::drop('accommodation_resort');
    }
}
