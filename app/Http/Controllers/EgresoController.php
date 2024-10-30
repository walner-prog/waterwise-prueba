<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
class EgresoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $egresos = Egreso::all();
        $empleados = Empleado::get();
        return view('egresos.index', compact('egresos','empleados'));
    }

    public function create()
    {
        $empleados = Empleado::all();
        return view('egresos.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'pagado_a' => 'required',
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'required|string|max:255',
            'empleado_id' => 'required|exists:empleados,id',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput()
                         ->with('error', 'Por favor corrige los errores en el formulario.');
        }
    
        // Crear el egreso
        $egreso = Egreso::create($validator->validated());
    
        // Redirigir al índice de egresos con la notificación
        return redirect()->route('egresos.index')->with('info', 'Egreso registrado exitosamente.')->with('egreso_id', $egreso->id);
    }
    
    public function show($id)
    {
        $egreso = Egreso::find($id);
        if (!$egreso) {
            return redirect()->route('egresos.index')->with('error', 'Egreso no encontrado.');
        }

        return view('egresos.show', compact('egreso'));
    }

    public function edit($id)
    {
        $egreso = Egreso::find($id);
        $empleados = Empleado::all();
        if (!$egreso) {
            return redirect()->route('egresos.index')->with('error', 'Egreso no encontrado.');
        }

        return view('egresos.edit', compact('egreso', 'empleados'));
    }

    public function update(Request $request, Egreso $egreso)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'required|string|max:255',
            'empleado_id' => 'required|exists:empleados,id',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Por favor corrige los errores.');
        }
    
        // Actualizar el egreso
        $egreso->update($validator->validated());
    
        // Redirigir al índice de egresos con la notificación
        return redirect()->route('egresos.index')->with('update', 'Egreso actualizado exitosamente.')->with('egreso_id', $egreso->id);
    }
    

    public function destroy($id)
    {
        try {
            $egreso = Egreso::findOrFail($id);
            $egreso->delete();

            return response()->json(['delete' => 'Egreso eliminado exitosamente.']);
        } catch (\Exception $e) {
            Log::error('Error en el control de egresos: ' . $e->getMessage());
            return redirect()->route('egresos.index')->with('delete', 'Error al eliminar el egreso.');
        }
    }

    public function recibo($id)
{
    // Encuentra el egreso por ID y carga la relación con el empleado
    $egreso = Egreso::with('empleado')->findOrFail($id);

    // Carga los datos necesarios para el PDF
    $data = [
        'id' => $egreso->id,
        'fecha' => \Carbon\Carbon::parse($egreso->fecha)->format('d/m/Y'),
        'pagado_a' => $egreso->pagado_a,
        'monto' => $egreso->monto,
        'descripcion' => $egreso->descripcion,
        'empleado_nombre' => $egreso->empleado->nombre . ' ' . $egreso->empleado->apellido,
    ];

    // Cargar la vista para el PDF
    $pdf = PDF::loadView('egresos.recibo', $data);

    // Retornar el PDF para visualizar en el navegador
    return $pdf->stream('egreso_' . $egreso->id . '.pdf');
}

}
