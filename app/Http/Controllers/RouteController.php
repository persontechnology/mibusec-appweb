<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\RouteStop;
use App\Models\Stop;
use App\Repositories\StopRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes = Route::with(['agencyRoute.agency', 'stops'])
            ->withCount([
                'stops' => function ($stops) {
                    $stops->whereNotNull('stops.deleted_at');
                }
            ])
            ->get();
        return  view('routes.index', compact('routes'));
    }

    /**
     * Create a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $routes = Route::with(['agencyRoute.agency', 'stops'])
            ->get();
        $route = new Route();
        return view('routes.create', compact('routes', 'route'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:routes,code',
            'color' => 'required|string|max:7',
            'path' => 'required|json',
        ]);

        $route = new Route();
        $route->name = $request->name;
        $route->code = $request->code;
        $route->color = $request->color;
        $pathPoints = json_decode($request->path, true);

        // Convertimos array de puntos a WKT LINESTRING para PostGIS
        $lineString = implode(',', array_map(fn($p) => "{$p['lng']} {$p['lat']}", $pathPoints));
        $route->geom = DB::raw("ST_GeomFromText('LINESTRING($lineString)', 4326)");

        $route->save();

        return redirect()->route('routes.index')->with('success', 'Route created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Route $route)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Route $route)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Route $route)
    {
        //
    }

    function stops(Route $route)
    {

        $distance = DB::table('routes')
            ->where('id', $route->id)
            ->value(DB::raw("
        ST_Length(
            ST_Transform(geom, 3857)
        )
    "));
        $distance = $distance ? formatear_distancia($distance) : 0; // en km
        $stops = (new StopRepository())->getStopsWithDistance($route);
        return view('routes.stops.index', compact(['stops', 'route', 'distance']));
    }

    function createStops(Route $route)
    {
        $stops = (new StopRepository())->getStopsWithDistance($route);
        return view('routes.stops.create', compact(['stops', 'route']));
    }

    public function storeStop(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:stops,name',
            'location' => 'required|json',
            'route_id' => 'required|exists:routes,id',
        ]);

        $stop = new Stop();
        $stop->name = $request->name;
        //$stop->route_id = $request->route_id;

        $coords = json_decode($request->location, true);
        $stop->geom = DB::raw("ST_SetSRID(ST_MakePoint({$coords['lng']}, {$coords['lat']}), 4326)");

        $stop->save();

        $stopOrder = RouteStop::where('route_id', $request->route_id)->max('stop_order') + 1;

        $routeStop = new RouteStop();
        $routeStop->route_id = $request->route_id;
        $routeStop->stop_id = $stop->id;
        $routeStop->stop_order = $stopOrder;
        $routeStop->save();

        return redirect()->route('routes.stops.index', ['route' => $request->route_id])->with('success', 'Stop created successfully!');
    }
}
