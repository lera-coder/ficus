<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('technologies')->insert([
            ["name" => "laravel"],
            ["name" => "symphony"],
            ["name" => "yii"],
            ["name" => "mysql"],
            ["name" => "mongodb"],
            ["name" => "react"],
            ["name" => "vue"],
            ["name" => "angular"],
            ["name" => "jquery"],
            ["name" => "php"],
            ["name" => "js"],
            ["name" => "node.js"],
            ["name" => "express"],
            ["name" => "c++"],
            ["name" => "c"],
            ["name" => "c#"],
            ["name" => "java"],
        ]);
    }
}
