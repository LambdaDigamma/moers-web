<?php

namespace App\Console\Commands;

use App\Imports\WasteDatesImport;
use Excel;
use Illuminate\Console\Command;

class ImportRubbishDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'waste:import-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports a csv of a rubbish collection dates';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Excel::import(new WasteDatesImport(), 'time_schedule_2023.csv');

        return Command::SUCCESS;
    }
}
