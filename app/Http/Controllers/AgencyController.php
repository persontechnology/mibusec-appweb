<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->input('q');
        $trashed = $request->input('trashed'); // Puede ser '', '1', o 'all'

        $query = Agency::query();

        // Filtro de búsqueda
        if ($q) {
            $qLower = mb_strtolower($q);
            $query->where(function ($w) use ($qLower) {
                $w->whereRaw('LOWER(name) LIKE ?', ["%{$qLower}%"])
                    ->orWhereRaw('LOWER(email) LIKE ?', ["%{$qLower}%"])
                    ->orWhereRaw('LOWER(phone) LIKE ?', ["%{$qLower}%"]);
            });
        }

        // Filtro de estado (activas, eliminadas, todas)
        if ($trashed === '1') {
            $query->onlyTrashed();
        } elseif ($trashed === 'all') {
            $query->withTrashed();
        }
        // Si es '', no se hace nada (solo activas)

        $agencies = $query->latest()->paginate(12)->withQueryString();

        return view('agencies.index', [
            'agencies' => $agencies,
            'q' => $q,
            'showTrashed' => $trashed,
        ]);
    }

    /* Create a new agency  */
    public function create()
    {
        return view('agencies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^0\d{9}$/'
            ],
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Guardar la imagen con un nombre único usando UUID para evitar conflictos
            $filename = 'agencies/' . Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
            Storage::disk('public')->put($filename, file_get_contents($request->file('image')));
            $data['image'] = $filename;
        }

        $agency = Agency::create($data);

        return redirect()->route('agencies.show', $agency)->with('success', 'Agencia creada.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Agency $agency)
    {
        return view('agencies.show', compact('agency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agency $agency)
    {
        return view('agencies.edit', compact('agency'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agency $agency)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        if ($request->boolean('remove_image') && $agency->image) {
            Storage::disk('public')->delete($agency->image);
            $data['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($agency->image) {
                Storage::disk('public')->delete($agency->image);
            }
            $data['image'] = $request->file('image')->store('agencies', 'public');
        } else {
            unset($data['image']);
        }

        $agency->update($data);

        return redirect()->route('agencies.show', $agency)->with('success', 'Agencia actualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agency $agency)
    {
        try {
            $agency->delete();
            return redirect()->route('agencies.index')->with('success', 'Agencia enviada a la papelera.');
        } catch (\Exception $e) {
            return redirect()->route('agencies.index')->with('danger', 'Error al eliminar la agencia: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        $agency = Agency::withTrashed()->findOrFail($id);
        $agency->restore();
        return redirect()->route('agencies.index')->with('success', 'Agencia restaurada.');
    }
    public function forceDelete($id)
    {
        $agency = Agency::withTrashed()->findOrFail($id);
        if ($agency->image) {
            Storage::disk('public')->delete($agency->image);
        }
        $agency->forceDelete();
        return redirect()->route('agencies.index')->with('success', 'Agencia eliminada permanentemente.');
    }
}
