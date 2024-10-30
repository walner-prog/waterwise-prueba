<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_tarifa', 'precio_por_m3', 'descripcion', 'fecha_vigencia',
    ];

    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }
}
