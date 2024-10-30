<?php

return [

    /*
    |---------------------------------------------------------------------------
    | Valores Predeterminados de Autenticación
    |---------------------------------------------------------------------------
    |
    | Esta opción controla la configuración predeterminada de los "guards" de 
    | autenticación y las opciones de restablecimiento de contraseñas de tu 
    | aplicación. Puedes cambiar estos valores predeterminados según lo 
    | requieras, pero son un excelente punto de partida para la mayoría de 
    | las aplicaciones.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |---------------------------------------------------------------------------
    | Guards de Autenticación
    |---------------------------------------------------------------------------
    |
    | A continuación, puedes definir cada guard de autenticación para tu 
    | aplicación. Por supuesto, aquí se ha definido una excelente 
    | configuración predeterminada que utiliza el almacenamiento de sesión y el
    | proveedor de usuarios Eloquent.
    |
    | Todos los drivers de autenticación tienen un proveedor de usuarios. Esto 
    | define cómo se recuperan los usuarios de tu base de datos u otros 
    | mecanismos de almacenamiento utilizados por esta aplicación para 
    | preservar los datos del usuario.
    |
    | Soportado: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |---------------------------------------------------------------------------
    | Proveedores de Usuarios
    |---------------------------------------------------------------------------
    |
    | Todos los drivers de autenticación tienen un proveedor de usuarios. Esto 
    | define cómo se recuperan los usuarios de tu base de datos u otros 
    | mecanismos de almacenamiento utilizados por esta aplicación para 
    | preservar los datos del usuario.
    |
    | Si tienes múltiples tablas o modelos de usuarios, puedes configurar 
    | múltiples fuentes que representen cada modelo/tabla. Estas fuentes 
    | pueden luego ser asignadas a cualquier guard de autenticación extra que 
    | hayas definido.
    |
    | Soportado: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |---------------------------------------------------------------------------
    | Restablecimiento de Contraseñas
    |---------------------------------------------------------------------------
    |
    | Puedes especificar múltiples configuraciones de restablecimiento de 
    | contraseñas si tienes más de una tabla o modelo de usuarios en la 
    | aplicación y quieres tener configuraciones separadas de restablecimiento 
    | de contraseñas basadas en tipos específicos de usuarios.
    |
    | El tiempo de expiración es la cantidad de minutos durante los cuales cada 
    | token de restablecimiento será considerado válido. Esta función de 
    | seguridad mantiene los tokens activos durante un período corto, por lo 
    | que tienen menos tiempo para ser adivinados. Puedes cambiar esto según 
    | lo necesites.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |---------------------------------------------------------------------------
    | Tiempo de Expiración de Confirmación de Contraseña
    |---------------------------------------------------------------------------
    |
    | Aquí puedes definir la cantidad de segundos antes de que caduque la 
    | confirmación de contraseña y se solicite al usuario que vuelva a ingresar 
    | su contraseña en la pantalla de confirmación. De manera predeterminada, 
    | el tiempo de espera dura tres horas.
    |
    */

    'password_timeout' => 10800,

];
