<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AccommodationTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accommodation_types')->insert([
            'name' => "Hotel",
        ]);

        DB::table('accommodation_types')->insert([
            'name' => "Cabin",
        ]);

        DB::table('accommodation_types')->insert([
            'name' => "Camping",
        ]);
    }
}