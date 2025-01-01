<?php

namespace App\Console\Commands;

use App\Imports\WasteDatesImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportRubbishDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'waste:import-dates {file=time_schedule.csv : The CSV file to import}';

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
    public function handle(): int
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("The file {$file} does not exist.");
            return Command::FAILURE;
        }

        // Import the data
        Excel::import(new WasteDatesImport(), $file);

        $this->info("The file {$file} has been successfully imported.");

        return Command::SUCCESS;
    }
}
