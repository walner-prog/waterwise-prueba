<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClientesTableSeeder extends Seeder
{
    public function run()
    {
        $nombres = [
            'Juan', 'Carlos', 'Luis', 'Miguel', 'José',
            'Andrés', 'David', 'Francisco', 'Javier', 'Daniel',
            'Alejandro', 'Sergio', 'Fernando', 'Pablo', 'Diego',
            'Ricardo', 'Manuel', 'Arturo', 'Eduardo', 'Roberto'
        ];

        $apellidos = [
            'García', 'Hernández', 'López', 'Martínez', 'Rodríguez',
            'Pérez', 'Sánchez', 'Torres', 'Ramírez', 'Gómez',
            'Díaz', 'Cruz', 'Reyes', 'Morales', 'Cano',
            'Salazar', 'Mendoza', 'Castillo', 'Quintero', 'Rivas'
        ];

        $emails = []; // Array para almacenar correos únicos

        $clientes = [];
        for ($i = 0; $i < 300; $i++) {
            do {
                $primerNombre = $nombres[array_rand($nombres)];
                $primerApellido = $apellidos[array_rand($apellidos)];
                $email = strtolower($primerNombre) . '.' . strtolower($primerApellido) . '@example.com';
            } while (in_array($email, $emails)); // Asegurarse de que el correo no se haya usado

            // Almacenar el correo electrónico en el array para evitar duplicados
            $emails[] = $email;

            $clientes[] = [
                'primer_nombre' => $primerNombre,
                'segundo_nombre' => $nombres[array_rand($nombres)],
                'primer_apellido' => $primerApellido,
                'segundo_apellido' => $apellidos[array_rand($apellidos)],
                'direccion' => 'Betesda Casa #' . rand(1, 10),
                'telefono' => '505' . rand(100000, 999999),
                'email' => $email,
                'fecha_registro' => Carbon::createFromFormat('Y-m-d', '2024-' . rand(1, 3) . '-' . rand(1, 28)),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('clientes')->insert($clientes);
    }
}
