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
        Schema::create('valoracion', function (Blueprint $table) {
            $table->foreignId('id_socio')
                ->constrained('socio', 'id_socio');
            $table->foreignId('id_pelicula')
                ->constrained('pelicula', 'id_pelicula');
            $table->integer('puntuacion');
            $table->text('comentario')->nullable();
            $table->dateTime('fecha');
            $table->primary([
                'id_socio',
                'id_pelicula'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valoracion');
    }
};
