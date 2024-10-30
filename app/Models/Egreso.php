<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha','pagado_a', 'monto', 'descripcion', 'empleado_id',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
