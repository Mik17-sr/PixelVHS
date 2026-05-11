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
        Schema::create('pago_multa', function (Blueprint $table) {
            $table->foreignId('id_pago')
                ->constrained('pago', 'id_pago');
            $table->foreignId('id_multa')
                ->constrained('multa', 'id_multa');
            $table->primary([
                'id_pago',
                'id_multa'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago_multa');
    }
};
