<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikeablesTable extends Migration
{
    public function up()
    { 
      Schema::create('likeables', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
            
          $table->integer('user_id')->unsigned()->index();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

          $table->integer('likeable_id');
          $table->string('likeable_type');
          $table->softDeletes();
      });
    }
    public function down()
    {
        Schema::drop('likeables');
    }
}
