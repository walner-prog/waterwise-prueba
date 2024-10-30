<?php


namespace App\Http\Controllers;

use App\Models\LecturaMensual;
use App\Models\Cliente;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {// Consumo promedio por cliente
$consumoPromedio = LecturaMensual::join('medidores', 'lecturas_mensuales.medidor_id', '=', 'medidores.id')
->select('medidores.cliente_id', DB::raw('AVG(lecturas_mensuales.consumo) as consumo_promedio'))
->with('cliente') // Eager load the cliente relationship
->groupBy('medidores.cliente_id')
->get();

// Total de lecturas por cliente
$totalLecturas = LecturaMensual::join('medidores', 'lecturas_mensuales.medidor_id', '=', 'medidores.id')
->select('medidores.cliente_id', DB::raw('COUNT(*) as total_lecturas'))
->with('cliente') // Eager load the cliente relationship
->groupBy('medidores.cliente_id')
->get();

        return view('reportes.index', compact('consumoPromedio','totalLecturas'));
    }

}
