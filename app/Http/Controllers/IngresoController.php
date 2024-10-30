<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class IngresoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ingresos = Ingreso::all();
        return view('ingresos.index', compact('ingresos'));
    }

    public function create()
    {
        $facturas = Factura::where('estado_pago', 'pagado')->get(); // Obtener facturas pagadas para asociarlas con el ingreso
        return view('ingresos.create', compact('facturas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            // No incluyas 'factura_id' aquí
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Por favor corrige los errores.');
        }
    
        // Lógica para obtener la factura_id
        // Por ejemplo, si tienes un cliente_id en el request, puedes buscar la factura más reciente asociada con ese cliente
        $cliente_id = $request->input('cliente_id'); // Asumiendo que estás pasando el cliente_id desde el formulario
    
        // Aquí recuperas la factura más reciente del cliente
        $factura = Factura::where('cliente_id', $cliente_id)
            ->orderBy('fecha_factura', 'desc') // Asumiendo que deseas la más reciente
            ->first();
    
        if (!$factura) {
            return back()->withErrors(['factura' => 'No se encontró una factura para el cliente especificado.'])->withInput();
        }
    
        // Obtener el factura_id de la factura recuperada
        $factura_id = $factura->id;
    
        // Crear el ingreso incluyendo el factura_id
        Ingreso::create(array_merge($validator->validated(), ['factura_id' => $factura_id]));
    
        return redirect()->route('ingresos.index')->with('info', 'Ingreso registrado exitosamente.');
    }
    

    public function show($id)
    {
        // Busca el ingreso por ID, si no se encuentra se lanza un 404
        $ingreso = Ingreso::with(['factura.lectura', 'venta.productos'])->findOrFail($id);
    
        return view('ingresos.show', compact('ingreso'));
    }
    

    public function edit($id)
    {
        $ingreso = Ingreso::find($id);
        if (!$ingreso) {
            return redirect()->route('ingresos.index')->with('error', 'Ingreso no encontrado.');
        }
        return view('ingresos.edit', compact('ingreso'));
    }

    public function update(Request $request, Ingreso $ingreso)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'factura_id' => 'required|exists:facturas,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Por favor corrige los errores.');
        }

        $ingreso->update($validator->validated());

        return redirect()->route('ingresos.index')->with('update', 'Ingreso actualizado exitosamente.');
    }

    public function destroy($id)
    {
        try {
            $ingreso = Ingreso::findOrFail($id);
            $ingreso->delete();

            return response()->json(['delete' => 'Ingreso eliminado exitosamente.']);
        } catch (\Exception $e) {
            Log::error('Error en el controlador de Ingresos: '.$e->getMessage());
            return redirect()->route('ingresos.index')->with('delete', 'Error al eliminar el ingreso.');
        }
    }
}
