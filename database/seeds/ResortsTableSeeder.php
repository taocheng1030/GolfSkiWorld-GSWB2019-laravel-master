<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

require_once 'vendor/fzaninotto/faker/src/autoload.php';

class ResortsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\Base($faker));
        $faker->addProvider(new Faker\Provider\Lorem($faker));
        $faker->addProvider(new Faker\Provider\DateTime($faker));
        $faker->addProvider(new Faker\Provider\Internet($faker));
        $faker->addProvider(new Faker\Provider\en_US\Company($faker));
        $faker->addProvider(new Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new Faker\Provider\en_US\PhoneNumber($faker));

        for ($i=0; $i < 20; $i++) 
        {
            DB::table('resorts')->insert([
                'site_id' => $faker->numberBetween($min = 1, $max = 2),
                'country_id' => $faker->numberBetween($min = 1, $max = 246),
                'state_id' => $faker->numberBetween($min = 1, $max = 4119),
                'city_id' => $faker->numberBetween($min = 1, $max = 48314),
                'name' => $faker->cityPrefix . $faker->city . $faker->citySuffix,
                'description' => $faker->bs,
                'details' => $faker->bs,
                'administrator' => $faker->company,
                'thumbnail' => $faker->imageUrl($width = 640, $height = 480),
                'longitude' => $faker->longitude($min = 10, $max = 20),
                'latitude' => $faker->latitude($min = 50, $max = 60),
                'street' => $faker->streetAddress,
                'zip' => $faker->postcode,
                'phone' => $faker->e164PhoneNumber,
                'email' => $faker->email,
                'link' => $faker->url,
                'sponser' => $faker->boolean($chanceOfGettingTrue = 50),
                'published' => $faker->boolean($chanceOfGettingTrue = 50),
            ]);
        } 
    }
}
