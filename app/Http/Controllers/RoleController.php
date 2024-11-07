<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        /*
        $this->middleware('permission:ver-rol|crear-rol|borrar-rol', ['only' => ['index']]);
        $this->middleware('permission:crear-rol', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-rol', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-rol', ['only' => ['destroy']]);  */
    }

    public function index()
    {
        $roles = Role::with('permissions')->paginate(5); // Carga ansiosa de permisos
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permission = Permission::get();
        return view('roles.crear', compact('permission'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permission' => 'required|array',
        ], [
            'name.required' => 'El nombre del rol es obligatorio. Por favor, ingrese un nombre válido.',
            'permission.required' => 'Debes seleccionar al menos un permiso para el rol.',
        ]);
    
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
       
        return redirect()->route('roles.index')
                         ->with('info', '¡El rol ha sido creado exitosamente! Ahora puedes asignar permisos a este rol.');
    }
    

    public function show($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $totalPermissions = $role->permissions->count();
        $totalPermissions = Permission::count(); // Contar todos los permisos disponibles
        $assignedPermissionsCount = $role->permissions->count(); // Contar permisos asignados al rol
        return view('roles.show', compact('role','totalPermissions','assignedPermissionsCount'));
    }
    
    public function edit($id)
{
    // Buscar el rol por ID y cargar permisos asociados
    $role = Role::with('permissions')->find($id);

    // Verificar si el rol existe
    if (!$role) {
        // Redirigir con mensaje de error si el rol no existe
        return redirect()->route('roles.index')->with('error', 'Rol no encontrado.');
    }

    // Obtener todos los permisos disponibles
    $permissions = Permission::get();

    // Obtener permisos asociados al rol
    $rolePermissions = $role->permissions->pluck('id', 'id')->all();

    // Retornar la vista con los datos del rol y permisos
    return view('roles.editar', compact('role', 'permissions', 'rolePermissions'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'required|array', // Cambiado de 'permission' a 'permissions'
        ]);
       
        $role = Role::find($id);
        $role->name = $request->input('name');
        
        // Sincroniza los permisos con el rol
        $role->syncPermissions($request->input('permissions')); // Cambiado de 'permission' a 'permissions'
        
        $role->save();
        
        return redirect()->route('roles.index')
                         ->with('update', 'Rol editado con éxito.');
    }
    

    public function destroy($id)
    {
        Role::find($id)->delete();
        
        return redirect()->route('roles.index')
                         ->with('delete', 'Roll Eliminado con éxito.');
    }
}
