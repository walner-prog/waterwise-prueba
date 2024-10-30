<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// Importamos el modelo de permisos de Spatie
use Spatie\Permission\Models\Permission;

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Definimos los permisos correspondientes a las rutas
        $permisos = [
            

            // Rutas para el perfil del usuario
            'ver-perfil',
            'editar-perfil',
             
            // Rutas para buscar usuario
            'ver-buscar-usuario',
            'ver-usuario-api',
           

            // Rutas para restablecimiento de contraseña
            'ver-password-reset-form',
            'enviar-password-reset-link',
            'ver-password-reset-token',
            'actualizar-password',

            // Rutas para cambio de contraseña
            'ver-cambiar-password-form',
            'cambiar-password',


            'ver-historial-pagos',
            'ver-facturas-pendientes',
            'ver-pagos-confirmar',
            'ver-recibos-pago',

            // Permisos para RoleController (resource)
           /* 'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',

            // Permisos para UserRoles (resource)
            /*'ver-usuario-rol',
            'crear-usuario-rol',
            'editar-usuario-rol',
            'borrar-usuario-rol', */

             // Permisos para UsuarioController (resource)
            
            /* 'crear-usuario',
             'editar-usuario',
             'borrar-usuario',
             'ver-usuario',  */


           

        ];
         
        

        // Creamos cada permiso en la base de datos
        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }
    }
}
