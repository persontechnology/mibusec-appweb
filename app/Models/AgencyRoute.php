<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyRoute extends Model
{
    protected $fillable = ['name', 'code', 'status'];

    // Relaciones
    public function agency()
    {
        return $this->hasMany(Agency::class);
    }
}
