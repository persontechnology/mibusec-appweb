<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolPermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'roles'=>Role::get(),
            'permisos'=>Permission::get()
        );
        return view('rol-permisos.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'name'=>'required|unique:roles,name'
        ]);
        
        $role = Role::create(['name' => $request->name]);
        return redirect()->route('rol-permisos.index')->with('success','Rol creado.!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ], [
            'permissions.*.exists' => 'Uno de los permisos seleccionados no existe.',
        ]);

        $role = Role::findOrFail($id);
        
        $permissions = $request->input('permissions', []); // array vacío si no hay checkboxes marcados

        $role->syncPermissions($permissions);

        return back()->with('success', 'Permisos actualizados correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Role::findOrFail($id);

            // 1) Evitar borrar roles protegidos
            $protected = ['Super Admin', 'Administrador']; // ajusta a tus nombres
            if (in_array($role->name, $protected, true)) {
                return back()->with('warning', 'Este rol está protegido y no puede ser eliminado.');
            }

            // 2) Verificar si hay usuarios usando este rol
            if ($role->users()->exists()) {
                return back()->with('warning', 'No se puede eliminar el rol porque está asignado a uno o más usuarios.');
            }

            // 3) (Opcional) Limpiar permisos asociados antes de borrar
            $role->syncPermissions([]);

            // 4) Eliminar
            $role->delete();

            return redirect()
                ->route('rol-permisos.index')
                ->with('success', 'Rol eliminado correctamente.');
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            return back()->with('danger', 'Ocurrió un error al eliminar el rol.');
        }
    }
}
