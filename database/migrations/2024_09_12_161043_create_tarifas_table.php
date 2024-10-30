<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifasTable extends Migration
{
    public function up()
    {
        Schema::create('tarifas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_tarifa');
            $table->decimal('precio_por_m3', 8, 2);
            $table->text('descripcion')->nullable();
            $table->date('fecha_vigencia');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tarifas');
    }
}
