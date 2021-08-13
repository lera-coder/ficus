<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhoneCountryCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
   {
       DB::table('phone_country_codes')->insert([
           [
               "code" => "+38",
               "country" => "Ukraine",
           ],

           [
               "code" => "+7",
               "country" => "Russia",
           ],

       ]);
   }
}
