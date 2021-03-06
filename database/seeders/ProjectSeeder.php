<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Project::factory()->count(20)->create();


        foreach (Project::all() as $project){
            foreach (Technology::all()->random(rand(1,5)) as $technology) {
                    DB::table('projects_technologies')->insert([
                        ["technology_id" => $technology->id,
                            "project_id"=> $project->id]
                    ]);

            }

            foreach (User::all()->random(rand(1,3)) as $user) {
                DB::table('users_projects')->insert([
                    ["user_id" => $user->id,
                        "project_id"=> $project->id]
                ]);
              }
            }
        }

}
