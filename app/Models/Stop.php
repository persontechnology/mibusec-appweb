<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stop extends Model
{
    use HasFactory;
     protected $fillable = [
        'code',
        'name',
        'description',
        'latitude',
        'longitude',
        'address',
        'status',
        'notes',
    ];

    // Una parada aparece en muchas filas de stop_routes
    public function stopRoutes(): HasMany
    {
        return $this->hasMany(StopRoute::class);
    }
    
    // Muchas rutas pasan por muchas paradas (tabla pivote stop_routes)
    public function routes(): BelongsToMany
    {
        return $this->belongsToMany(Route::class, 'stop_routes')
                    ->withPivot(['sort_order', 'arrival_time', 'departure_time', 'notes', 'status']) // agrega más campos si tienes
                    ->withTimestamps();
    }

    // Distancias donde esta parada es el origen
    public function distancesFrom(): HasMany
    {
        return $this->hasMany(RouteDistance::class, 'from_stop_id');
    }

    // Distancias donde esta parada es el destino
    public function distancesTo(): HasMany
    {
        return $this->hasMany(RouteDistance::class, 'to_stop_id');
    }
}
