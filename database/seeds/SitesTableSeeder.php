<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sites')->insert([
            'name' => "Golf",
        ]);

        DB::table('sites')->insert([
            'name' => "Ski",
        ]);
    }
}