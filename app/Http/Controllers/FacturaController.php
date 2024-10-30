<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Cliente;
use App\Models\Medidor;
use App\Models\LecturaMensual;
use App\Models\Tarifa;
use App\Models\Ingreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class FacturaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $facturas = Factura::all();
        return view('facturas.index', compact('facturas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $medidores = Medidor::all();
        $lecturas = LecturaMensual::all();
        $tarifas = Tarifa::all();
        return view('facturas.create', compact('clientes', 'medidores', 'lecturas', 'tarifas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required|exists:clientes,id',
            'medidor_id' => 'required|exists:medidores,id',
            'lectura_id' => 'required|exists:lecturas_mensuales,id',
            'tarifa_id' => 'required|exists:tarifas,id',
            'fecha_factura' => 'required|date',
            'monto_total' => 'required|numeric|min:0',
            'estado_pago' => 'required|in:pendiente,pagado',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput()
                         ->with('error', 'Por favor corrige los errores en el formulario.');
        }

        // Verificar si ya existe una factura con el mismo precio y fecha
        $existingFactura = Factura::where('medidor_id', $request->medidor_id)
                                  ->where('fecha_factura', $request->fecha_factura)
                                  ->first();
        if ($existingFactura) {
            return back()->withErrors(['fecha_factura' => 'Ya existe una factura para esta fecha.'])
                         ->withInput()
                         ->with('error', 'Ya existe una factura para esta fecha.');
        }

        Factura::create($validator->validated());

        return redirect()->route('facturas.index')->with('info', 'Factura agregada exitosamente.');
    }

    // En tu método show
public function show($id)
{
    // Cargamos la factura con las relaciones necesarias
    $factura = Factura::with(['cliente', 'lectura.medidor', 'tarifa'])->find($id);

    if (!$factura) {
        return redirect()->route('facturas.index')->with('error', 'Factura no encontrada.');
    }

    return view('facturas.show', compact('factura'));
}


    public function edit($id)
    {
        $factura = Factura::find($id);
        if (!$factura) {
            return redirect()->route('facturas.index')->with('error', 'Factura no encontrada.');
        }

        $clientes = Cliente::all();
        $medidores = Medidor::all();
        $lecturas = LecturaMensual::all();
        $tarifas = Tarifa::all();
        return view('facturas.edit', compact('factura', 'clientes', 'medidores', 'lecturas', 'tarifas'));
    }

    public function update(Request $request, Factura $factura)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required|exists:clientes,id',
            'medidor_id' => 'required|exists:medidores,id',
            'lectura_id' => 'required|exists:lecturas_mensuales,id',
            'tarifa_id' => 'required|exists:tarifas,id',
            'fecha_factura' => 'required|date',
            'monto_total' => 'required|numeric|min:0',
            'estado_pago' => 'required|in:pendiente,pagado',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput()
                         ->with('error', 'Por favor corrige los errores en el formulario.');
        }

        // Verificar si ya existe una factura con el mismo precio y fecha
        $existingFactura = Factura::where('medidor_id', $request->medidor_id)
                                  ->where('fecha_factura', $request->fecha_factura)
                                  ->where('id', '!=', $factura->id)
                                  ->first();
        if ($existingFactura) {
            return back()->withErrors(['fecha_factura' => 'Ya existe una factura para esta fecha.'])
                         ->withInput()
                         ->with('error', 'Ya existe una factura para esta fecha.');
        }

        $factura->update($validator->validated());

        return redirect()->route('facturas.index')->with('info', 'Factura actualizada exitosamente.');
    }
    public function destroy($id)
    {
        try {
            $factura = Factura::findOrFail($id);
            $factura->delete(); 
            // Esto eliminará la factura y sus ingresos asociados en cascada
            return response()->json(['delete' => 'Factura e ingresos asociados eliminados exitosamente.']);
        } catch (\Exception $e) {
            Log::error('Error en el control de facturas: '.$e->getMessage());
           
            return redirect()->route('facturas.index')->with('delete', 'Factura e ingresos asociados eliminados exitosamente.');
        }
    }
    
   
  
   

    //  ************************** proceso de pago de facturas y regitro de factura en ingresos ********** //
    //   ************************   //////////////////////////////////////////////////////////// **********//

     //Verificación de Facturas Pendientes
     
     public function facturasPendientes($clienteId)
     {
         // Obtener las facturas pendientes del cliente con relaciones
         $facturasPendientes = Factura::where('cliente_id', $clienteId)
                                      ->where('estado_pago', 'pendiente')
                                      ->with(['medidor', 'tarifa', 'lectura'])
                                      ->get();
     
         // Inicializar las variables para las lecturas
         $lecturaAnterior = null;
         $lecturaActual = null;
         $totalMonto = 0;
     
         foreach ($facturasPendientes as $factura) {
             if ($factura->lectura) {
                 $lecturaAnterior = $lecturaAnterior === null ? $factura->lectura->lectura_anterior : min($lecturaAnterior, $factura->lectura->lectura_anterior);
                 $lecturaActual = $lecturaActual === null ? $factura->lectura->lectura_actual : max($lecturaActual, $factura->lectura->lectura_actual);
             }
        
             $totalMonto += $factura->monto_total;
            }
        
            return view('facturas.pendientes', compact('facturasPendientes', 'lecturaAnterior', 'lecturaActual', 'totalMonto'));
     }
     

     public function calcularMontoTotal($facturaIds)
     {
         $facturas = Factura::whereIn('id', $facturaIds)->get();
         $montoTotal = 0;

         // Verifica si $facturaIds es un array
         if (!is_array($facturaIds)) {
           throw new \InvalidArgumentException('Se esperaba un array de IDs de factura.');
          }
     
         foreach ($facturas as $factura) {
             // Suma el monto de cada factura
             $montoTotal += $factura->monto_total;
             
             // Ejemplo: Añadir interés por mora si es necesario
             if ($factura->fecha_factura < now()->subDays(30)) {
                 $montoTotal += $factura->monto_total * 0.05; // 5% de interés
             }
         }
     
         return $montoTotal;
     }
     
     
     public function confirmarPago(Request $request)
     {
         $request->validate([
             'metodo_pago' => '',
             'factura_ids' => 'required|array',
         ]);
     
         // Obtener los IDs de las facturas
         $facturaIds = $request->input('factura_ids');
     
         // Convertir los valores de factura_ids a enteros
         $facturaIdsInt = array_map('intval', $facturaIds);
     
         
     
         // Calcular el monto total utilizando los IDs convertidos
         $montoTotal = $this->calcularMontoTotal($facturaIdsInt);
         $metodoPago = $request->input('metodo_pago');
     
         // Mostrar la página de confirmación de pago
         return view('pagos.confirmacion', compact('facturaIds', 'montoTotal', 'metodoPago'));
     }
     
     

     public function procesarPago(Request $request)
     {
         $facturaIds = $request->input('factura_ids');
         $metodoPago = $request->input('metodo_pago');
         $montoTotal = 0;
         $facturasDetalles = [];
     
         foreach ($facturaIds as $facturaId) {
             $factura = Factura::find($facturaId);
             if ($factura && $factura->estado_pago == 'pendiente') {
                 // Actualizar estado de la factura a "pagado"
                 $factura->estado_pago = 'pagado';
                 $factura->fecha_pago = now();
                 $factura->save();
     
                 // Registrar ingreso
                 Ingreso::create([
                     'factura_id' => $factura->id,
                     'monto' => $factura->monto_total,
                     'fecha' => now(),
                     'metodo_pago' => $metodoPago,
                     'descripcion' => 'Facturacion',
                 ]);
     
                 // Acumular monto total y detalles
                 $montoTotal += $factura->monto_total;
                 $facturasDetalles[] = [
                     'numero_factura' => $factura->id,
                     'fecha_factura' => $factura->fecha_factura,
                     'monto_total' => $factura->monto_total,
                 ];
             }
         }
     
         
     
         return redirect()->route('pagos.recibo', ['factura_ids' => $facturaIds])
                          ->with('success', 'Pago procesado exitosamente.');
     }

     public function pagos(Request $request)
     {
         $facturaIds = $request->input('factura_ids', []);
         
         // Obtener las facturas y convertir la fecha a un objeto Carbon
         $facturasPendientes = Factura::whereIn('id', $facturaIds)->get();
         foreach ($facturasPendientes as $factura) {
             $factura->fecha_factura = Carbon::parse($factura->fecha_factura);
         }
     
         return view('pagos.recibo', compact('facturasPendientes', 'facturaIds'))
                ->with('success', 'Pago procesado exitosamente.');
     }
     
     public function generarRecibo($facturaIds)
     {
         // Convierte el parámetro de string a array
         $facturaIdsArray = explode(',', $facturaIds);
     
         // Obtener detalles de las facturas
         $facturasDetalles = [];
         $totalPagado = 0;
         $cliente = null;
     
         foreach ($facturaIdsArray as $facturaId) {
             // Carga la lectura relacionada
             $factura = Factura::with('lectura','medidor')->find($facturaId);
             
             if ($factura) {
                 $totalPagado += $factura->monto_total;
                 $facturasDetalles[] = [
                     'numero_factura' => $factura->id,
                     'fecha_factura' => \Carbon\Carbon::parse($factura->fecha_factura), // Convertir a Carbon
                     'mes_leido' => $factura->lectura->mes_leido ?? 'N/A', // Accede a mes_leido
                     
                     'lectura_anterior' => $factura->lectura->lectura_anterior,
                     'lectura_actual' => $factura->lectura->lectura_actual,
                     'consumo' => $factura->lectura->lectura_actual - $factura->lectura->lectura_anterior,
                     'monto_total' => $factura->monto_total,
                 ];
                 // Obtener información del cliente
                 
                 $cliente = $factura->cliente; 
             }
         }
     
         // Datos para la vista
         $data = [
             'cliente' => $cliente,
             'facturasDetalles' => $facturasDetalles,
             'totalPagado' => $totalPagado,
             'fecha_pago' => now()->format('Y-m-d'), // Fecha del pago
             'metodo_pago' => request()->input('metodo_pago'), // Método de pago
         ];
     
         // Generar el PDF
         $pdf = PDF::loadView('recibos.recibo', $data);
     
         // Retornar el PDF como vista en el navegador
         return $pdf->stream('recibo_pago.pdf');
     }
     
     
     

