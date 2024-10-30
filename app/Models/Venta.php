<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\Ingreso;

class Venta extends Model
{
    protected $fillable = ['producto_id', 'cliente_id', 'cantidad', 'precio_venta', 'total_pagar', 'descripcion'];

    public function productos()
    {
        return $this->belongsTo(Producto::class);
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    

    public function ingreso()
    {
        return $this->hasOne(Ingreso::class);
    }

      // Relación con el cliente
      public function cliente()
      {
          return $this->belongsTo(Cliente::class);
      }

      

    protected static function boot()
    {
        parent::boot();

        static::created(function ($venta) {
            $producto = $venta->producto;
            if ($producto && $producto->stok >= $venta->cantidad) {
                $producto->stok -= $venta->cantidad;
                $producto->save();

                Ingreso::create([
                    'venta_id' => $venta->id,
                    'monto' => $venta->total_pagar,
                    'fecha' => now(),
                    'descripcion' => $venta->producto->descripcion ?? 'Sin descripción',
                ]);
            }
        });

        static::deleting(function ($venta) {
            $producto = $venta->producto;
            if ($producto) {
                $producto->stok += $venta->cantidad;
                $producto->save();
            }
            $venta->ingreso()->delete();
        });
    }
}
