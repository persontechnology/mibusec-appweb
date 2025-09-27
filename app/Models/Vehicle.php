<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'codigo', /* obligatorio */
        'name',
        'latitud',
        'longitud',
        'velocidad',

        'marca',
        'modelo',
        'anio',
        'placa', /* obligatorio desde la web */
        'color',
        'observaciones',
        'foto',
    ];


    // Relacion muchos a muchos con Agency a traves de agency_vehicles
    public function agencies(){
        return $this->belongsToMany(Agency::class, 'agency_vehicles')
        ->withTimestamps()
        ->withPivot(['assigned_by', 'status', 'notes', 'deleted_at']);
    }
}
