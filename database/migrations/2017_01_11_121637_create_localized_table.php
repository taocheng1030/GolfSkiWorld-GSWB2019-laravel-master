<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalizedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localized', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('field');
            $table->string('value');

            $table->string('localized_type');
            $table->integer('localized_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('localized');
    }
}
