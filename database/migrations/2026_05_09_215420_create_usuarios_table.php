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
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('usuario')->unique();
            $table->string('password');
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('foto_perfil')->nullable();
            $table->date('fecha_registro');
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->enum('rol', ['socio', 'admin', 'empleado'])->default('socio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
