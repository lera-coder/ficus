<?php

namespace Database\Seeders;

use App\Models\User;
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
                "is_2auth"=>false,
                "password"=>Hash::make("2206"),

            ],

            [
                "name"=>"Slava",
                "login"=>"slava6606",
                "is_2auth"=>false,
                "password"=>Hash::make("2206"),
            ],

            [
                "name"=>"Mustafa",
                "login"=>"mustafa6606",
                "is_2auth"=>false,
                "password"=>Hash::make("2206"),
            ],
        ]);

        $user_quantity = 10;

        for($i = 0; $i<$user_quantity; $i++){
            User::factory()->count(1)->state([
                'login'=>'user'.$i,
            ])->create();
        }

    }
}
