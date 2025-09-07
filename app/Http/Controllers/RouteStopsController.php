<?php

namespace App\Http\Controllers;

use App\DataTables\RouteStopsDataTable;
use App\Models\Route;
use App\Models\RouteDistance;
use App\Models\Stop;
use App\Models\StopRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RouteStopsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RouteStopsDataTable $dataTable, Route $route)
    {
        $route_distances = $route->distances()->with(['fromStop', 'toStop'])->get();
        // Pasar las distancias a la vista mediante el DataTable
        return $dataTable->with('route', $route)
                         ->with('route_distances', $route_distances)
                         ->render('route_stops.index', compact('route', 'route_distances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Route $route)
    {
        // Todas las paradas disponibles (para el DualListbox)
        $allStops = Stop::orderBy('code')->get();

        // IDs ya asignados a la ruta, ordenados por sort_order del pivote
        // Laravel 9+: orderByPivot; en versiones anteriores usa orderBy('stop_routes.sort_order')
        $selectedStopIds = $route->stops()
            ->orderByPivot('sort_order')
            ->pluck('stops.id')   // explícito para evitar confundir con el id del pivote
            ->all();

        return view('route_stops.create', compact('route', 'allStops', 'selectedStopIds'));

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Route $route)
    {
         $data = $request->validate([
            'stops'   => ['required','array','min:2'],
            'stops.*' => ['integer','distinct', Rule::exists('stops','id')],
        ], [
            'stops.required'   => 'Debes enviar las paradas.',
            'stops.array'      => 'El formato de paradas es inválido.',
            'stops.min'        => 'La ruta debe tener al menos 2 paradas.',
            'stops.*.distinct' => 'Hay paradas repetidas.',
        ]);

        $ids = $data['stops'] ?? [];

        $pivot = [];
        foreach ($ids as $i => $stopId) {
            
            
            /* a la parada inicial poner status=START y parada ultimo poner status=END */
            if ($i == 0) {
                $pivot[$stopId]['status'] = 'START';
            } elseif ($i == count($ids) - 1) {
                $pivot[$stopId]['status'] = 'END';
            } else {
                $pivot[$stopId]['status'] = 'PROCESS';
            }

            $pivot[$stopId]['sort_order'] = $i + 1; // orden empieza en 1

        }

        try {
            DB::beginTransaction();
            // Sincronizar las paradas con la ruta, eliminando las que no están en la lista
            $route->stops()->sync($pivot);

            
            /* Ejemplo: Si la ruta tiene las paradas [1, 2, 3, 4, 5], route_distances debe tener:
            - De 1 a 2
            - De 2 a 3
            - De 3 a 4
            - De 4 a 5 */
            
            $route->distances()->delete(); // eliminar distancias previas
            for ($i = 0; $i < count($ids) - 1; $i++) {
                RouteDistance::create([
                    'route_id'     => $route->id,
                    'from_stop_id' => $ids[$i],
                    'to_stop_id'   => $ids[$i + 1],
                    // 'distance_km'  => null, // se puede actualizar luego
                    // 'estimated_time' => null, // se puede actualizar luego
                ]);
            }
                
            DB::commit();
            return redirect()->route('route.stops.index', $route)
            ->with('success', 'Paradas de la ruta guardadas correctamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
            return back()->withInput()
            ->withErrors(['error' => 'Ocurrió un error al guardar las paradas de la ruta: ']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StopRoute $stopRoute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StopRoute $stopRoute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StopRoute $stopRoute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StopRoute $stopRoute)
    {
        //
    }
}
