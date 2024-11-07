<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; // Importa la clase Validator de Laravel
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Imports\ClientesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\EnviarNotificacionesJob; 
use Illuminate\Support\Facades\Mail;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      //  $clientes = Cliente::all();
        
        return view('clientes.index');
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          
            'primer_nombre'  => 'required|string|max:255',
            'segundo_nombre'  => 'required|string|max:255',
            'primer_apellido'  => 'required|string|max:255',
            'segundo_apellido'  => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'email|unique:clientes,email',
            'fecha_registro' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Por favor corrige los errores.');
        }

        Cliente::create($validator->validated());

        return redirect()->route('clientes.index')->with('info', 'Cliente agregado exitosamente.');
    }

    public function show($id)
    {
        // Obtener el cliente por ID
        $cliente = Cliente::findOrFail($id);
        
        // Formatear la fecha de registro
        $cliente->fecha_registro = Carbon::parse($cliente->fecha_registro)->format('d/m/Y');
        
        // Obtener las últimas 3 facturas asociadas al cliente, ordenadas por fecha de pago descendente
        $facturas = $cliente->facturas()->orderBy('fecha_pago', 'desc')->take(3)->get();
        
        // Formatear los montos de cada factura
        foreach ($facturas as $factura) {
            $factura->monto_formateado = number_format($factura->monto_total, 2, ',', '.');
        }
    
        // Pasar a la vista
        return view('clientes.show', compact('cliente', 'facturas'));
    }
    
    

    public function edit($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return redirect()->route('clientes.index')->with('error', 'Cliente no encontrado.');
        }
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validator = Validator::make($request->all(), [
            'primer_nombre'  => 'required|string|max:255',
            'segundo_nombre'  => 'required|string|max:255',
            'primer_apellido'  => 'required|string|max:255',
            'segundo_apellido'  => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'email|unique:clientes,email,' . $cliente->id,
            'fecha_registro' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Por favor corrige los errores.');
        }

        $cliente->update($validator->validated());

        return redirect()->route('clientes.index')->with('update', 'Cliente actualizado exitosamente.');
    }

    public function destroy($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->delete();

            return response()->json(['delete' => 'Cliente eliminado exitosamente.']);
        } catch (\Exception $e) {
            // Registra el error en los logs
            Log::error('Error en el control de Cliente: '.$e->getMessage());
            return redirect()->route('clientes.index')->with('delete', 'Error al eliminar el cliente.');
        }
    }



    public function getcliente($id)
    {
        // Obtener el cliente por su ID utilizando findOrFail
        $cliente = Cliente::findOrFail($id);
    
        return response()->json([
            'id' => $cliente->id,
            'primer_nombre' => $cliente->primer_nombre,
            'segundo_nombre' => $cliente->segundo_nombre,
            'primer_apellido' => $cliente->primer_apellido,
            'segundo_apellido' => $cliente->segundo_apellido,
            'direccion' => $cliente->direccion,
            'telefono' => $cliente->telefono,
            'email' => $cliente->email,
            'fecha_registro' => $cliente->fecha_registro,
        ]);
    }
    
  

  
/**Concatenar nombres y apellidos: Se utiliza una consulta donde se concatenan los nombres y apellidos
 *  del paciente para realizar la búsqueda.
Descomponer la búsqueda en términos: Se divide la búsqueda en palabras clave para que puedan coincidir 
con cualquier combinación de nombre y apellido */
 
  public function buscarcliente(Request $request) {
    $query = $request->get('query');
    $terms = explode(' ', $query);

    $cliente = Cliente::where(function($q) use ($terms) {
        foreach ($terms as $term) {
            $q->orWhere('primer_nombre', 'LIKE', "%{$term}%")
              ->orWhere('segundo_nombre', 'LIKE', "%{$term}%")
              ->orWhere('primer_apellido', 'LIKE', "%{$term}%")
              ->orWhere('segundo_apellido', 'LIKE', "%{$term}%");
        }
    })
    ->orWhere(DB::raw("CONCAT(primer_nombre, ' ', segundo_nombre, ' ', primer_apellido, ' ', segundo_apellido)"), 'LIKE', "%{$query}%")
   // ->orWhere('no_cedula', 'LIKE', "%{$query}%")
   // ->orWhere('no_expediente', 'LIKE', "%{$query}%")
    ->paginate(5); // Ajusta el número de resultados por página según sea necesario

    return response()->json($cliente);
}


public function buscarClientes($termino)
{
    // Asegúrate de que el término no esté vacío
    if (empty($termino)) {
        return Cliente::all(); // Devuelve todos los clientes si no hay término de búsqueda
    }

    // Realiza la búsqueda en el modelo Cliente
    $clientes = Cliente::where('primer_nombre', 'like', '%' . $termino . '%')
        ->orWhere('primer_apellido', 'like', '%' . $termino . '%')
        ->get();

    // Verifica si se encontraron resultados
    if ($clientes->isEmpty()) {
        // Puedes manejar esto como desees, aquí simplemente retorno un mensaje
        return response()->json(['mensaje' => 'No se encontraron resultados.'], 404);
    }

    return $clientes;
}



public function mostrarFormularioNotificaciones()
{
    return view('clientes.notificaciones');
}

public function enviarNotificaciones(Request $request)
{
    $request->validate([
        'subject' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    $clientes = Cliente::all();
    $loteSize = 5; // Cantidad de correos a enviar por lote

    foreach ($clientes->chunk($loteSize) as $index => $clientesLote) {
        // Despachar un job para cada lote
        EnviarNotificacionesJob::dispatch($request->subject, $request->content, $clientesLote);
        
        // Esperar 10 minutos antes de enviar el siguiente lote
        if ($index < $clientes->count() / $loteSize - 1) {
            sleep(600); // 600 segundos = 10 minutos
        }
    }

   // return redirect()->back()->with('success', 'Notificaciones en proceso de envío.');
    return redirect()->route('clientes.index')->with('info', 'Notificaciones en proceso de envío.');
}

public function clientesAllPdf()
{
    // Obtener todos los clientes con sus medidores
    $clientes = Cliente::with('medidores')->get();

    // Cargar la vista y pasar los datos de clientes
    $pdf = Pdf::loadView('clientes.clientes_pdfAll', compact('clientes'));

    // Descargar el PDF
    return $pdf->stream('clientes_medidores.pdf');

}

 // Método para mostrar el formulario de importación
 public function showImportForm()
 {
     return view('clientes.import');
 }

 

}
