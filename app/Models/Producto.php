<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'stok', 'precio_compra', 'precio_venta'];

    // Relación con las ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    protected $casts = [
        'precio_compra' => 'float',
        'precio_venta' => 'float',
        'stok' => 'integer', // Asegúrate también de que stok sea un entero
    ];
}
