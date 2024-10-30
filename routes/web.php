<?php
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MedidorController;
use App\Http\Controllers\LecturasMensualesController;
use App\Http\Controllers\TarifaController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\EgresoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\FinanzaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReportController;
use App\Http\Livewire\ReporteMensual;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\PayPalController;

use App\Http\Controllers\PaymentController;
// Rutas para Facturas




Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


 Route::resource('roles', RoleController::class);



// Rutas para UsuarioController
Route::resource('usuarios', UsuarioController::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
 /*Route::middleware(['role:admin'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});*/


Route::get('/perfil', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
 
Route::put('/profile/update', 'App\Http\Controllers\ProfileController@update')->name('profile.update');


// Rutas para cambio de contrase;a
Route::get('cambiar_password', 'App\Http\Controllers\UsuarioController@showChangePasswordForm')->name('change-password-form');
Route::post('cambiar_password', 'App\Http\Controllers\UsuarioController@changePassword')->name('change_password');

Route::resource('clientes', ClienteController::class);
Route::get('/api/clientes/{id}', [ClienteController::class, 'getcliente'])->name('clientes.getcliente');
Route::get('/buscar-clientes', [ClienteController::class, 'buscarcliente'])->name('buscarcliente');

Route::get('/notificaciones', [ClienteController::class, 'mostrarFormularioNotificaciones'])->name('mostrar.formulario.notificaciones');
Route::post('/enviar-notificaciones', [ClienteController::class, 'enviarNotificaciones'])->name('enviar.notificaciones');
// routes/web.php
Route::get('/clientes-pdf', [ClienteController::class, 'clientesAllPdf'])->name('clientes.pdf');
Route::get('/clientes-import', [ClienteController::class, 'showImportForm'])->name('clientes.import');
Route::post('/clientes/import', [ClienteController::class, 'import'])->name('clientes.import.submit');


Route::resource('medidores', MedidorController::class);
Route::resource('lecturas_mensuales', LecturasMensualesController::class);
Route::get('/lectura-anterior/{medidor_id}', [LecturasMensualesController::class, 'getUltimaLectura'])->name('lectura.anterior');
Route::get('api/mes_actual', [LecturasMensualesController::class, 'getMesActual'])->name('mes.actual');
Route::get('lecturas_mensuales/voucher/{id}', [LecturasMensualesController::class, 'voucher'])->name('lecturas_mensuales.voucher');
Route::get('/lecturas-mensuales/ultima-lectura', [LecturasMensualesController::class, 'ultimaLectura'])->name('lecturas_mensuales.ultima_lectura');
Route::get('/lecturas_mensuales_ultima_lectura_mes', [LecturasMensualesController::class, 'obtenerMesUltimaLectura'])->name('lecturas_mensuales.ultima_lectura_mes');



Route::resource('tarifas', TarifaController::class);
Route::resource('facturas', FacturaController::class);
Route::get('/api/facturas/{clienteId}', [FacturaController::class, 'facturasPendientes'])->name('factura.pendiente');
Route::post('/facturas/confirmar-pago', [FacturaController::class, 'confirmarPago'])->name('facturas.confirmarPago');

Route::post('/facturas/procesar-pago', [FacturaController::class, 'procesarPago'])->name('facturas.procesarPago');
Route::get('/pagos_recibo', [FacturaController::class, 'pagos'])->name('pagos.recibos');

Route::get('/pagos/recibo/{facturaIds}', [FacturaController::class, 'generarRecibo'])->name('pagos.imprimir');


Route::get('/api/his/clientes/{clienteId}', [FacturaController::class, 'mostrarHistorialPagos'])->name('clientes.historial_pagos');
Route::post('/pagos_recibo', [FacturaController::class, 'mostrarRecibo'])->name('pagos.recibo');


Route::resource('ingresos', IngresoController::class);
//Route::get('/ingresos/{id}', [IngresoController::class, 'show'])->name('ingresos.show_unico');



Route::resource('egresos', EgresoController::class);
Route::get('/egresos/recibo/{id}', [EgresoController::class, 'recibo'])->name('egresos.recibo');



Route::resource('empleados', EmpleadoController::class);
Route::get('/empleados/check/{id}', [EmpleadoController::class, 'check']);


Route::get('/reportes', [ReportController::class, 'index'])->name('reportes.index');
Route::get('/finanzas', [FinanzaController::class, 'index'])->name('finanzas.index');
Route::get('/reporte-mensuales/{mes}/{anio}', [FinanzaController::class, 'generateReport'])->name('reporte.mensuales');
Route::get('/recibo-cobro/{clienteId}', [FinanzaController::class, 'generarReciboCobroPdf'])->name('recibo.cobro.pdf');
Route::get('/enviar-recibo-whatsapp/{clienteId}', [FinanzaController::class, 'enviarReciboPorWhatsApp'])->name('enviar.recibo.whatsapp');
Route::get('/enviar-recibo-correo/{clienteId}', [FinanzaController::class, 'enviarReciboPorCorreo'])->name('enviar.recibo.correo');

Route::get('/reporte-mensual/{mes}/{anio}', ReporteMensual::class)->name('reporte.mensual');

Route::resource('productos', ProductoController::class);
Route::resource('ventas', VentaController::class);


Route::get('paypal/pay', [PayPalController::class, 'payWithPayPal'])->name('paypal.pay');
Route::get('paypal/status', [PayPalController::class, 'getPaymentStatus'])->name('paypal.status');

Route::post('/api/orders', [PaymentController::class, 'crearPedido'])->name('api.orders');
Route::post('/api/orders/{orderID}/capture', [PaymentController::class, 'capturarPedido']);
