<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class MediaTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mediatypes')->insert([
            'name' => "Image",
        ]);

        DB::table('mediatypes')->insert([
            'name' => "Movie",
        ]);
    }
}