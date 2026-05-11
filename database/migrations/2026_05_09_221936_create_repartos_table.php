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
        Schema::create('reparto', function (Blueprint $table) {
            $table->foreignId('id_actor')
                ->constrained('actor', 'id_actor');
            $table->foreignId('id_pelicula')
                ->constrained('pelicula', 'id_pelicula');
            $table->string('papel');
            $table->primary([
                'id_actor',
                'id_pelicula'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reparto');
    }
};
