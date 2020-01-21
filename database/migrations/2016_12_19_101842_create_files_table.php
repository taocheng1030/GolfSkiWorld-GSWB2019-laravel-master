<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('mime');
            $table->string('name');
            $table->string('path');
            $table->string('ext');
            $table->integer('size');
            $table->string('description')->nullable();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('files');
    }
}
