<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create file laravel.log and queue work';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        fopen("logs/laravel.log", "w");
        Artisan::call("queue:work --daemon");
    }
}
