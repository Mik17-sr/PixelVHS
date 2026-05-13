<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuario')->insert([
            'nombre' => 'Administrador',
            'email' => 'admin@pixelvhs.com',
            'usuario' => 'admin',
            'password' => Hash::make('admin123'),
            'direccion' => 'Bogotá, Colombia',
            'telefono' => '3000000000',
            'foto_perfil' => '',
            'fecha_registro' => now(),
            'estado' => 'activo',
            'rol' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
