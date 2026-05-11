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
        Schema::create('portada_pelicula', function (Blueprint $table) {
            $table->id('id_portada');
            $table->foreignId('id_pelicula')
                ->constrained('pelicula', 'id_pelicula');
            $table->foreignId('id_formato')
                ->constrained('formato', 'id_formato');
            $table->string('imagen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portada_pelicula');
    }
};
