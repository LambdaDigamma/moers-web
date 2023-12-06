<?php

namespace Database\Seeders;

use App\Models\Quarter;
use Illuminate\Database\Seeder;

class QuarterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $quarters = collect([
            [
                'name' => 'Rheinkamp-Mitte',
                'postcode' => '47445'
            ],
            [
                'name' => 'Rheinkamp-Repelen',
                'postcode' => '47445'
            ],
            [
                'name' => 'Rheinkamp-Baerler Busch',
                'postcode' => '47443'
            ],
            [
                'name' => 'Rheinkamp-Genend',
                'postcode' => '47445'
            ],
            [
                'name' => 'Rheinkamp-Bornheim',
                'postcode' => '47445'
            ],
            [
                'name' => 'Rheinkamp-Eick',
                'postcode' => '47445'
            ],
            [
                'name' => 'Rheinkamp-Utfort',
                'postcode' => '47445'
            ],
            [
                'name' => 'Rheinkamp-Kohlenhuck',
                'postcode' => '47445'
            ],
            [
                'name' => 'Rheinkamp-Meerbeck',
                'postcode' => '47443'
            ],
            [
                'name' => 'Moers-Mitte',
                'postcode' => '47441'
            ],
            [
                'name' => 'Moers-Asberg',
                'postcode' => '47441'
            ],
            [
                'name' => 'Moers-Scherpenberg',
                'postcode' => '47443'
            ],
            [
                'name' => 'Moers-Hülsdonk',
                'postcode' => '47441'
            ],
            [
                'name' => 'Moers-Hochstraß',
                'postcode' => '47443'
            ],
            [
                'name' => 'Moers-Schwafheim',
                'postcode' => '47447'
            ],
            [
                'name' => 'Moers-Vinn',
                'postcode' => '47447'
            ],
            [
                'name' => 'Kapellen-Mitte',
                'postcode' => '47447'
            ],
            [
                'name' => 'Kapellen-Achterathsfeld',
                'postcode' => '47447'
            ],
            [
                'name' => 'Kapellen-Achterathsheide',
                'postcode' => '47447'
            ],
            [
                'name' => 'Kapellen-Bettenkamp',
                'postcode' => '47447'
            ],
            [
                'name' => 'Kapellen-Holderberg',
                'postcode' => '47447'
            ],
            [
                'name' => 'Kapellen-Vennikel',
                'postcode' => '47447'
            ],
        ]);

        $quarters->each(function ($quarter) {
            $q = Quarter::create($quarter);
        });

    }
}
