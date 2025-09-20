<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Route;

class StopRepository
{
    public function getStopsWithDistance(Route $route)
    {
        $stops = DB::table('stops as s')
            ->join('route_stops as rs', 'rs.stop_id', '=', 's.id')
            ->join('routes as r', 'r.id', '=', 'rs.route_id')
            ->select(
                's.id',
                's.name',
                DB::raw("ST_Y(s.geom::geometry) as lat"),
                DB::raw("ST_X(s.geom::geometry) as lng"),
                'rs.stop_order as ord',
                DB::raw("
                    ST_Length(
                        ST_Transform(
                            ST_LineSubstring(
                                r.geom,
                                LAG(ST_LineLocatePoint(r.geom, s.geom)) OVER (ORDER BY rs.stop_order),
                                ST_LineLocatePoint(r.geom, s.geom)
                            ),
                            3857
                        )
                    ) AS distance_from_prev
                ")
            )
            ->where('rs.route_id', $route->id)
            ->whereNull('s.deleted_at')
            ->orderBy('rs.stop_order')
            ->get();

        // Formatear la distancia con tu helper
        $stops->transform(function ($stop) {
            $stop->distance_from_prev = $stop->distance_from_prev
                ? formatear_distancia($stop->distance_from_prev)
                : '0 m';

            return $stop;
        });

        return $stops;
    }
    public function getStopsNotInRoute(Route $route)
    {
        $stops = DB::table('stops as s')
            ->leftJoin('route_stops as rs', function ($join) use ($route) {
                $join->on('rs.stop_id', '=', 's.id')
                    ->where('rs.route_id', '=', $route->id);
            })
            ->select(
                's.id',
                's.name',
                DB::raw("ST_Y(s.geom::geometry) as lat"),
                DB::raw("ST_X(s.geom::geometry) as lng")
            )
            ->whereNull('rs.id')
            ->whereNull('s.deleted_at')
            ->get();

        return $stops;
    }
}
