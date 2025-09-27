<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Stop extends Model
{   
    
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'url_stop',
        'geom',
        'geom_polygon',
        'foto',
        'estado',
        'descripcion',
    ];

    // Mutador: crear POINT desde array ['lat'=>..., 'lng'=>...]
    public function setLocationAttribute($value)
    {
        if (is_array($value) && isset($value['lat'], $value['lng'])) {
            $this->attributes['location'] = DB::raw("ST_SetSRID(ST_MakePoint({$value['lng']}, {$value['lat']}), 4326)");
        }
    }

    // Accesores para lat/lng
    public function getLatAttribute()
    {
        $res = DB::selectOne("SELECT ST_Y(location::geometry) AS lat FROM stops WHERE id = ?", [$this->id]);
        return $res->lat ?? null;
    }

    public function getLngAttribute()
    {
        $res = DB::selectOne("SELECT ST_X(location::geometry) AS lng FROM stops WHERE id = ?", [$this->id]);
        return $res->lng ?? null;
    }
}
