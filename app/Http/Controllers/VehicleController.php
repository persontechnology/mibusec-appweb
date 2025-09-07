<?php

namespace App\Http\Controllers;

use App\DataTables\VehicleDataTable;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(VehicleDataTable $dataTable)
    {
        return $dataTable->render('vehicles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicle = new Vehicle();
        return view('vehicles.create', compact('vehicle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'license_plate' => ['required','string','max:50','unique:vehicles,license_plate'],
            'name'          => ['required','string','max:255'],
            'description'   => ['nullable','string'],
            'capacity'      => ['nullable','string','max:100'],
            'status'        => ['nullable', Rule::in(['ACTIVE','ANACTIVE'])],
            'notes'         => ['nullable','string'],
        ]);

        $vehicle = Vehicle::create($data);

        return redirect()->route('vehicles.show',$vehicle)
            ->with('success', 'Vehículo creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'license_plate' => ['required','string','max:50', Rule::unique('vehicles','license_plate')->ignore($vehicle->id)],
            'name'          => ['required','string','max:255'],
            'description'   => ['nullable','string'],
            'capacity'      => ['nullable','string','max:100'],
            'status'        => ['nullable', Rule::in(['ACTIVE','ANACTIVE'])],
            'notes'         => ['nullable','string'],
        ]);

        $vehicle->update($data);

        return redirect()->route('vehicles.show',$vehicle)->with('success', 'Vehículo actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        try {
            $vehicle->delete();
            return redirect()
                ->route('vehicles.index')
                ->with('success', 'Vehículo eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('vehicles.index')
                ->with('error', 'No se pudo eliminar el vehículo. Es posible que esté en uso.');
        }   
    }
}
