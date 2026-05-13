<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formatos = [
            ['nombre' => 'DVD', 'multiplicador' => 1.00],
            ['nombre' => 'Blu-ray', 'multiplicador' => 1.50],
            ['nombre' => 'Blu-ray UHD', 'multiplicador' => 2.50],
            ['nombre' => 'VHS', 'multiplicador' => 2.00],
        ];
        foreach ($formatos as $formato) {
            DB::table('formato')->insert($formato);
        }
    }
}
