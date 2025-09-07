<?php

namespace App\Http\Controllers;

use App\DataTables\RouteDataTable;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RouteDataTable $dataTable)
    {
        return $dataTable->render('routes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $route = new Route();
        return view('routes.create', compact('route'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code'        => ['required','string','max:100','unique:routes,code'],
            'name'        => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        $route = Route::create($data);

        return redirect()
            ->route('routes.show', $route)
            ->with('success', 'Ruta creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Route $route)
    {
        return view('routes.show', compact('route'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Route $route)
    {
        return view('routes.edit', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Route $route)
    {
         $data = $request->validate([
            'code'        => ['required','string','max:100', Rule::unique('routes','code')->ignore($route->id)],
            'name'        => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        $route->update($data);

        return redirect()->route('routes.show',$route)->with('success', 'Ruta actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Route $route)
    {
        try {
            $route->delete();
            return redirect()->route('routes.index')->with('success', 'Ruta eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('routes.index')->with('error', 'No se pudo eliminar la ruta. Es posible que esté en uso.');
        }   
    }
}
