<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterviewStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('interview_statuses')->insert([
            ["name" => "in progress"],
            ["name" => "published"],
            ["name" => "canceled"],

        ]);

    }
}
