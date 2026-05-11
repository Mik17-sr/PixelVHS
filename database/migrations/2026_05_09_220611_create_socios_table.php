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
        Schema::create('socio', function (Blueprint $table) {
            $table->unsignedBigInteger('id_socio')->primary();
            $table->integer('max_peliculas_simultaneas');
            $table->timestamps();
            $table->foreign('id_socio')
                ->references('id_usuario')
                ->on('usuario')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socio');
    }
};
