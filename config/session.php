<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Driver de Sesión Predeterminado
    |--------------------------------------------------------------------------
    |
    | Esta opción controla el "driver" de sesión predeterminado que se usará
    | en las solicitudes. Por defecto, usaremos el driver nativo liviano, 
    | pero puedes especificar cualquiera de los otros drivers disponibles.
    |
    | Soportado: "file", "cookie", "database", "apc",
    |            "memcached", "redis", "dynamodb", "array"
    |
    */

    'driver' => env('SESSION_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Duración de la Sesión
    |--------------------------------------------------------------------------
    |
    | Aquí puedes especificar el número de minutos que deseas que la sesión
    | permanezca inactiva antes de que expire. Si deseas que expire 
    | inmediatamente al cerrar el navegador, ajusta esa opción.
    |
    */

    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,

    /*
    |--------------------------------------------------------------------------
    | Cifrado de Sesión
    |--------------------------------------------------------------------------
    |
    | Esta opción te permite especificar fácilmente que todos los datos de tu
    | sesión se cifren antes de almacenarse. Todo el cifrado será ejecutado
    | automáticamente por Laravel, y puedes usar la sesión como de costumbre.
    |
    */

    'encrypt' => false,

    /*
    |--------------------------------------------------------------------------
    | Ubicación de Archivos de Sesión
    |--------------------------------------------------------------------------
    |
    | Cuando uses el driver de sesión nativo, necesitamos una ubicación donde
    | los archivos de sesión se puedan almacenar. Se ha establecido una 
    | ubicación predeterminada, pero puedes especificar una diferente.
    | Esto solo es necesario para sesiones basadas en archivos.
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Conexión de Base de Datos de Sesión
    |--------------------------------------------------------------------------
    |
    | Cuando uses los drivers de sesión "database" o "redis", puedes 
    | especificar una conexión que se usará para gestionar estas sesiones. 
    | Esta debe corresponder a una conexión en tu configuración de base de datos.
    |
    */

    'connection' => env('SESSION_CONNECTION', null),

    /*
    |--------------------------------------------------------------------------
    | Tabla de Base de Datos de Sesión
    |--------------------------------------------------------------------------
    |
    | Cuando uses el driver de sesión "database", puedes especificar la tabla
    | que debemos usar para gestionar las sesiones. Por supuesto, se te ha
    | proporcionado un valor predeterminado, pero puedes cambiarlo según sea necesario.
    |
    */

    'table' => 'sessions',

    /*
    |--------------------------------------------------------------------------
    | Almacenamiento en Caché de Sesión
    |--------------------------------------------------------------------------
    |
    | Al usar uno de los backends de sesión basados en caché del framework, 
    | puedes especificar un almacén de caché que se usará para estas sesiones. 
    | Este valor debe coincidir con uno de los "almacenes" de caché configurados.
    |
    | Afecta: "apc", "dynamodb", "memcached", "redis"
    |
    */

    'store' => env('SESSION_STORE', null),

    /*
    |--------------------------------------------------------------------------
    | Lotería de Limpieza de Sesión
    |--------------------------------------------------------------------------
    |
    | Algunos drivers de sesión deben limpiar manualmente su ubicación de
    | almacenamiento para deshacerse de las sesiones antiguas. Aquí están las
    | posibilidades de que esto suceda en una solicitud dada. Por defecto, las
    | probabilidades son 2 de 100.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Nombre de la Cookie de Sesión
    |--------------------------------------------------------------------------
    |
    | Aquí puedes cambiar el nombre de la cookie utilizada para identificar una
    | instancia de sesión por ID. El nombre especificado aquí se usará cada vez 
    | que el framework cree una nueva cookie de sesión para cada driver.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Ruta de la Cookie de Sesión
    |--------------------------------------------------------------------------
    |
    | La ruta de la cookie de sesión determina el camino para el cual la cookie
    | se considerará disponible. Normalmente, esta será la ruta raíz de tu
    | aplicación, pero puedes cambiarla cuando sea necesario.
    |
    */

    'path' => '/',

    /*
    |--------------------------------------------------------------------------
    | Dominio de la Cookie de Sesión
    |--------------------------------------------------------------------------
    |
    | Aquí puedes cambiar el dominio de la cookie utilizada para identificar una
    | sesión en tu aplicación. Esto determinará a qué dominios está disponible 
    | la cookie en tu aplicación. Se ha establecido un valor predeterminado razonable.
    |
    */

    'domain' => env('SESSION_DOMAIN', null),

    /*
    |--------------------------------------------------------------------------
    | Cookies Solo HTTPS
    |--------------------------------------------------------------------------
    |
    | Al configurar esta opción en true, las cookies de sesión solo se enviarán
    | de vuelta al servidor si el navegador tiene una conexión HTTPS. Esto
    | evitará que la cookie sea enviada cuando no se pueda hacer de manera segura.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE'),

    /*
    |--------------------------------------------------------------------------
    | Acceso Solo HTTP
    |--------------------------------------------------------------------------
    |
    | Al configurar este valor en true, se evitará que JavaScript acceda al valor
    | de la cookie, y la cookie solo será accesible a través del protocolo HTTP.
    | Puedes modificar esta opción según sea necesario.
    |
    */

    'http_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Cookies Same-Site
    |--------------------------------------------------------------------------
    |
    | Esta opción determina cómo se comportan tus cookies cuando ocurren 
    | solicitudes entre sitios, y puede usarse para mitigar ataques CSRF. Por
    | defecto, configuramos este valor en "lax" ya que es un valor seguro.
    |
    | Soportado: "lax", "strict", "none", null
    |
    */

    'same_site' => 'lax',

];
