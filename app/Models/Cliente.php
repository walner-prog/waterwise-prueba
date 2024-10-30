<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido', 'direccion', 'telefono', 'email', 'fecha_registro',
    ];

    public function medidores()
    {
        return $this->hasMany(Medidor::class);
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }
}
