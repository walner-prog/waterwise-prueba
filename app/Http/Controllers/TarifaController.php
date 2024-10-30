<?php

namespace App\Http\Controllers;

use App\Models\Tarifa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TarifaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $tarifas = Tarifa::all();
        return view('tarifas.index', compact('tarifas'));
    }

    public function create()
    {
        return view('tarifas.create');
    }

    public function store(Request $request)
    {
        // Definir las reglas de validación
        $validator = Validator::make($request->all(), [
            'tipo_tarifa' => 'required|string|max:255',
            'precio_por_m3' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'fecha_vigencia' => 'required|date',
        ]);
    
        // Verificar si hay errores en la validación
        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput()
                         ->with('error', 'Por favor corrige los errores en el formulario.');
        }
    
        // Validar que el precio por m³ no esté ya registrado
        $existingPrice = Tarifa::where('precio_por_m3', $request->precio_por_m3)->first();
        if ($existingPrice) {
            return back()->withErrors(['precio_por_m3' => 'Ya existe una tarifa con este precio por m³.'])
                         ->withInput()
                         ->with('error', 'Ya existe una tarifa con este precio por m³.');
        }
    
        // Validar que la fecha de vigencia no esté ya registrada
        $existingDate = Tarifa::where('fecha_vigencia', $request->fecha_vigencia)->first();
        if ($existingDate) {
            return back()->withErrors(['fecha_vigencia' => 'Ya existe una tarifa con esta fecha de vigencia.'])
                         ->withInput()
                         ->with('error', 'Ya existe una tarifa con esta fecha de vigencia.');
        }
    
        // Crear la nueva tarifa si las validaciones son correctas
        Tarifa::create($validator->validated());
    
        return redirect()->route('tarifas.index')->with('info', 'Tarifa agregada exitosamente.');
    }
    
    public function show($id)
    {
        $tarifa = Tarifa::find($id);

        if (!$tarifa) {
            return redirect()->route('tarifas.index')->with('error', 'Tarifa no encontrada.');
        }

        return view('tarifas.show', compact('tarifa'));
    }

    public function edit($id)
    {
        $tarifa = Tarifa::find($id);

        if (!$tarifa) {
            return redirect()->route('tarifas.index')->with('error', 'Tarifa no encontrada.');
        }

        return view('tarifas.edit', compact('tarifa'));
    }

    public function update(Request $request, Tarifa $tarifa)
    {
        $validator = Validator::make($request->all(), [
            'tipo_tarifa' => 'required|string|max:255',
            'precio_por_m3' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'fecha_vigencia' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Por favor corrige los errores.');
        }

        $tarifa->update($validator->validated());

        return redirect()->route('tarifas.index')->with('update', 'Tarifa actualizada exitosamente.');
    }

    public function destroy($id)
    {
        try {
            $tarifa = Tarifa::findOrFail($id);
            $tarifa->delete();

            return response()->json(['delete' => 'Tarifa eliminada exitosamente.']);
        } catch (\Exception $e) {
            Log::error('Error en el control de tarifas: '.$e->getMessage());
            return redirect()->route('tarifas.index')->with('delete', 'Error al eliminar la tarifa.');
        }
    }
}
