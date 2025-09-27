<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agency extends Model
{
    use SoftDeletes,HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'image',
    ];


    
    // Relacion muchos a muchos con Vehicle a traves de agency_vehicles
    public function vehicles(){
        return $this->belongsToMany(Vehicle::class, 'agency_vehicles')
        ->withTimestamps()
        ->withPivot(['assigned_by', 'status', 'notes', 'deleted_at']);
    }

}
