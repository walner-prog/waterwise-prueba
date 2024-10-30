<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Permisos para ClienteController (resource)
         $this->createPermissionsForResource('usuarios');

          // Permisos para ClienteController (resource)
        $this->createPermissionsForResource('roles');

        // Permisos para ClienteController (resource)
        $this->createPermissionsForResource('clientes');

        // Permisos para MedidorController (resource)
        $this->createPermissionsForResource('medidores');

        // Permisos para LecturasMensualesController (resource)
        $this->createPermissionsForResource('lecturas_mensuales');

        // Permisos para TarifaController (resource)
        $this->createPermissionsForResource('tarifas');

        // Permisos para FacturaController (resource)
        $this->createPermissionsForResource('facturas');

        // Permisos para IngresoController (resource)
        $this->createPermissionsForResource('ingresos');

        // Permisos para EgresoController (resource)
        $this->createPermissionsForResource('egresos');

        // Permisos para EmpleadoController (resource)
        $this->createPermissionsForResource('empleados');

         // Permisos para EmpleadoController (resource)
         $this->createPermissionsForResource('finanzas');
    }

    /**
     * Crea permisos para un recurso.
     *
     * @param string $resource
     */
    private function createPermissionsForResource(string $resource)
    {
        $permissions = [
            "ver-$resource",
            "crear-$resource",
            "editar-$resource",
            "borrar-$resource",
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert([
                'name' => $permission,
                'guard_name' => 'web', // Asegúrate de proporcionar el guard_name
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
