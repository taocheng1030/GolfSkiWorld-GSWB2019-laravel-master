<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationTypesTable extends Migration
{
    public function up()
    { 
        Schema::create('accommodation_types', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('accommodation_types');
    }
}
