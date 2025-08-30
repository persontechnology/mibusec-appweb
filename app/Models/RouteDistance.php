<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // Relaciones
    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function fromStop()
    {
        return $this->belongsTo(Stop::class, 'from_stop_id');
    }

    public function toStop()
    {
        return $this->belongsTo(Stop::class, 'to_stop_id');
    }
}
