<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash; // Asegúrate de importar Hash
class PermissionsDemoSeeder extends Seeder
{
    /**
     * Crear los roles y permisos iniciales para el sistema de agua potable.
     */
    public function run(): void
    {
        // Reiniciar los roles y permisos en caché
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // crear permisos relacionados con la gestión del sistema de agua potable
        Permission::create(['name' => 'gestionar clientes']);
        Permission::create(['name' => 'gestionar medidores']);
        Permission::create(['name' => 'registrar lecturas']);
        Permission::create(['name' => 'emitir facturas']);
        Permission::create(['name' => 'gestionar tarifas']);
        Permission::create(['name' => 'gestionar empleados']);
        Permission::create(['name' => 'ver reportes']);
        Permission::create(['name' => 'gestionar ingresos']);
        Permission::create(['name' => 'gestionar egresos']);

        // crear roles y asignar permisos existentes
        $role1 = Role::create(['name' => 'operador']);
        $role1->givePermissionTo('gestionar clientes');
        $role1->givePermissionTo('gestionar medidores');
        $role1->givePermissionTo('registrar lecturas');

        $role2 = Role::create(['name' => 'administrador']);
        $role2->givePermissionTo('emitir facturas');
        $role2->givePermissionTo('gestionar tarifas');
        $role2->givePermissionTo('ver reportes');
        $role2->givePermissionTo('gestionar empleados');
        $role2->givePermissionTo('gestionar ingresos');
        $role2->givePermissionTo('gestionar egresos');

        $role3 = Role::create(['name' => 'admin']);
        // obtiene todos los permisos a través de la regla Gate::before; ver AuthServiceProvider

        // crear usuarios de ejemplo
        $user = \App\Models\User::factory()->create([
            'name' => 'Operador',
            'email' => 'operador@aguapotable.com',
            'rol' => 'operador',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'Administrador ',
            'email' => 'admin@aguapotable.com',
            'rol' => 'administrador',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Carlos ',
            'email' => 'admin@gmail.com',
            'rol' => 'admin',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole($role3);
    }
}
