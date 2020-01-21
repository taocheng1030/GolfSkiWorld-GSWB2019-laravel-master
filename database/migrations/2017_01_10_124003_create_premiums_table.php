<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePremiumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premiums', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->boolean('request')->default(0);
            $table->timestamp('request_at')->nullable();

            $table->boolean('decline')->default(0);
            $table->timestamp('decline_at')->nullable();

            $table->boolean('approve')->default(0);
            $table->timestamp('approve_at')->nullable();

            $table->boolean('suspended')->default(0);
            $table->timestamp('suspended_at')->nullable();

            $table->boolean('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('premiums');
    }
}
