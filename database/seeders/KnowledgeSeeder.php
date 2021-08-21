<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\Knowledge;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Database\Seeder;

class KnowledgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->filling(User::all(), 'App\Models\User');
        $this->filling(Applicant::all(), 'App\Models\Applicant');
    }



    private function filling($users, $model_path){
        foreach ($users as $user) {
            $technology_quantity = rand(4, 7);

            foreach(Technology::all()->random($technology_quantity) as $technology) {
                Knowledge::factory()->count(1)->state(
                    [
                        'knowledgable_type' => $model_path,
                        'knowledgable_id' => $user->id,
                        'technology_id' => $technology->id]
                )->create();
            }
        }
    }
}
