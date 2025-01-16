<?php

namespace Modules\Waste\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Waste\Imports\WasteDatesImport;

class ImportWasteDates extends Command
{
    protected $signature = 'waste:import-dates {file=time_schedule.csv : The CSV file to import}';

    protected $description = 'Imports a csv of a rubbish collection dates';

    public function handle(): int
    {
        $file = $this->argument('file');

        // Import the data
        Excel::import(new WasteDatesImport, $file);

        $this->info("The file {$file} has been successfully imported.");

        return Command::SUCCESS;
    }
}