//Actualización del Historial de Pagos
   
public function actualizarHistorialPagos($clienteId) 
{
    // Obtener el historial de pagos del cliente
    $historialPagos = Ingreso::whereHas('factura', function ($query) use ($clienteId) {
        $query->where('cliente_id', $clienteId);
    })->with('factura')->get()->map(function($ingreso) {
        // Formatear fechas si es necesario
        $ingreso->fecha = \Carbon\Carbon::parse($ingreso->fecha)->format('d/m/Y');
        return $ingreso;
    });

    return $historialPagos;
}
public function mostrarHistorialPagos($clienteId)
{
    return view('clientes.historial-pagos', compact('clienteId'));
}

  


public function generarFacturaMensual($clienteId, $lecturaActual)
{
    // Obtener el medidor asociado al cliente
    $medidor = Medidor::where('cliente_id', $clienteId)->first();

    if (!$medidor) {
        throw new \Exception("No se encontró un medidor asociado al cliente.");
    }

    // Obtener la última lectura para el medidor (la lectura recién creada)
    $ultimaLectura = LecturaMensual::where('medidor_id', $medidor->id)
        ->orderBy('fecha_lectura', 'desc')
        ->first();

    if (!$ultimaLectura) {
        throw new \Exception("No se encontró una lectura reciente para este medidor.");
    }

    // Obtener el consumo de la última lectura
    $consumo = $ultimaLectura->consumo;

    if ($consumo <= 0) {
        throw new \Exception("El consumo calculado es 0 o negativo.");
    }

    // Obtener la tarifa vigente
    $tarifa = Tarifa::where('fecha_vigencia', '<=', now())
        ->orderBy('fecha_vigencia', 'desc')
        ->first();

    if (!$tarifa) {
        throw new \Exception("No se encontró una tarifa vigente.");
    }

    if ($tarifa->precio_por_m3 <= 0) {
        throw new \Exception("La tarifa tiene un precio por m³ de 0 o negativo.");
    }

    // Calcular el monto total
    $montoTotal = $consumo * $tarifa->precio_por_m3;

    // Crear la factura
    Factura::create([
        'cliente_id' => $clienteId,
        'medidor_id' => $medidor->id,
        'lectura_id' => $ultimaLectura->id, // Utilizar la última lectura recién creada
        'tarifa_id' => $tarifa->id,
        'fecha_factura' => now(),
        'monto_total' => $montoTotal,
        'estado_pago' => 'pendiente',
    ]);
}

}
