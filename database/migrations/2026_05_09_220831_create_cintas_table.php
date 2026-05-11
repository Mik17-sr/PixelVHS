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
        Schema::create('cinta', function (Blueprint $table) {
            $table->id('id_cinta');
            $table->foreignId('id_pelicula')
                ->constrained('pelicula', 'id_pelicula');
            $table->foreignId('id_formato')
                ->constrained('formato', 'id_formato');
            $table->enum('estado', ['Disponible', 'Prestada', 'En mantenimiento', 'Perdida', 'Dañada'])->default('Disponible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cinta');
    }
};
