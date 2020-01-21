<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharesTable extends Migration
{
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('sharing_id');
            $table->string('sharing_type');
            $table->string('sharing_token');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('shares');
    }
}
