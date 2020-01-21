<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localizations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('language_id')->unsigned()->index();
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');

            $table->string('field');
            $table->string('value');

            $table->string('localizable_type');
            $table->integer('localizable_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('localizations');
    }
}
