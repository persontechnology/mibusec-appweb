<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
    ];

    // Cada ruta tiene muchas filas en la tabla pivote stop_routes
    public function stopRoutes()
    {
        return $this->hasMany(StopRoute::class);
    }

    // App/Models/Route.php
    public function stops()
    {
        return $this->belongsToMany(Stop::class, 'stop_routes')
                   ->withPivot([
                        'id',
                        'sort_order', 
                        'arrival_time', 
                        'departure_time', 
                        'notes', 
                        'status'
                    ]) // agrega más campos si tienes
                    ->withTimestamps()
                    ->orderByPivot('sort_order','asc');
    }

    // Distancias/tiempos entre pares de paradas dentro de la ruta
    public function distances()
    {
        return $this->hasMany(RouteDistance::class);
    }
}
