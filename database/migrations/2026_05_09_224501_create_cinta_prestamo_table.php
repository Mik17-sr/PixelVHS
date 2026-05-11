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
        Schema::create('cinta_prestamo', function (Blueprint $table) {
            $table->foreignId('id_prestamo')
                ->constrained('prestamo', 'id_prestamo');
            $table->foreignId('id_cinta')
                ->constrained('cinta', 'id_cinta');
            $table->primary([
                'id_prestamo',
                'id_cinta'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cinta_prestamo');
    }
};
