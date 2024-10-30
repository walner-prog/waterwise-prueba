<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CambioMedidor extends Model
{
    protected $fillable = [
        'cliente_id', 'medidor_anterior_id', 'lectura_final', 'medidor_nuevo_id', 'fecha_cambio'
    ];

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function medidorAnterior() {
        return $this->belongsTo(Medidor::class, 'medidor_anterior_id');
    }

    public function medidorNuevo() {
        return $this->belongsTo(Medidor::class, 'medidor_nuevo_id');
    }
}
