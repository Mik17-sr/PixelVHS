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
        Schema::create('formato', function (Blueprint $table) {
            $table->id('id_formato');
            $table->enum('nombre', ['DVD', 'Blu-ray', 'Blu-ray UHD','VHS']);
            $table->decimal('multiplicador', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formato');
    }
};
