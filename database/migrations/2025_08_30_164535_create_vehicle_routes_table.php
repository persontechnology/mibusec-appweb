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
        Schema::create('vehicle_routes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->foreignId('route_id')->constrained('routes')->onDelete('cascade');
            $table->date('assigned_date')->nullable(); // fecha de asignación del vehículo a la ruta
            $table->enum('status', ['ASSIGNED', 'IN_PROGRESS', 'COMPLETED'])->default('ASSIGNED'); // estado del vehículo en la ruta
            $table->string('notes')->nullable(); // notas adicionales
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_routes');
    }
};
