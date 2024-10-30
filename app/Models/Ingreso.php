<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha', 'monto', 'descripcion', 'factura_id', 'venta_id',
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
