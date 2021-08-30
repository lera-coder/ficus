<?php

namespace Database\Seeders;

use App\Models\Worker;
use App\Models\WorkerEmail;
use App\Models\WorkerPhone;
use Illuminate\Database\Seeder;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Worker::factory()->count(20)
            ->has(WorkerPhone::factory()->count(rand(1,3)), 'phones')
            ->has(WorkerEmail::factory()->count(rand(1,3)), 'emails')
            ->create();
    }
}
