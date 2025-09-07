<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouteDistance extends Model
{
     use HasFactory;

    protected $fillable = [
        'from_stop_id',
        'to_stop_id',
        'route_id',
        'distance_km',
        'estimated_time',
    ];

     // La distancia pertenece a una ruta
    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    // Parada de origen
    public function fromStop(): BelongsTo
    {
        return $this->belongsTo(Stop::class, 'from_stop_id');
    }

    // Parada de destino
    public function toStop(): BelongsTo
    {
        return $this->belongsTo(Stop::class, 'to_stop_id');
    }
}
