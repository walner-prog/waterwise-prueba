<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\Ingreso;

class Venta extends Model
{
    protected $fillable = ['producto_id', 'cliente_id', 'cantidad', 'precio_venta', 'total_pagar', 'descripcion'];

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

        // Crear ingreso y ajustar stock al crear una venta
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

        // Actualizar ingreso y stock al actualizar una venta
        static::updating(function ($venta) {
            $producto = $venta->producto;
            $originalCantidad = $venta->getOriginal('cantidad');
            $originalTotalPagar = $venta->getOriginal('total_pagar');

            // Ajustar el stock si la cantidad ha cambiado
            if ($producto && $venta->cantidad != $originalCantidad) {
                $producto->stok += $originalCantidad - $venta->cantidad;
                $producto->save();
            }

            // Actualizar el ingreso si el total a pagar ha cambiado
            if ($venta->total_pagar != $originalTotalPagar) {
                $venta->ingreso()->update([
                    'monto' => $venta->total_pagar,
                    'fecha' => now(),
                    'descripcion' => $venta->descripcion ?? 'Sin descripción',
                ]);
            }
        });

        // Revertir stock y eliminar ingreso al eliminar una venta
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
