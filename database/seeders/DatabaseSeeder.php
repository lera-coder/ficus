<?php

namespace Database\Seeders;

use App\Models\Interview;
use App\Models\WorkerPhone;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(
            [
                NetworkSeeder::class,
                UserSeeder::class,
                PhoneCountryCodeSeeder::class,
                PhoneSeeder::class,
                RoleSeeder::class,
                Token2faSeeder::class,
                EmailSeeder::class,
                ApplicantStatusSeeder::class,
                LevelSeeder::class,
                TechnologySeeder::class,
                WorkerStatusSeeder::class,
                WorkerPositionSeeder::class,
                ProjectStatusSeeder::class,
                CompanySeeder::class,
                WorkerSeeder::class,
                ApplicantSeeder::class,
                ProjectSeeder::class,
                KnowledgeSeeder::class,
                InterviewStatusSeeder::class,
                UserPermissionSeeder::class,
                InterviewSeeder::class

            ]
        );
    }
}
