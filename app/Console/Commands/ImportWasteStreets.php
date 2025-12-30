<?php

namespace App\Console\Commands;

use App\Imports\WasteStreetsImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Rubbish\Models\RubbishStreet;

class ImportWasteStreets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'waste:import-streets {file=street_register.csv : The CSV file to import}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $file = $this->argument('file');

        // Check if the file exists
//        if (!file_exists($file)) {
//            $this->error("The file {$file} does not exist.");
//            return Command::FAILURE;
//        }

//        DB::transaction(function () use ($file) {
            // Truncate the table
            RubbishStreet::query()->truncate();

            // Import the data
            Excel::import(new WasteStreetsImport(), $file);
//        });

        $this->info("The file {$file} has been successfully imported.");

        return Command::SUCCESS;
    }
}
