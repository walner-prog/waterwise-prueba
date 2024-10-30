<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\User; // Asegúrate de importar el modelo User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class EmpleadoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $empleados = Empleado::with('usuario')->get(); // Obtiene todos los empleados con sus usuarios
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        $usuarios = User::all(); // Obtener todos los usuarios para seleccionar
        return view('empleados.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'puesto' => 'required|string|max:255',
        ]);
    
        // Verificar si el usuario ya es un empleado
        $usuarioId = $request->usuario_id;
        $empleadoExistente = Empleado::where('usuario_id', $usuarioId)->first();
    
        if ($empleadoExistente) {
            return redirect()->back()->withInput()->with('error', 'El usuario ya está registrado como empleado.');
        }

          // Crear nuevo empleado
           Empleado::create([
          'usuario_id' => $usuarioId,
          'nombre' => $request->nombre,
           'apellido' => $request->apellido,
           'puesto' => $request->puesto,
        ]);

        return redirect()->route('empleados.index')->with('info', 'Empleado agregado exitosamente.');
    }

    public function check($id)
{
    $empleado = Empleado::where('usuario_id', $id)->exists();
    return response()->json(['exists' => $empleado]);
}


    public function show($id)
    {
        $empleado = Empleado::with('usuario')->find($id);

        if (!$empleado) {
            return redirect()->route('empleados.index')->with('error', 'Empleado no encontrado.');
        }

        return view('empleados.show', compact('empleado'));
    }

    public function edit($id)
    {
        $empleado = Empleado::find($id);
        $usuarios = User::all(); // Obtener todos los usuarios para seleccionar

        if (!$empleado) {
            return redirect()->route('empleados.index')->with('error', 'Empleado no encontrado.');
        }

        return view('empleados.edit', compact('empleado', 'usuarios'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'puesto' => 'required|string|max:255',
            'usuario_id' => 'required|exists:users,id', // Validar que el usuario exista
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Por favor corrige los errores.');
        }

        $empleado->update($validator->validated());

        return redirect()->route('empleados.index')->with('update', 'Empleado actualizado exitosamente.');
    }

    public function destroy($id)
    {
        try {
            $empleado = Empleado::findOrFail($id);
            $empleado->delete();

            return response()->json(['delete' => 'Empleado eliminado exitosamente.']);
        } catch (\Exception $e) {
            Log::error('Error en el control de empleados: '.$e->getMessage());
            return redirect()->route('empleados.index')->with('delete', 'Error al eliminar el empleado.');
        }
    }
}
