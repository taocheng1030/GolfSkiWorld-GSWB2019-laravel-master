<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RestaurantTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('restaurant_types')->insert([
            'name' => "Restaurant",
        ]);

        DB::table('restaurant_types')->insert([
            'name' => "Cafeteria",
        ]);

        DB::table('restaurant_types')->insert([
            'name' => "Kiosk",
        ]);
    }
}