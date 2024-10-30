<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medidor extends Model
{
    use HasFactory;
     protected $table = 'medidores';
    protected $fillable = [
        'numero_medidor', 'ubicacion', 'cliente_id',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    

    public function lecturasMensuales()
    {
        return $this->hasMany(LecturaMensual::class);
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'medidor_id', 'id'); // Ajusta 'medidor_id' si es necesario
    }
}
