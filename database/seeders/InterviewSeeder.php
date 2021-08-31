<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\Interview;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Interview::factory()->count(100)->create();

        for ($i = 0; $i < 100; $i++) {
            DB::table('applicants_interviews')->insert(
                [
                    'applicant_id' => Applicant::all()->random()->id,
                    'interview_id' => Interview::all()->random()->id,
                ]
            );
        }
    }
}
