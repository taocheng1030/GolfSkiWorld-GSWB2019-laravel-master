<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationDealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_deal', function (Blueprint $table) {
            $table->integer('accommodation_id')->unsigned()->nullable();
            $table->foreign('accommodation_id')->references('id')
                ->on('accommodations')->onDelete('cascade');

            $table->integer('deal_id')->unsigned()->nullable();
            $table->foreign('deal_id')->references('id')
                ->on('deals')->onDelete('cascade');

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
        Schema::drop('accommodation_deal');
    }
}
