<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $productos = [
            // Llaves de paso
            ['nombre' => 'Llave de paso 1/2"', 'descripcion' => 'Llave de paso de 1/2" para control de flujo de agua', 'precio_venta' => 45],
            ['nombre' => 'Llave de paso 1"', 'descripcion' => 'Llave de paso de 1" para control de flujo de agua', 'precio_venta' => 55],
            ['nombre' => 'Llave de paso 1 1/2"', 'descripcion' => 'Llave de paso de 1 1/2" para control de flujo de agua', 'precio_venta' => 65],
            ['nombre' => 'Llave de paso 2"', 'descripcion' => 'Llave de paso de 2" para control de flujo de agua', 'precio_venta' => 75],

            // Medidor
            ['nombre' => 'Medidor', 'descripcion' => 'Medidor de agua estándar', 'precio_venta' => 1000],

            // Uniones PVC
            ['nombre' => 'Unión PVC 1/2"', 'descripcion' => 'Unión PVC de 1/2" para conexiones de tubería', 'precio_venta' => 20],
            ['nombre' => 'Unión PVC 3/4"', 'descripcion' => 'Unión PVC de 3/4" para conexiones de tubería', 'precio_venta' => 30],
            ['nombre' => 'Unión PVC 1"', 'descripcion' => 'Unión PVC de 1" para conexiones de tubería', 'precio_venta' => 40],
            ['nombre' => 'Unión PVC 1 1/2"', 'descripcion' => 'Unión PVC de 1 1/2" para conexiones de tubería', 'precio_venta' => 50],
            ['nombre' => 'Unión PVC 2"', 'descripcion' => 'Unión PVC de 2" para conexiones de tubería', 'precio_venta' => 60],

            // Uniones roscadas
            ['nombre' => 'Unión roscada 1/2"', 'descripcion' => 'Unión roscada de 1/2" para tuberías', 'precio_venta' => 20],
            ['nombre' => 'Unión roscada 3/4"', 'descripcion' => 'Unión roscada de 3/4" para tuberías', 'precio_venta' => 30],
            ['nombre' => 'Unión roscada 1"', 'descripcion' => 'Unión roscada de 1" para tuberías', 'precio_venta' => 40],
            ['nombre' => 'Unión roscada 1 1/2"', 'descripcion' => 'Unión roscada de 1 1/2" para tuberías', 'precio_venta' => 50],
            ['nombre' => 'Unión roscada 2"', 'descripcion' => 'Unión roscada de 2" para tuberías', 'precio_venta' => 60],

            // Codos 90°
            ['nombre' => 'Codo 90° 1/2"', 'descripcion' => 'Codo de 90° de 1/2" para tuberías', 'precio_venta' => 20],
            ['nombre' => 'Codo 90° 3/4"', 'descripcion' => 'Codo de 90° de 3/4" para tuberías', 'precio_venta' => 30],
            ['nombre' => 'Codo 90° 1"', 'descripcion' => 'Codo de 90° de 1" para tuberías', 'precio_venta' => 40],
            ['nombre' => 'Codo 90° 1 1/2"', 'descripcion' => 'Codo de 90° de 1 1/2" para tuberías', 'precio_venta' => 50],
            ['nombre' => 'Codo 90° 2"', 'descripcion' => 'Codo de 90° de 2" para tuberías', 'precio_venta' => 60],

            // Pegamento para PVC
            ['nombre' => 'Pegamento para PVC bote de 1/4', 'descripcion' => 'Pegamento especializado para tuberías PVC, bote de 1/4', 'precio_venta' => 255],

            // Tuberías PVC
            ['nombre' => 'Tubo PVC 1/2"', 'descripcion' => 'Tubo PVC de 1/2" para sistema de tuberías', 'precio_venta' => 180],
            ['nombre' => 'Tubo PVC 3/4"', 'descripcion' => 'Tubo PVC de 3/4" para sistema de tuberías', 'precio_venta' => 225],
            ['nombre' => 'Tubo PVC 1"', 'descripcion' => 'Tubo PVC de 1" para sistema de tuberías', 'precio_venta' => 270],
            ['nombre' => 'Tubo PVC 1 1/2"', 'descripcion' => 'Tubo PVC de 1 1/2" para sistema de tuberías', 'precio_venta' => 315],
            ['nombre' => 'Tubo PVC 2"', 'descripcion' => 'Tubo PVC de 2" para sistema de tuberías', 'precio_venta' => 360],
            ['nombre' => 'Tubo PVC 2 1/2"', 'descripcion' => 'Tubo PVC de 2 1/2" para sistema de tuberías', 'precio_venta' => 405],
            ['nombre' => 'Tubo PVC 3"', 'descripcion' => 'Tubo PVC de 3" para sistema de tuberías', 'precio_venta' => 450],
        ];

        foreach ($productos as $producto) {
            // Calcular precio de compra un 25% menor que el precio de venta
            $precioCompra = $producto['precio_venta'] * 0.75;
            
            // Crear el producto en la base de datos
            Producto::create([
                'nombre' => $producto['nombre'],
                'descripcion' => $producto['descripcion'],
                'stok' => rand(5, 120),
                'precio_compra' => $precioCompra,
                'precio_venta' => $producto['precio_venta'],
            ]);
        }
    }
}
