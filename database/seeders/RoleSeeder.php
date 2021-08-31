<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Roles_users seeding for another users is in email seeder because of really low speed

        DB::table('roles')->insert([
            ["name" => "god"],
            ["name" => "manager"],
            ["name" => "team lead"],
            ["name" => "worker"],

        ]);

        DB::table('role_user')->insert([
            [
                "role_id" => 3,
                "user_id"=> 1
            ],

            [
                "role_id" => 3,
                "user_id"=> 2
            ],

            [
                "role_id" => 1,
                "user_id"=> 3
            ],

        ]);



    }
}
