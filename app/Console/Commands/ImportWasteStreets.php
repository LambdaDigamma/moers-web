<?php

namespace App\Console\Commands;

use App\Imports\WasteDatesImport;
use App\Imports\WasteStreetsImport;
use App\Models\RubbishStreet;
use Excel;
use Illuminate\Console\Command;

class ImportWasteStreets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'waste:import-streets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports a csv of a rubbish collection streets';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        RubbishStreet::query()->truncate();

        Excel::import(new WasteStreetsImport(), 'street_register_2023.csv');

        return Command::SUCCESS;
    }
}
