<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(WatchtowerTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);
        $this->call(SitesTableSeeder::class);
        $this->call(ResortsTableSeeder::class);
        $this->call(AccommodationTypesTableSeeder::class);
        $this->call(AccommodationsTableSeeder::class);
        $this->call(RestaurantTypesTableSeeder::class);
        $this->call(RestaurantsTableSeeder::class);
        $this->call(DealLimitersTableSeeder::class);
        $this->call(DealsTableSeeder::class);
        $this->call(LastminuteLimitersTableSeeder::class);
        $this->call(LastminutesTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
        $this->call(MediaTypesTableSeeder::class);
    }
}
