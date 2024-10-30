<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgresosTable extends Migration
{
    public function up()
    {
        Schema::create('egresos', function (Blueprint $table) {
            $table->id();
            $table->string('pagado_a');
            $table->date('fecha');
            $table->decimal('monto', 10, 2);
            $table->text('descripcion')->nullable();
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('egresos');
    }
}
