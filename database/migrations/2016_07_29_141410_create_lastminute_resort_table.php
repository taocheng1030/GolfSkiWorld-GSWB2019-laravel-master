<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLastminuteResortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lastminute_resort', function (Blueprint $table) {
            $table->integer('lastminute_id')->unsigned()->nullable();
            $table->foreign('lastminute_id')->references('id')
                ->on('lastminutes')->onDelete('cascade');

            $table->integer('resort_id')->unsigned()->nullable();
            $table->foreign('resort_id')->references('id')
                ->on('resorts')->onDelete('cascade');

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
        Schema::drop('lastminute_resort');
    }
}
