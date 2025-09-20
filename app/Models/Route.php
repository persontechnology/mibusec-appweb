<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Route extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'code', 'path', 'status'];

    protected $appends = ['coordinates'];

    public function getCoordinatesAttribute()
    {
        return DB::table('routes')
            ->where('id', $this->id)
            ->selectRaw("ST_AsGeoJSON(geom)::json->'coordinates' as coords")
            ->value('coords');
    }


    // Mutador: asignar LINESTRING desde array de puntos [[lng, lat], ...]
    public function setPathAttribute(array $points)
    {
        $pointStrings = array_map(fn($p) => "{$p['lng']} {$p['lat']}", $points);
        $lineString = implode(',', $pointStrings);
        $this->attributes['path'] = DB::raw("ST_GeomFromText('LINESTRING({$lineString})', 4326)");
    }

    // Accesor: obtener array de puntos de la ruta
    public function getPathPointsAttribute()
    {
        $points = DB::select("
            SELECT ST_X(geom) AS lng, ST_Y(geom) AS lat
            FROM ST_DumpPoints(path) AS geom
            WHERE id = ?
        ", [$this->id]);

        return $points;
    }

    // Relaciones
    public function stops()
    {
        return $this->belongsToMany(Stop::class, 'route_stops')
            ->withPivot('stop_order')
            ->orderBy('pivot_stop_order');
    }

    public function buses()
    {
        return $this->hasMany(Bus::class);
    }

    public function agencyRoute()
    {
        return $this->belongsTo(AgencyRoute::class);
    }
}
