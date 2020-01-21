<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

require_once 'vendor/fzaninotto/faker/src/autoload.php';

class ArticlesTableSeeder extends Seeder
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
            DB::table('articles')->insert([
                'site_id' => $faker->numberBetween($min = 1, $max = 2),
                'language_id' => $faker->numberBetween($min = 1, $max = 2),
                'name' => $faker->cityPrefix . $faker->city . $faker->citySuffix,
                'textinmenu' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'body' => $faker->text(30),
                'summary' => $faker->sentence($nbWords = 6, $variableNbWords = true) ,
                'tags' => $faker->bs,
                'link' => $faker->url,
                'inmenu' => $faker->boolean($chanceOfGettingTrue = 50),
                'startpage' => $faker->boolean($chanceOfGettingTrue = 50),
                'published' => $faker->boolean($chanceOfGettingTrue = 50),
            ]);
        } 
    }
}
