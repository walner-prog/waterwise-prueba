<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nombre de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Este valor es el nombre de tu aplicación. Se utiliza cuando el framework
    | necesita mostrar el nombre de la aplicación en notificaciones u otros
    | lugares requeridos por la aplicación o sus paquetes.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Entorno de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Este valor determina el "entorno" en el que tu aplicación se está ejecutando
    | actualmente. Esto puede afectar cómo prefieres configurar varios servicios
    | que utiliza la aplicación. Establece esto en tu archivo ".env".
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Modo Depuración de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Cuando tu aplicación está en modo de depuración, se mostrarán mensajes
    | de error detallados con rastros de pila en cada error que ocurra. Si
    | está desactivado, se mostrará una página de error genérica simple.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | URL de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Esta URL es utilizada por la consola para generar correctamente URLs
    | al usar la herramienta de línea de comandos Artisan. Debes establecer
    | esto en la raíz de tu aplicación para que se use en tareas de Artisan.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Zona Horaria de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Aquí puedes especificar la zona horaria predeterminada para tu aplicación,
    | que será utilizada por las funciones de fecha y hora de PHP. Hemos
    | establecido un valor predeterminado razonable para ti.
    |
    */

    'timezone' => 'America/Managua',

    /*
    |--------------------------------------------------------------------------
    | Configuración de Localización de la Aplicación
    |--------------------------------------------------------------------------
    |
    | El valor de localización determina el idioma predeterminado que se usará
    | en el servicio de traducción. Puedes configurar esto en cualquier idioma
    | que sea soportado por tu aplicación.
    |
    */

    'locale' => 'es',

    /*
    |--------------------------------------------------------------------------
    | Localización de Respaldo de la Aplicación
    |--------------------------------------------------------------------------
    |
    | La localización de respaldo determina el idioma a usar cuando el idioma
    | actual no está disponible. Puedes cambiar el valor a cualquiera de los
    | idiomas proporcionados por tu aplicación.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Localización de Faker
    |--------------------------------------------------------------------------
    |
    | Esta localización será usada por la librería Faker PHP cuando se generen
    | datos falsos para tus seeds de base de datos. Por ejemplo, esto se usará
    | para obtener números de teléfono, direcciones, entre otros, localizados.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Clave de Encriptación
    |--------------------------------------------------------------------------
    |
    | Esta clave es utilizada por el servicio de encriptación de Laravel y debe
    | establecerse en una cadena aleatoria de 32 caracteres. Por favor haz esto
    | antes de desplegar tu aplicación para asegurar las cadenas encriptadas.
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Proveedores de Servicios Autocargados
    |--------------------------------------------------------------------------
    |
    | Los proveedores de servicios listados aquí serán cargados automáticamente
    | en cada solicitud a tu aplicación. Siéntete libre de agregar tus propios
    | servicios a este arreglo para ampliar la funcionalidad de tu aplicación.
    |
    */

    'providers' => [

        /*
         * Proveedores de Servicios del Framework de Laravel...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        Spatie\Permission\PermissionServiceProvider::class,

        /*
         * Proveedores de Servicios de Paquetes...
         */

        /*
         * Proveedores de Servicios de la Aplicación...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Aliases de Clases
    |--------------------------------------------------------------------------
    |
    | Este arreglo de alias de clases se registrará cuando esta aplicación
    | se inicie. Sin embargo, siéntete libre de registrar tantos como desees,
    | ya que los alias se cargan de manera "perezosa", por lo que no afectan
    | el rendimiento.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'Date' => Illuminate\Support\Facades\Date::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Http' => Illuminate\Support\Facades\Http::class,
        'Js' => Illuminate\Support\Js::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'RateLimiter' => Illuminate\Support\Facades\RateLimiter::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        // 'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,

    ],

];
