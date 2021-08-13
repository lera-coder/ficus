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
                "password"=>Hash::make("2206"),
            ],

            [
                "name"=>"Slava",
                "login"=>"slava6606",
                "password"=>Hash::make("2206"),
            ],

            [
                "name"=>"Mustafa",
                "login"=>"mustafa6606",
                "password"=>Hash::make("2206"),
            ],
        ]);
    }
}
