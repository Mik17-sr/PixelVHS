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
        Schema::create('tipo_multa', function (Blueprint $table) {
            $table->id('id_tipo_multa');
            $table->enum('concepto', ['Retraso', 'Daño', 'Perdida', 'No entregada']);
            $table->decimal('multiplicador', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_multa');
    }
};
