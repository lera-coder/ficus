<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phones')->insert([

            [
                "phone_number"=>"0950901024",
                "is_active"=>false,
                "user_id"=>1,
                "phone_country_code_id"=>1,
            ],

            [
                "phone_number"=>"0670099651",
                "is_active"=>true,
                "user_id"=>1,
                "phone_country_code_id"=>1,
            ],

            [
                "phone_number"=>"0962072148",
                "is_active"=>true,
                "user_id"=>2,
                "phone_country_code_id"=>1,
            ],

            [
                "phone_number"=>"0950608347",
                "is_active"=>true,
                "user_id"=>3,
                "phone_country_code_id"=>1,
            ],
        ]);
    }
}
