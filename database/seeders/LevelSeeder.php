<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->insert([
            ["name" => "trainee"],
            ["name" => "junior"],
            ["name" => "middle"],
            ["name" => "senior"],
            ["name" => "team lead"],
            ["name" => "manager"],
        ]);
    }
}
