<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generos = [
            'Acción',
            'Terror',
            'Ciencia Ficción',
            'Comedia',
            'Drama',
            'Suspenso',
            'Documental',
            'Fantasía',
            'Musical',
            'Bélico',
            'Western',
            'Misterio',
            'Animación',
            'Crimen',
            'Romance',
            'Aventura',
            'Cyberpunk',
            'Noir'
        ];

        foreach ($generos as $genero) {
            DB::table('genero')->insert([
                'nombre' => $genero
            ]);
        }
    }
}
