<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();

        $vehicles = Vehicle::query()
        ->when($q, function ($query) use ($q) {
        $query->where(function ($qq) use ($q) {
            $qq->where('placa', 'like', "%{$q}%")
            ->orWhere('name', 'like', "%{$q}%")
            ->orWhere('marca', 'like', "%{$q}%")
            ->orWhere('modelo', 'like', "%{$q}%");
        });
        })
        ->orderByRaw('name IS NULL, name ASC')
        ->orderBy('placa')
        ->paginate(12)
        ->withQueryString();


        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
