<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('file_id')->unsigned()->index();
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');

            $table->integer('movieable_id');
            $table->string('movieable_type');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('videos');
    }
}
