<?php

namespace Modules\Waste\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Waste\Imports\WasteStreetsImport;
use Modules\Waste\Models\RubbishStreet;

class ImportWasteStreets extends Command
{
    protected $signature = 'waste:import-streets {file=street_register.csv : The CSV file to import}';

    protected $description = '';

    public function handle(): int
    {
        $file = $this->argument('file');

        // Truncate the table
        RubbishStreet::query()->truncate();

        // Import the data
        Excel::import(new WasteStreetsImport, $file);

        $this->info("The file {$file} has been successfully imported.");

        return Command::SUCCESS;
    }
}
