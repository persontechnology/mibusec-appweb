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
        Schema::create('route_distances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('from_stop_id')->constrained('stops')->onDelete('cascade');
            $table->foreignId('to_stop_id')->constrained('stops')->onDelete('cascade');
            $table->foreignId('route_id')->constrained('routes')->onDelete('cascade');
            $table->float('distance_km')->nullable(); // distancia en kilómetros
            $table->time('estimated_time')->nullable(); // tiempo estimado entre las paradas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_distances');
    }
};
