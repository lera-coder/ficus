<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('emails')->insert([
            [
                "email"=>"valeryyselivanova0@gmail.com",
                "is_active"=>true,
                "user_id"=>1,
            ],

            [
                "email"=>"arnoldsvarcneger86@gmail.com",
                "is_active"=>false,
                "user_id"=>1,
            ],

            [
                "email"=>"dreffka@gmail.com",
                "is_active"=>true,
                "user_id"=>2,
            ],

            [
                "email"=>"mustafa@gmail.com",
                "is_active"=>true,
                "user_id"=>3,
            ],

        ]);
    }
}
