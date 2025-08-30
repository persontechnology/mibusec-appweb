<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StopRoute extends Model
{
     use HasFactory;

    protected $fillable = [
        'stop_id',
        'route_id',
        'sort_order',
        'arrival_time',
        'departure_time',
        'notes',
        'status',
    ];
    // Relaciones
    public function stop()
    {
        return $this->belongsTo(Stop::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
    
}
