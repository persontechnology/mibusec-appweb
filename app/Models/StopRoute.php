<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    
    // Relación inversa a Route
    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    // Relación inversa a Stop
    public function stop(): BelongsTo
    {
        return $this->belongsTo(Stop::class);
    }
    
}
