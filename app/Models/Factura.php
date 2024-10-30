<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'cliente_id', 'medidor_id', 'lectura_id', 'tarifa_id', 'fecha_factura', 'monto_total', 'estado_pago',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function medidor()
    {
        return $this->belongsTo(Medidor::class);
    }

    public function lectura()
    {
        return $this->belongsTo(LecturaMensual::class, 'lectura_id');
    }
    

    public function tarifa()
    {
        return $this->belongsTo(Tarifa::class);
    }

    public function ingreso()
    {
        return $this->hasOne(Ingreso::class);
    }

    public function lecturaMensual()
{
return $this->hasOne(LecturaMensual::class, 'medidor_id', 'medidor_id'); // Ajusta según tus claves foráneas
}

    
}
