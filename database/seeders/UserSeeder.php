<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                "name"=>"Lera",
                "login"=>"lera6606",
                "email"=>"valeryselivanova0@gmail.com",
                "password"=>Hash::make("2206"),
            ],

            [
                "name"=>"Arnold",
                "login"=>"arnold_shwarz",
                "email"=>"arnoldsvarcneger86@gmail.com",
                "password"=>Hash::make("2206"),
            ],

            [
                "name"=>"Katya",
                "login"=>"katrusia234",
                "email"=>"katerina@example.com",
                "password"=>Hash::make("2206"),
            ],
        ]);
    }
}
