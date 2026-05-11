<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prestamo', function (Blueprint $table) {
            $table->id('id_prestamo');
            $table->foreignId('id_socio')
                ->constrained('socio', 'id_socio');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_limite');
            $table->dateTime('fecha_devolucion')->nullable();
            $table->enum('estado', ['Activo', 'Cancelado', 'Terminado'])->default('Activo');
            $table->decimal('cargo_diario', 10, 2);
            $table->string('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamo');
    }
};
