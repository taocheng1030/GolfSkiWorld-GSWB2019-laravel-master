<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('messageable_id')->default(0);
            $table->string('messageable_type')->nullable();

            $table->string('type');
            $table->string('message');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('system_messages');
    }
}
