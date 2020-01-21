<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 7; $i++) 
        {
            DB::table('profiles')->insert([
                'user_id' => $i,
                'language_id' => 1,
                'country_id' => 1,
                'state_id' => 1,
                'city_id' => 1,
                'address' => "",
                'zip' => "",
                'phone' => "",
                'newsletter' => "",
                'notify' => "",
                'online_status' => 0,
                'show_info' => 0,
                'priority' => 0,
            ]);
        } 
    }
}
