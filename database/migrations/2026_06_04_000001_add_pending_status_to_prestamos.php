<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Cambiar el enum para agregar 'Pendiente'
        Schema::table('prestamo', function (Blueprint $table) {
            // Para MariaDB/MySQL, usamos una sintaxis raw
            DB::statement("ALTER TABLE prestamo MODIFY COLUMN estado ENUM('Activo', 'Cancelado', 'Terminado', 'Pendiente') NOT NULL DEFAULT 'Activo'");
        });
    }

    public function down(): void
    {
        Schema::table('prestamo', function (Blueprint $table) {
            // Revertir al enum original
            DB::statement("ALTER TABLE prestamo MODIFY COLUMN estado ENUM('Activo', 'Cancelado', 'Terminado') NOT NULL DEFAULT 'Activo'");
        });
    }
};
