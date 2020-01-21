<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

require_once 'vendor/fzaninotto/faker/src/autoload.php';

class LastminutesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
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
            DB::table('lastminutes')->insert([
                'site_id' => $faker->numberBetween($min = 1, $max = 2),
                'limiter_id' => $faker->numberBetween($min = 1, $max = 2),
                'name' => $faker->cityPrefix . $faker->city . $faker->citySuffix,
                'shortdescription' => $faker->text(30),
                'description' => $faker->bs,
                'owner' => $faker->company,
                'currency' => "$",
                'thumbnail' => $faker->imageUrl($width = 640, $height = 480),
                'movie' => $faker->imageUrl($width = 640, $height = 480),
                'link' => $faker->url,
                'starts' => $faker->dateTimeInInterval($startDate = '+2 months', $interval = '+20 days', $timezone = date_default_timezone_get()),
                'ends' => $faker->dateTimeInInterval($startDate = '+3 months', $interval = '+20 days', $timezone = date_default_timezone_get()),
                'originalprice' => $faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = 100),
                'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 9),
                'numberofpurchases' => $faker->numberBetween($min = 10, $max = 100),
                'remaining' => $faker->numberBetween($min = 1, $max = 9),
                'views' => $faker->numberBetween($min = 10, $max = 100),
                'hits' => $faker->numberBetween($min = 10, $max = 100),
                'longitude' => $faker->longitude($min = 10, $max = 20),
                'latitude' => $faker->latitude($min = 50, $max = 60),                
                'email' => $faker->boolean($chanceOfGettingTrue = 50),
                'sms' => $faker->boolean($chanceOfGettingTrue = 50),
                'push' => $faker->boolean($chanceOfGettingTrue = 50),         
                'published' => $faker->boolean($chanceOfGettingTrue = 50),
            ]);
        }
    }
}
