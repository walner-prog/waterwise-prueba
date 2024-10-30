<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'apellido', 'puesto', 'usuario_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function egresos()
    {
        return $this->hasMany(Egreso::class);
    }
}
