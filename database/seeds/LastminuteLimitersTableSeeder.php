<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LastminuteLimitersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lastminute_limiters')->insert([
            'name' => "Time",
        ]);

        DB::table('lastminute_limiters')->insert([
            'name' => "Number of purchases",
        ]);
    }
}