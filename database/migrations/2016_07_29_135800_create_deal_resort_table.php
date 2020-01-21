<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealResortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_resort', function (Blueprint $table) {
            $table->integer('deal_id')->unsigned()->nullable();
            $table->foreign('deal_id')->references('id')
                ->on('deals')->onDelete('cascade');

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
        Schema::drop('deal_resort');
    }
}
