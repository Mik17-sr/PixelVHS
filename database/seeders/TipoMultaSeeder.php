<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoMulta;

class TipoMultaSeeder extends Seeder
{
    public function run(): void
    {
        TipoMulta::firstOrCreate(
            ['concepto' => 'RETRASO'],
            ['multiplicador' => 1.5]
        );

        TipoMulta::firstOrCreate(
            ['concepto' => 'DAÑO'],
            ['multiplicador' => 5.0]
        );

        TipoMulta::firstOrCreate(
            ['concepto' => 'PÉRDIDA'],
            ['multiplicador' => 10.0]
        );
    }
}