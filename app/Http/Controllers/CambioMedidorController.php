<?php

namespace App\Http\Controllers;
use App\Models\Cliente;
use App\Models\CambioMedidor;
use Illuminate\Http\Request;

class CambioMedidorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function cambiarMedidor(Request $request, $clienteId)
{
    $cliente = Cliente::findOrFail($clienteId);
    $medidorAnterior = $cliente->medidor;

    // Registrar el cambio de medidor
    CambioMedidor::create([
        'cliente_id' => $cliente->id,
        'medidor_anterior_id' => $medidorAnterior->id,
        'lectura_final' => $medidorAnterior->lectura_actual,  // Última lectura del medidor anterior
        'medidor_nuevo_id' => $request->nuevo_medidor_id,  // Nuevo medidor
        'fecha_cambio' => now(),
    ]);

    // Actualizar el cliente con el nuevo medidor
    $cliente->update(['medidor_id' => $request->nuevo_medidor_id]);

    return back()->with('info', 'Medidor cambiado exitosamente.');
}

}
