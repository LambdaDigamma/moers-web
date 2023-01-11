<?php

namespace App\Imports;

use App\Models\RubbishScheduleItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Excel;

class WasteDatesImport implements ToModel, WithCustomCsvSettings, WithHeadingRow
{
    public function model(array $row)
    {
        return new RubbishScheduleItem([
            'date' => Carbon::parse($row['datum'], 'Europe/Berlin'),
            'residual_tours' => $row['restabfall'],
            'organic_tours' => $row['biotonne'],
            'paper_tours' => $row['papiertonne'],
            'plastic_tours' => $row['gelber_sack'],
            'cuttings_tours' => $row['gruenschnitt']
        ]);
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }
}
