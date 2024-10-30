<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        // Instancia de Faker
        $faker = \Faker\Factory::create();

        // Crear 10 clientes
        for ($i = 0; $i < 10; $i++) {
            DB::table('clientes')->insert([
                'primer_nombre' => $faker->firstName(),
                'segundo_nombre' => $faker->firstName(),
                'primer_apellido' => $faker->lastName(),
                'segundo_apellido' => $faker->lastName(),
                //'cedula' => $faker->unique()->numerify('##########'), // Número de cédula único de 10 dígitos
                'direccion' => $faker->address(),
                'telefono' => $faker->unique()->phoneNumber(), // Teléfono único
                'email' => $faker->unique()->safeEmail(),
                'fecha_registro' => $faker->date(), 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
