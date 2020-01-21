<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            'name' => "EN",
        ]);

        DB::table('languages')->insert([
            'name' => "SV",
        ]);
    }
}