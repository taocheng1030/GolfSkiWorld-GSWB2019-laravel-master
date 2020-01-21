<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToDeals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deals', function(Blueprint $table) {
            $table->string('owner_email')->after('owner');
            $table->string('owner_phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deals', function(Blueprint $table) {
            $table->dropColumn('owner_email');
            $table->dropColumn('owner_phone');
        });
    }
}
