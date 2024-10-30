<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedidoresTable extends Migration
{
    public function up()
    {
        Schema::create('medidores', function (Blueprint $table) {
            $table->id();
            $table->string('numero_medidor');
            $table->string('ubicacion');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medidores');
    }
}
