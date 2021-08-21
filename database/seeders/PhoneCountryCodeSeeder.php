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
               "code" => "38",
               "country" => "Ukraine",
           ],

           [
               "code" => "7",
               "country" => "Russia",
           ],

           [
               "code" => "93",
               "country" => "Afganistan",
           ],

           [
               "code" => "355",
               "country" => "Albania",
           ],

           [
               "code" => "21",
               "country" => "Algeria",
           ],

           [
               "code" => "684",
               "country" => "American Samoa",
           ],

           [
               "code" => "376",
               "country" => "Andorra",
           ],

           [
               "code" => "244",
               "country" => "Angola",
           ],

           [
               "code" => "49",
               "country" => "Germany",
           ],

           [
               "code" => "30",
               "country" => "Greece",
           ],

           [
               "code" => "299",
               "country" => "Greenland",
           ],

           [
               "code" => "960",
               "country" => "Maldives",
           ],

           [
               "code" => "356",
               "country" => "Malta",
           ],

           [
               "code" => "212",
               "country" => "Marocco",
           ],

           [
               "code" => "47",
               "country" => "Norway",
           ],

           [
               "code" => "92",
               "country" => "Pakistan",
           ],

           [
               "code" => "351",
               "country" => "Portugal",
           ],

           [
               "code" => "90",
               "country" => "Turkey",
           ],

           [
               "code" => "993",
               "country" => "Turkmenistan",
           ],

           [
               "code" => "44",
               "country" => "United Kingdom	",
           ],

       ]);
   }
}
