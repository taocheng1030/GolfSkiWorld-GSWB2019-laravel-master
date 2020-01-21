<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function(Blueprint $table) {
            $table->boolean('awarded')->default(0);
            $table->boolean('promo')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function(Blueprint $table) {
            $table->dropColumn('awarded');
            $table->dropColumn('promo');
        });
    }
}
