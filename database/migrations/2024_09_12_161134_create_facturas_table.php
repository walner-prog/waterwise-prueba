<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('medidor_id')->constrained('medidores')->onDelete('cascade');
            $table->foreignId('lectura_id')->constrained('lecturas_mensuales')->onDelete('cascade');
            $table->foreignId('tarifa_id')->constrained('tarifas')->onDelete('cascade');
            $table->date('fecha_factura');
            $table->decimal('monto_total', 10, 2);
            $table->enum('estado_pago', ['pendiente', 'pagado']);
            $table->timestamp('fecha_pago')->nullable(); // Agregar columna fecha_pago
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturas');
    }
}
