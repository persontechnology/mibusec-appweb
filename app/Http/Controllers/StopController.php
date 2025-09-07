<?php

namespace App\Http\Controllers;

use App\DataTables\StopDataTable;
use App\Models\Stop;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StopDataTable $dataTable)
    {

        return $dataTable->render('stops.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stop = new Stop();
        return view('stops.create', compact('stop'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code'        => ['required','string','max:100','unique:stops,code'],
            'name'        => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'address'     => ['nullable','string','max:255'],
            'status'      => ['nullable', Rule::in(['ACTIVE','ANACTIVE'])],
            'notes'       => ['nullable','string'],
            'latitude'    => ['required','numeric','between:-90,90'],
            'longitude'   => ['required','numeric','between:-180,180'],
        ]);

        $stop = Stop::create($data);

        return redirect()
            ->route('stops.show', $stop)
            ->with('success', 'Parada creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stop $stop)
    {
        return view('stops.show', compact('stop'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stop $stop)
    {
        return view('stops.edit', compact('stop'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stop $stop)
    {
        $data = $request->validate([
            'code'        => ['required','string','max:100', Rule::unique('stops','code')->ignore($stop->id)],
            'name'        => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'address'     => ['nullable','string','max:255'],
            'status'      => ['nullable', Rule::in(['ACTIVE','ANACTIVE'])],
            'notes'       => ['nullable','string'],
            'latitude'    => ['required','numeric','between:-90,90'],
            'longitude'   => ['required','numeric','between:-180,180'],
        ]);

        $stop->update($data);

        return redirect()->route('stops.show',$stop)->with('success', 'Parada actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stop $stop)
    {
        try {
            $stop->delete();
            return redirect()->route('stops.index')->with('success', 'Parada eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('stops.index')->with('error', 'Error al eliminar la parada: ' . $e->getMessage());
        }
    }
}
