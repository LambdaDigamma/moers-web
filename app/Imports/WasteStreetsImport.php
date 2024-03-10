<?php

namespace App\Imports;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Rubbish\Models\RubbishStreet;

class WasteStreetsImport implements ToModel, WithCustomCsvSettings, WithHeadingRow
{
    public function model(array $row)
    {
        return new RubbishStreet([
            'id' => $row['id'],
            'name' => $row['name'],
            'street_addition' => $row['zusatz'],
            'residual_tour' => $row['restabfall'],
            'organic_tour' => $row['biotonne'],
            'paper_tour' => $row['papiertonne'],
            'plastic_tour' => $row['gelber_sack'],
            'cuttings_tour' => $row['gruenschnitt'],
            'year' => Carbon::now()->year
        ]);
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }
}
