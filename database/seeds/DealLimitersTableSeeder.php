<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DealLimitersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deal_limiters')->insert([
            'name' => "Time",
        ]);

        DB::table('deal_limiters')->insert([
            'name' => "Number of purchases",
        ]);
    }
}