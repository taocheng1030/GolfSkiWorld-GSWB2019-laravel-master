<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationLastminuteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_lastminute', function (Blueprint $table) {
            $table->integer('accommodation_id')->unsigned()->nullable();
            $table->foreign('accommodation_id')->references('id')
                ->on('accommodations')->onDelete('cascade');

            $table->integer('lastminute_id')->unsigned()->nullable();
            $table->foreign('lastminute_id')->references('id')
                ->on('lastminutes')->onDelete('cascade');

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
        Schema::drop('accommodation_lastminute');
    }
}
