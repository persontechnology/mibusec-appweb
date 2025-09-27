<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use Illuminate\Support\Str;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $agencyId = $request->input('agency');
        $estado = $request->input('estado', 'activo');

        $vehicles = Vehicle::with('agencies')
            ->withTrashed()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('placa', 'like', "%{$q}%")
                        ->orWhere('name', 'like', "%{$q}%")
                        ->orWhere('marca', 'like', "%{$q}%")
                        ->orWhere('modelo', 'like', "%{$q}%")
                        ->orWhere('codigo', 'like', "%{$q}%");
                });
            })
            ->when($agencyId, function ($query) use ($agencyId) {
                $query->whereHas('agencies', function ($q) use ($agencyId) {
                    $q->where('agencies.id', $agencyId);
                });
            })
            ->when($estado === 'activo', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->when($estado === 'eliminado', function ($query) {
                $query->whereNotNull('deleted_at');
            })
            ->orderByRaw('name IS NULL, name ASC')
            ->orderBy('placa')
            ->paginate(9)
            ->withQueryString();

        $agencies = Agency::orderBy('name')->get();

        // Aquí agregas $estado
        return view('vehicles.index', compact('vehicles', 'agencies', 'estado'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agencies = Agency::orderBy('name')->get();
        return view('vehicles.create', compact('agencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo'      => 'required|string|max:255|unique:vehicles,codigo',
            'placa'       => 'required|string|max:255|unique:vehicles,placa',
            'name'        => 'nullable|string|max:255',
            'marca'       => 'nullable|string|max:255',
            'modelo'      => 'nullable|string|max:255',
            'anio'        => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'color'       => 'nullable|string|max:100',
            'observaciones' => 'nullable|string|max:1000',
            'velocidad'   => 'nullable|numeric|min:0',
            'latitud'     => 'required|numeric|between:-90,90',
            'longitud'    => 'required|numeric|between:-180,180',
            'foto'        => 'nullable|image|max:2048',
            'agency_id'   => 'nullable|exists:agencies,id',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $data['foto'] = $file->storeAs('vehicles', $filename, 'public');
        }

        $agencyId = $data['agency_id'] ?? null; // Guardar el ID de la agencia seleccionada
        unset($data['agency_id']); // Eliminar del array de datos para crear el vehículo

        $vehicle = Vehicle::create($data);

        if ($agencyId) {
            $vehicle->agencies()->attach($agencyId, [
                'assigned_by' => Auth::id(),
                'status' => 'activo',
                'notes' => null,
            ]);
        }

        return redirect()->route('vehicles.index')->with('success', 'Vehículo registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        // Cargar la relación de agencias si no está cargada
        $vehicle->load('agencies');

        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        $agencies = Agency::orderBy('name')->get();
        return view('vehicles.edit', compact('vehicle', 'agencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'codigo'      => 'required|string|max:255|unique:vehicles,codigo,' . $vehicle->id,
            'placa'       => 'required|string|max:255|unique:vehicles,placa,' . $vehicle->id,
            'name'        => 'nullable|string|max:255',
            'marca'       => 'nullable|string|max:255',
            'modelo'      => 'nullable|string|max:255',
            'anio'        => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'color'       => 'nullable|string|max:100',
            'observaciones' => 'nullable|string|max:1000',
            'velocidad'   => 'nullable|numeric|min:0',
            'latitud'     => 'required|numeric|between:-90,90',
            'longitud'    => 'required|numeric|between:-180,180',
            'foto'        => 'nullable|image|max:2048',
            'agency_id'   => 'nullable|exists:agencies,id',
        ]);

        if ($request->hasFile('foto')) {
            // Elimina la foto anterior si existe
            if ($vehicle->foto) {
                Storage::disk('public')->delete($vehicle->foto);
            }
            $file = $request->file('foto');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $data['foto'] = $file->storeAs('vehicles', $filename, 'public');
        }

        $agencyId = $data['agency_id'] ?? null;
        unset($data['agency_id']);

        $vehicle->update($data);

        // Sincroniza la agencia (solo una agencia por vehículo)
        if ($agencyId) {
            $vehicle->agencies()->sync([
                $agencyId => [
                    'assigned_by' => Auth::id(),
                    'status' => 'activo',
                    'notes' => null,
                ]
            ]);
        } else {
            // Si no se selecciona agencia, desvincula todas
            $vehicle->agencies()->detach();
        }

        return redirect()->route('vehicles.index')->with('success', 'Vehículo actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        try {
            $vehicle->delete();
            return redirect()->route('vehicles.index')->with('success', 'Vehículo enviado a la papelera.');
        } catch (\Exception $e) {
            return redirect()->route('vehicles.index')->with('error', 'Error al eliminar el vehículo: ' . $e->getMessage());
        }
    }

    /* force delete */
    public function forceDelete($id)
    {
        try {
            $vehicle = Vehicle::withTrashed()->findOrFail($id);
            // Elimina la foto si existe
            if ($vehicle->foto) {
                Storage::disk('public')->delete($vehicle->foto);
            }
            $vehicle->forceDelete();
            return redirect()->route('vehicles.index')->with('success', 'Vehículo eliminado permanentemente.');
        } catch (\Exception $e) {
            return redirect()->route('vehicles.index')->with('error', 'Error al eliminar el vehículo: ' . $e->getMessage());
        }
    }
    /* restore */
    public function restore($id)
    {
        $vehicle = Vehicle::withTrashed()->findOrFail($id);
        $vehicle->restore();

        return redirect()->route('vehicles.index', ['estado' => 'activo'])
            ->with('success', 'Vehículo restaurado correctamente.');
    }
}
