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
        Schema::create('stop_routes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('stop_id')->constrained('stops')->onDelete('cascade');
            $table->foreignId('route_id')->constrained('routes')->onDelete('cascade');
            $table->integer('sort_order')->nullable(); // para ordenar las paradas en la ruta
            $table->time('arrival_time')->nullable(); // hora de llegada estimada
            $table->time('departure_time')->nullable(); // hora de salida estimada
            $table->string('notes')->nullable(); // notas adicionales
            $table->enum('status', ['START', 'PROCESS','END'])->default('START'); // estado de la parada en la ruta
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stop_routes');
    }
};
