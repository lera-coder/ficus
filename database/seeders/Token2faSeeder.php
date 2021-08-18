<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Token2faSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('token2fas')->insert([
                ['user_id'=>1],
                ['user_id'=>2],
                ['user_id'=>3],
                ]);
    }
}
