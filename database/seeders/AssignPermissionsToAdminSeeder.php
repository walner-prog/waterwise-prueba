<?php

namespace Database\Seeders;

use App\Models\User; // Asegúrate de que este sea el modelo correcto
use Spatie\Permission\Models\Permission; // O el modelo que estés usando para permisos
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AssignPermissionsToAdminSeeder extends Seeder
{
    public function run()
    {
        // Verificar si el usuario admin@gmail.com ya existe
        $admin = User::where('email', 'admin@gmail.com')->first();

        if (!$admin) {
            // Crear el usuario si no existe
            $admin = User::create([
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'), // Asegúrate de usar un hash para la contraseña
                'rol' => 'admin' // Cambia esto según la estructura de tu tabla
            ]);

            $this->command->info('Usuario admin@gmail.com creado con éxito.');
        } else {
            $this->command->info('El usuario admin@gmail.com ya existe.');
        }

        // Obtener todos los permisos
        $permissions = Permission::all();

        // Asignar todos los permisos al usuario
        $admin->syncPermissions($permissions);
        // O si deseas asignarlos sin eliminar los permisos existentes:
        // $admin->givePermissionTo($permissions);

        $this->command->info('Todos los permisos han sido asignados al usuario admin@gmail.com');
    }
}
