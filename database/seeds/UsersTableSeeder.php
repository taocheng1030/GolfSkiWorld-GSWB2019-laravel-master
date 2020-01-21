<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admininistrator',
            'email' => 'admin@wit.com',
            'password' => bcrypt('secret'),
        ]);

        DB::table('users')->insert([
            'name' => 'Moderator',
            'email' => 'moderator@wit.com',
            'password' => bcrypt('secret'),
        ]);

        DB::table('users')->insert([
            'name' => 'General User',
            'email' => 'user@wit.com',
            'password' => bcrypt('secret'),
        ]);

        DB::table('users')->insert([
            'name' => 'Banned User',
            'email' => 'banned@wit.com',
            'password' => bcrypt('secret'),
        ]);

        DB::table('users')->insert([
            'name' => 'Registered User',
            'email' => 'registered@wit.com',
            'password' => bcrypt('secret'),
        ]);
        
        DB::table('users')->insert([
            'name' => 'Admininistrator, Golf',
            'email' => 'admingolf@wit.com',
            'password' => bcrypt('secret'),
        ]);
        
        DB::table('users')->insert([
            'name' => 'Admininistrator, Ski',
            'email' => 'adminski@wit.com',
            'password' => bcrypt('secret'),
        ]);
    }
}
