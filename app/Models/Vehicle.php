<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    
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
}
