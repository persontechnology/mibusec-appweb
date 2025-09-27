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
        Schema::create('stops', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name')->nullable();
            /* dame la url de la parada despues que se crea */
            $table->string('url_stop')->unique()->nullable();
            $table->geometry('geom', subtype: 'point', srid: 4326); // dame la otra forma tipo polygon
            $table->geometry('geom_polygon', subtype: 'polygon', srid: 4326)->nullable(); // Geometría en forma de polígono
            $table->index(['geom']); // Indexar la columna geom para mejorar el rendimiento de las consultas espaciales
            $table->string('foto')->nullable(); // URL o ruta de la foto
            $table->boolean('estado')->default(true); // Estado activo/inactivo, para interpretar si esta en servicio o no  
            $table->text('descripcion')->nullable(); // Descripción de la parada
            $table->timestamps();
            $table->softDeletes();
        });
         
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stops');
    }
};
