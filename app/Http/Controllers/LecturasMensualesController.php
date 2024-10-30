<?php

namespace App\Http\Controllers;


use App\Models\Medidor;
use App\Models\Cliente;
use App\Models\Factura;
use App\Models\Tarifa;
use App\Models\LecturaMensual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
class LecturasMensualesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $lecturas = LecturaMensual::with('medidor.cliente')->get();
        return view('lecturas_mensuales.index', compact('lecturas'));
    }

    public function create()
    {
       
        $medidores = Medidor::with('cliente')->get();
        $ultimaLectura = null;
    
        // Si se ha enviado un medidor_id en la solicitud, obtener la última lectura para ese medidor
        if (request()->has('medidor_id')) {
            $ultimaLectura = LecturaMensual::where('medidor_id', request('medidor_id'))
                ->orderBy('fecha_lectura', 'desc')
                ->first();
        }
        return view('lecturas_mensuales.create', compact('medidores','ultimaLectura'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'medidor_id' => 'required|exists:medidores,id',
            'cliente_id' => 'required|exists:clientes,id',
           // 'lectura_anterior' => 'required|numeric',
            'lectura_actual' => 'required|numeric|gte:lectura_anterior', // Validación: lectura_actual >= lectura_anterior
            'fecha_lectura' => 'required|date',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'mes_leido' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput()
                         ->with('error', 'Corrige los errores del formulario.');
        }
    
        $medidor = Medidor::find($request->medidor_id);
    
        if (!$medidor || !$medidor->cliente) {
            return back()->with('error', 'El medidor no está asociado a ningún cliente válido.');
        }
    
        // Obtener la última lectura registrada para ese medidor y cliente
        $ultimaLectura = LecturaMensual::where('medidor_id', $request->medidor_id)
            ->orderBy('fecha_lectura', 'desc')
            ->first();
    
        // Si existe una lectura anterior, la lectura_actual pasa a ser la lectura_anterior
        if ($ultimaLectura) {
            $request->merge(['lectura_anterior' => $ultimaLectura->lectura_actual]);
    
            // Obtener mes y año de la última lectura
            $ultimoMes = date('m', strtotime($ultimaLectura->fecha_lectura));
            $ultimoAnio = date('Y', strtotime($ultimaLectura->fecha_lectura));
    
            // Obtener el mes y año de la lectura que se intenta registrar
            $mesSeleccionado = date('m', strtotime($request->fecha_lectura));
            $anioSeleccionado = date('Y', strtotime($request->fecha_lectura));
    
            // Verificar que el año de la nueva lectura no sea menor al de la última lectura
            if ($anioSeleccionado < $ultimoAnio) {
                return back()->with('error', 'El año de la lectura seleccionada no es válido. Debe ser igual o posterior al último año registrado.');
            }
    
            // Calcular la diferencia en meses entre la última lectura y la nueva lectura
            $diffInMonths = (($anioSeleccionado - $ultimoAnio) * 12) + ($mesSeleccionado - $ultimoMes);
    
            if ($diffInMonths > 1) {
                return back()->with('error', 'Faltan lecturas por registrar entre la última fecha registrada y la nueva.');
            }
    
            // Verificar la secuencia de meses
            if ($anioSeleccionado == $ultimoAnio) {
                // Si es el mismo año, el mes debe ser el siguiente
                if ($mesSeleccionado != ($ultimoMes + 1)) {
                    return back()->with('error', 'Debes registrar la lectura del mes siguiente al último registrado.');
                }
            } elseif ($anioSeleccionado == $ultimoAnio + 1) {
                // Si es el siguiente año, el mes debe ser enero (1)
                if ($mesSeleccionado != 1) {
                    return back()->with('error', 'Debes registrar la lectura de enero del siguiente año.');
                }
            } else {
                return back()->with('error', 'El año de la lectura seleccionada es inválido.');
            }
        }
    
        // Calcular el consumo
        $consumo = $request->lectura_actual - $request->lectura_anterior;
    
        // Crear la nueva lectura
      $lectura =  LecturaMensual::create([
            'medidor_id' => $request->medidor_id,
            'cliente_id' => $request->cliente_id,
            'lectura_anterior' => $request->lectura_anterior,
            'lectura_actual' => $request->lectura_actual,
            'consumo' => $consumo,
            'fecha_lectura' => $request->fecha_lectura,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'mes_leido' => $request->mes_leido,
        ]);
    
         // Generar factura automáticamente
         $facturaController = new FacturaController();
         $facturaController->generarFacturaMensual($lectura->medidor->cliente_id, $lectura->lectura_actual);
    
       // return redirect()->route('lecturas_mensuales.index')->with('info', 'Lectura mensual registrada exitosamente.');
         // Redirigir al índice de egresos con la notificación
         return redirect()->route('lecturas_mensuales.index')->with('info', 'Lectura mensual registrada exitosamente.')->with('lectura_id', $lectura->id);
    }
    
    
    
    public function getUltimaLectura($medidor_id)
{
    $ultimaLectura = LecturaMensual::where('medidor_id', $medidor_id)
        ->orderBy('fecha_lectura', 'desc')
        ->first();

    return response()->json([
        'lectura_anterior' => $ultimaLectura ? $ultimaLectura->lectura_actual : 0,
    ]);
}

public function getMesActual()
{
    return response()->json([
        'mes_leido' => now()->format('F Y'), // Mes y año actuales (por ejemplo: "September 2024")
    ]);
}

public function show($id)
{
    $lectura = LecturaMensual::with('medidor.cliente')->find($id);
    if (!$lectura) {
        return redirect()->route('lecturas.index')->with('error', 'Lectura no encontrada.');
    }
    return view('lecturas_mensuales.show', compact('lectura'));
}


public function edit($id)
{
    $lectura = LecturaMensual::with('medidor.cliente')->findOrFail($id);
    
    $medidores = Medidor::with('cliente')->get();
    // Asegúrate de que el cliente esté cargado
    $cliente = $lectura->medidor->cliente;

    return view('lecturas_mensuales.edit', compact('lectura', 'cliente','medidores'));
}
public function update(Request $request, $id)
{
    // Buscar la lectura que se desea actualizar
    $lectura = LecturaMensual::findOrFail($id);

    // Validación de los datos
    $validator = Validator::make($request->all(), [
        'medidor_id' => 'required|exists:medidores,id',
        'lectura_anterior' => 'required|numeric',
        'lectura_actual' => 'required|numeric|gte:lectura_anterior',
        'fecha_lectura' => 'required|date',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'mes_leido' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)
                     ->withInput()
                     ->with('error', 'Corrige los errores del formulario.');
    }

    // Validar que el medidor tenga un cliente asociado
    $medidor = Medidor::find($request->medidor_id);
    
    if (!$medidor || !$medidor->cliente) {
        return back()->with('error', 'El medidor no está asociado a ningún cliente válido.');
    }

    // Obtener la factura asociada a la lectura
    $factura = Factura::where('lectura_id', $lectura->id)->first();

    if (!$factura) {
        throw new \Exception("No se encontró una factura asociada a esta lectura.");
    }

    // Verificar si la factura ya está pagada
    if ($factura->estado_pago === 'pagado') {
        // Notificar al administrador que la factura ya está pagada
        return back()->with('error', 'No puedes modificar esta lectura ya que la factura asociada ya ha sido pagada por el cliente.');
    }

    // Si la factura no está pagada, actualizar la lectura
    // Obtener la última lectura registrada para ese medidor
    $ultimaLectura = LecturaMensual::where('medidor_id', $request->medidor_id)
        ->where('id', '!=', $lectura->id) // Excluir la lectura que se está actualizando
        ->orderBy('fecha_lectura', 'desc')
        ->first();

      // Si existe una lectura anterior, la lectura_actual pasa a ser la lectura_anterior
      if ($ultimaLectura) {
        $request->merge(['lectura_anterior' => $ultimaLectura->lectura_actual]);

        // Obtener mes y año de la última lectura
        $ultimoMes = date('m', strtotime($ultimaLectura->fecha_lectura));
        $ultimoAnio = date('Y', strtotime($ultimaLectura->fecha_lectura));

        // Obtener el mes y año de la lectura que se intenta registrar
        $mesSeleccionado = date('m', strtotime($request->fecha_lectura));
        $anioSeleccionado = date('Y', strtotime($request->fecha_lectura));

        // Verificar que el año de la nueva lectura no sea menor al de la última lectura
        if ($anioSeleccionado < $ultimoAnio) {
            return back()->with('error', 'El año de la lectura seleccionada no es válido. Debe ser igual o posterior al último año registrado.');
        }

        // Calcular la diferencia en meses entre la última lectura y la nueva lectura
        $diffInMonths = (($anioSeleccionado - $ultimoAnio) * 12) + ($mesSeleccionado - $ultimoMes);

        if ($diffInMonths > 1) {
            return back()->with('error', 'Faltan lecturas por registrar entre la última fecha registrada y la nueva.');
        }

        // Verificar la secuencia de meses
        if ($anioSeleccionado == $ultimoAnio) {
            // Si es el mismo año, el mes debe ser el siguiente
            if ($mesSeleccionado != ($ultimoMes + 1)) {
                return back()->with('error', 'Debes registrar la lectura del mes siguiente al último registrado.');
            }
        } elseif ($anioSeleccionado == $ultimoAnio + 1) {
            // Si es el siguiente año, el mes debe ser enero (1)
            if ($mesSeleccionado != 1) {
                return back()->with('error', 'Debes registrar la lectura de enero del siguiente año.');
            }
        } else {
            return back()->with('error', 'El año de la lectura seleccionada es inválido.');
        }
    }


    // Calcular el consumo
    $consumo = $request->lectura_actual - $request->lectura_anterior;

    // Actualizar la lectura
    $lectura->update([
        'medidor_id' => $request->medidor_id,
        'cliente_id' => $medidor->cliente->id,
        'lectura_anterior' => $request->lectura_anterior,
        'lectura_actual' => $request->lectura_actual,
        'consumo' => $consumo,
        'fecha_lectura' => $request->fecha_lectura,
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin' => $request->fecha_fin,
        'mes_leido' => $request->mes_leido,
    ]);

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

    // Calcular el nuevo monto total
    $montoTotal = $consumo * $tarifa->precio_por_m3;

    // Actualizar los datos de la factura si aún no está pagada
    $factura->monto_total = $montoTotal;
    $factura->fecha_factura = now(); // Si necesitas actualizar la fecha
    $factura->save();


    return redirect()->route('lecturas_mensuales.index')->with('update', 'Lectura mensual actualizada exitosamente.')->with('lectura_id', $lectura->id);
}


   
    public function destroy($id)
    {
        try {
            $lectura = LecturaMensual::findOrFail($id);
            $lectura->delete();

           
        return response()->json(['delete' => 'Lectura eliminada exitosamente.']);
        } catch (\Exception $e) {
            // Registra el error en los logs
            Log::error('Error en el control de lecturas: '.$e->getMessage());
            return redirect()->route('lecturas_mensuales.index')->with('delete', 'Error al eliminar la lectura.');
        }
    }
    public function voucher($id)
    {
        // Obtén la lectura mensual junto con los datos del cliente y medidor
        $lectura = LecturaMensual::with(['medidor.cliente'])->findOrFail($id);
        
        // Obtén la tarifa activa (suponiendo que la tarifa actual es la última registrada)
        $tarifa = Tarifa::latest('fecha_vigencia')->first(); // O ajusta según tu lógica de tarifas
    
        // Si no se encuentra ninguna tarifa, puedes manejarlo con una excepción o lógica alternativa
        if (!$tarifa) {
            return response()->json(['error' => 'No hay una tarifa activa disponible.'], 404);
        }
    
        $data = [
            'id' => $lectura->id,
            'medidor_id' => $lectura->medidor_id,
            'lectura_anterior' => $lectura->lectura_anterior,
            'lectura_actual' => $lectura->lectura_actual,
            'fecha_lectura' => $lectura->fecha_lectura,
            'consumo' => $lectura->consumo,
            'fecha_inicio' => $lectura->fecha_inicio,
            'fecha_fin' => $lectura->fecha_fin,
            'mes_leido' => $lectura->mes_leido,
            'cliente_nombre' => $lectura->medidor->cliente->primer_nombre . ' ' . $lectura->medidor->cliente->segundo_nombre . ' ' . $lectura->medidor->cliente->primer_apellido . ' ' . $lectura->medidor->cliente->segundo_apellido,
            'numero_medidor' => $lectura->medidor->numero_medidor,
            // Agregar los datos de la tarifa
            'tarifa_tipo' => $tarifa->tipo_tarifa,
            'tarifa_precio' => $tarifa->precio_por_m3,
            'tarifa_descripcion' => $tarifa->descripcion,
            'tarifa_fecha_vigencia' => $tarifa->fecha_vigencia,
            'precio_por_m3' => $tarifa->precio_por_m3,
        ];
        
        // Cargar la vista para el PDF
        $pdf = PDF::loadView('lecturas_mensuales.voucher', $data);
        
        // Retornar el PDF para visualizar en el navegador
        return $pdf->stream('lectura_' . $lectura->id . '.lecturas_mensuales');
    }

    public function ultimaLectura(Request $request)
{
    $ultimaLectura = LecturaMensual::where('medidor_id', $request->medidor_id)
        ->orderBy('fecha_lectura', 'desc')
        ->first();

    return response()->json($ultimaLectura);
}
public function obtenerMesUltimaLectura(Request $request)
{
    $medidorId = $request->medidor_id;
    if (!$medidorId) {
        return response()->json(['error' => 'medidor_id no proporcionado'], 400);
    }

    // Buscar la última lectura del medidor
    $ultimaLectura = LecturaMensual::where('medidor_id', $medidorId)
        ->orderBy('fecha_lectura', 'desc')
        ->first();
    
    if ($ultimaLectura) {
        // Obtener el mes desde `mes_leido` y el año desde `fecha_lectura`
        $mesUltimaLectura = $ultimaLectura->mes_leido;
        $anioUltimaLectura = \Carbon\Carbon::parse($ultimaLectura->fecha_lectura)->format('Y');

        return response()->json(['mes' => $mesUltimaLectura, 'anio' => $anioUltimaLectura]);
    }

    return response()->json(['mes' => 'No hay lecturas registradas', 'anio' => 'No hay lecturas registradas']);
}





    
}
