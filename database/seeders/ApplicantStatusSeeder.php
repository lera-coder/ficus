<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicantStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('applicant_statuses')->insert([
            ["name" => "pending"],
            ["name" => "waiting for interview"],
            ["name" => "on testtask"],
            ["name" => "not decided"],
            ["name" => "denied"],
            ["name" => "accepted"],
        ]);
    }
}
