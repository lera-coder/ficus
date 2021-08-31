<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_permissions')->insert([
            ["name" => "look"],
            ["name" => "edit and create"],

        ]);


        for($i = 0; $i < 100; $i++) {
            DB::table('users_applicants_permissions')->insert(
                [
                    'user_id' => User::all()->random()->id,
                    'applicant_id' => Applicant::all()->random()->id,
                    'permission_id'=> UserPermission::all()->random()->id,

                ]
            );
        }
    }
}
