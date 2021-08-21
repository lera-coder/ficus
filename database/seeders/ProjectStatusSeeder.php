<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('project_statuses')->insert([
            ["name" => "interviewing"],
            ["name" => "preparation"],
            ["name" => "front-end"],
            ["name" => "back-end"],
            ["name" => "testing"],
            ["name" => "bugs editing"],
            ["name" => "denied"],
            ["name" => "completed"],

        ]);
    }
}
