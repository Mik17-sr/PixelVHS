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
        Schema::create('pago_prestamo', function (Blueprint $table) {
            $table->foreignId('id_pago')
                ->constrained('pago', 'id_pago');
            $table->foreignId('id_prestamo')
                ->constrained('prestamo', 'id_prestamo');
            $table->primary([
                'id_pago',
                'id_prestamo'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago_prestamo');
    }
};
