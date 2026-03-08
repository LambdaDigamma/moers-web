<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DebugLoadAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:debug-load-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('events:load-moers-events');
        Artisan::call('events:load-moers-festival-events');
        Artisan::call('waste:import-dates time_schedule_2026.csv');
        Artisan::call('waste:import-streets street_register_2026.csv');
    }
}
