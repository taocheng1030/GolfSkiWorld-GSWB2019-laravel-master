<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('file_id')->unsigned()->index();
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');

            $table->integer('imageable_id');
            $table->string('imageable_type');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('photos');
    }
}
