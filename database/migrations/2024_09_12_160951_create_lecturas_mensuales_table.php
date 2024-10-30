<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturasMensualesTable extends Migration
{
    public function up()
    {
        Schema::create('lecturas_mensuales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medidor_id')->constrained('medidores')->onDelete('cascade'); // para este dato se saca atraves del id en la tabla 
            // medidores el cual dicho medidor pertenece a un cliente.
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade'); // Relación con la tabla clientes

            $table->decimal('lectura_anterior', 10, 2);
            $table->decimal('lectura_actual', 10, 2);
            $table->date('fecha_lectura');
            
            $table->decimal('consumo', 10, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('mes_leido');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lecturas_mensuales');
    }
}
