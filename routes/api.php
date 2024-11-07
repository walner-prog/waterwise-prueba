<?php

use App\Models\Ingreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Egreso;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('clientes', function () {
    
    return datatables()
    ->eloquent( App\Models\Cliente::query())
    ->addColumn('btn','botones/actions-clientes')
    ->rawColumns(['btn'])
    ->toJson();
});


Route::get('medidores', function () {
    return datatables()
        ->eloquent(App\Models\Medidor::with('cliente')) // Carga la relación con cliente
        ->addColumn('cliente_nombre', function ($medidor) {
            return $medidor->cliente->primer_nombre; // Accede al nombre del cliente relacionado
        })
        ->addColumn('cliente_apellido', function ($medidor) {
            return $medidor->cliente->primer_apellido; // Accede al nombre del cliente relacionado
        })
        ->addColumn('btn', 'botones/actions-medidores')
        ->rawColumns(['btn'])
        ->toJson();
});



Route::get('lecturas_mensuales', function () {
    return datatables()
        ->eloquent(App\Models\LecturaMensual::with('medidor.cliente')) // Relación para traer datos del cliente
        ->addColumn('cliente_nombre', function ($lectura) {
            return $lectura->medidor->cliente->primer_nombre; // Accede al nombre del cliente relacionado
        })
        ->addColumn('cliente_apellido', function ($lectura) {
            return $lectura->medidor->cliente->primer_apellido; // Accede al apellido del cliente relacionado
        })
        ->addColumn('btn', 'botones/lecturas_mensuales') // Botones personalizados
        ->rawColumns(['btn'])
        ->toJson();
});



Route::get('tarifas', function () {
    
    return datatables()
    ->eloquent( App\Models\Tarifa::query())
    ->addColumn('btn','botones/actions-tarifas')
    ->rawColumns(['btn'])
    ->toJson();
});


Route::get('facturas', function () {
    return datatables()
        ->eloquent(App\Models\Factura::with(['cliente', 'medidor', 'tarifa']))
        ->addColumn('btn', 'botones/actions-facturas')
        ->rawColumns(['btn'])
        ->toJson();
});


Route::get('empleados', function () {
    
    return datatables()
    ->eloquent( App\Models\Empleado::query())
    ->addColumn('btn','botones/actions-empleados')
    ->rawColumns(['btn'])
    ->toJson();
});

Route::get('usuarios', function () {
    
    return datatables()
    ->eloquent( App\Models\User::query())
    ->addColumn('btn','botones/actions-usuarios')
    ->rawColumns(['btn'])
    ->toJson();
});
Route::get('ingresos', function () {
    return datatables()
        ->eloquent(App\Models\Ingreso::with(['factura.cliente', 'venta.cliente', 'factura.medidor', 'factura.lectura', 'factura.tarifa']))
        ->addColumn('cliente_primer_nombre', function ($ingreso) {
            if ($ingreso->venta && $ingreso->venta->cliente) {
                return $ingreso->venta->cliente->primer_nombre;
            } elseif ($ingreso->factura && $ingreso->factura->cliente) {
                return $ingreso->factura->cliente->primer_nombre;
            }
            return 'Sin cliente';
        })
        ->addColumn('cliente_primer_apellido', function ($ingreso) {
            if ($ingreso->venta && $ingreso->venta->cliente) {
                return $ingreso->venta->cliente->primer_apellido;
            } elseif ($ingreso->factura && $ingreso->factura->cliente) {
                return $ingreso->factura->cliente->primer_apellido;
            }
            return 'Sin cliente';
        })
        ->addColumn('btn', 'botones/actions-ingresos')
        ->rawColumns(['btn'])
        ->toJson();
});






Route::get('egresos', function () {
    return datatables()
        ->eloquent(Egreso::with('empleado')) // Carga la relación empleado
        ->addColumn('empleado', function(Egreso $egreso) {
            return $egreso->empleado ? $egreso->empleado->nombre . ' ' . $egreso->empleado->apellido : 'N/A'; // Incluye el apellido
        })
        
        ->addColumn('btn', 'botones/actions-egresos')
        ->rawColumns(['btn'])
        ->toJson();
});



Route::get('/api/his/clientes/{clienteId}', function ($clienteId) {
    return datatables()
        ->eloquent(
            Ingreso::whereHas('factura', function ($query) use ($clienteId) {
                $query->where('cliente_id', $clienteId);
            })
            ->with(['factura.cliente', 'factura.medidor', 'factura.lectura', 'factura.tarifa'])
            ->query()
        )
        ->addColumn('btn', 'botones/actions-ingresos')
        ->rawColumns(['btn'])
        ->toJson();
});
