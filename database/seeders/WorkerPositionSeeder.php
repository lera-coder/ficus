<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkerPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('worker_positions')->insert([
            ["name" => "manager"],
            ["name" => "team lead"],
            ["name" => "developer"],
            ["name" => "hr manager"],
            ["name" => "designer"],
            ["name" => "tester"],
        ]);
    }
}
