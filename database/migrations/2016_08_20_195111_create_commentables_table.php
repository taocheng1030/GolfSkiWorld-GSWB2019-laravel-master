<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentablesTable extends Migration
{
    public function up()
    { 
      Schema::create('commentables', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();

          $table->integer('user_id')->unsigned()->index();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

          $table->integer('commentable_id');
          $table->string('commentable_type');
          $table->text('commentable_text');
          $table->softDeletes();
      });
    }
    public function down()
    {
        Schema::drop('commentables');
    }
}
