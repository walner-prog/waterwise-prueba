<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturaMensual extends Model
{
    use HasFactory;
   protected $table = 'lecturas_mensuales';
 
    protected $fillable = [
        'medidor_id', 'lectura_anterior', 'lectura_actual', 'fecha_lectura', 'consumo',
        'fecha_inicio', 'fecha_fin', 'mes_leido'			
    ];

    public function medidor()
    {
        return $this->belongsTo(Medidor::class);
    }

    public function mesLeido()
{
    return $this->belongsTo(LecturaMensual::class, 'lectura_id'); // Ajusta según tus claves foráneas
}
public function cliente()
{
    return $this->belongsTo(Cliente::class, 'cliente_id');
}

}
