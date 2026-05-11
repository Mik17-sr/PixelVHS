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
        Schema::create('gusta_actor', function (Blueprint $table) {
            $table->foreignId('id_socio')
                ->constrained('socio', 'id_socio');
            $table->foreignId('id_actor')
                ->constrained('actor', 'id_actor');
            $table->primary([
                'id_socio',
                'id_actor'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gusta_actor');
    }
};
