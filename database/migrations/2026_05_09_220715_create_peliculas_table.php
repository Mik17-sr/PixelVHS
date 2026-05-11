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
        Schema::create('pelicula', function (Blueprint $table) {
            $table->id('id_pelicula');
            $table->string('titulo');
            $table->text('resumen')->nullable();
            $table->integer('anio_lanzamiento');
            $table->integer('duracion_minutos');
            $table->string('estudio');
            $table->decimal('precio_alquiler', 10, 2);
            $table->string('foto_caratula')->nullable();
            $table->string('foto_portada')->nullable();
            $table->string('banner')->nullable();
            $table->enum('clasificacion', ['G','PG','PG-13','R','NC-17']);
            $table->unsignedBigInteger('id_director');
            $table->unsignedBigInteger('id_genero');
            $table->foreign('id_director')->references('id_director')->on('director');
            $table->foreign('id_genero')->references('id_genero')->on('genero');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelicula');
    }
};
