<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Medidor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\CambioMedidor;
class MedidorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
       
      //  $medidores = Medidor::all();
        return view('medidores.index');
    }

    public function create()
    {
        $clientes = Cliente::get();
        return view('medidores.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_medidor' => 'required|string|max:255|unique:medidores,numero_medidor',
            'ubicacion' => 'required|string|max:255',
            'cliente_id' => 'required|exists:clientes,id',
        ]);
    
        if ($validator->fails()) {
            // Guardar los errores en la sesión para mostrar con SweetAlert
            return back()->withErrors($validator)
                         ->withInput()
                         ->with('error', 'Por favor corrige los errores en el formulario.');
        }
    
        // Crear el medidor si pasa la validación
        Medidor::create($validator->validated());
    
        return redirect()->route('medidores.index')->with('info', 'Medidor agregado exitosamente.');
    }
    

    public function show($id)
    {
        $medidor = Medidor::find($id);
    
        if (!$medidor) {
            return redirect()->route('medidores.index')->with('error', 'Medidor no encontrado.');
        }
    
        // Si el medidor está asociado a un cliente, puedes obtenerlo a través de la relación
        $cliente = $medidor->cliente;  // Asume que tienes una relación cliente en el modelo Medidor
    
        // Obtener los medidores disponibles (excluyendo el medidor actual del cliente)
        $medidoresDisponibles = Medidor::where('cliente_id', null)->orWhere('id', '!=', $medidor->id)->get();
    
        return view('medidores.show', compact('medidor', 'cliente', 'medidoresDisponibles'));
    }
    
    public function edit($id)
    {
        $medidor = Medidor::with('cliente')->find($id);
        $clientes = Cliente::with('medidores')->get();
        if (!$medidor) {
            return redirect()->route('medidores.index')->with('error', 'Medidor no encontrado.');
        }
    
        // Depura para verificar si el cliente está cargado
       // dd($medidor->cliente);
    
       
        return view('medidores.edit', compact('medidor','clientes'));
    }
    
    public function update(Request $request, $id)
{
    // Cargar el medidor desde la base de datos
    $medidor = Medidor::find($id);

    // Verificar si el medidor existe
    if (!$medidor) {
        return back()->with('error', 'El medidor no fue encontrado.');
    }

    // Validación de los datos
    $validator = Validator::make($request->all(), [
        'numero_medidor' => 'required|string|max:255',
        'ubicacion' => 'required|string|max:255',
        'cliente_id' => 'required|exists:clientes,id',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput()->with('error', 'Por favor corrige los errores.');
    }

    // Actualizar el medidor con los datos validados
    $medidor->update([
        'numero_medidor' => $request->numero_medidor,
        'ubicacion' => $request->ubicacion,
        'cliente_id' => $request->cliente_id,
    ]);
   // dd($medidor);
    return redirect()->route('medidores.index')->with('update', 'Medidor actualizado exitosamente.');
}

    

    
    public function destroy($id)
    {
        try {
            $medidor = Medidor::findOrFail($id);
            $medidor->delete();

           
        return response()->json(['delete' => 'Medidor eliminado exitosamente.']);
        } catch (\Exception $e) {
            // Registra el error en los logs
            Log::error('Error en el control de medidores: '.$e->getMessage());
            return redirect()->route('medidores.index')->with('delete', 'Error al eliminar el medidor.');
        }
    }



    
}
