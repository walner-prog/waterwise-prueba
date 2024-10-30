<?php

return [

    

    'title' => '',
    'title_prefix' => '',
    'title_postfix' => '',

    

    'use_ico_only' => false,
    'use_full_favicon' => false,

    

    'google_fonts' => [
        'allowed' => false,
    ],



    'logo' => '<b>WATER WISE',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-1',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xl',
    'logo_img_alt' => 'Admin Logo',

    

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 100,
            'height' => 100,
        ],
    ],

   

    'preloader' => [
        'enabled' => false,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__wobble',
            'width' => 30,
            'height' => 30,
        ],
    ],

   

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

   

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,  /* su valor era null lo cambie  */
    'layout_fixed_navbar' => true, //lo cambie a true
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null, // lo cambie a true

    'classes_auth_card' => 'bg-gradient-dark',
'classes_auth_header' => '',
'classes_auth_body' => 'bg-gradient-dark',
'classes_auth_footer' => 'text-center',
'classes_auth_icon' => 'fa-fw text-light',
'classes_auth_btn' => 'btn-flat btn-light',
    


    'classes_body' => '',
    'classes_brand' => 'bg-indigo text-white',
 
     'classes_brand_text' => '',
     'classes_content_wrapper' => '',
     'classes_content_header' => '',
     'classes_content' => '',
     'classes_sidebar' => 'sidebar-dark-primary elevation-4',
     'classes_sidebar_nav' => '',
     'classes_topnav' => ' navbar-darl navbar-dark ',
     'classes_topnav_nav' => 'navbar-expand ',
     'classes_topnav_container' => 'container bg-primary',

   
     'sidebar_mini' => 'lg',
     'sidebar_collapse' => false,
     'sidebar_collapse_auto_size' => false,
     'sidebar_collapse_remember' => false,
     'sidebar_collapse_remember_no_transition' => true,
     'sidebar_scrollbar_theme' => 'os-theme-light',
     'sidebar_scrollbar_auto_hide' => 'l',
     'sidebar_nav_accordion' => true,
     'sidebar_nav_animation_speed' => 500,
 

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
       /* [
            'type' => 'navbar-search',
            'text' => 'search',
            'topnav_right' => true,
        ], */
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        // Sidebar items:
    
            [
                'text'       => 'Clientes Registrados',
                'icon_color' => 'white',
                'text_color' => 'dark',
                'icon'       => 'fas fa-fw fa-address-card icon-separation-sidebar',
                'route'      => 'clientes.index',
                'can'      => 'ver-clientes',
                'active'     => ['clientes*'],
            ],
           
            [
                'text'       => 'Medidores',
                'icon_color' => 'white',
                'icon'       => 'fas fa-fw fa-file-medical icon-separation-sidebar',
                'route'      => 'medidores.index',
                'active'     => ['medidores*'],
                'can'      => 'ver-medidores',
            ],
            [
                'text'       => 'Lecturas',
                'icon_color' => 'white',
                'icon'       => 'fas fa-fw fa-ambulance icon-separation-sidebar',
                'route'      => 'lecturas_mensuales.index',
                'active'     => ['lecturas_mensuales*'],
                'can'      => 'ver-lecturas_mensuales',
            ],
            [
                'text'       => 'Tarifas',
                'icon_color' => 'white',
                'icon'       => 'fas fa-fw fa-notes-medical icon-separation-sidebar',
                'route'      => 'tarifas.index',
                'active'     => ['tarifas*'],
                'can'      => 'ver-tarifas',
            ],
            [
                'text'       => 'Facturas',
                'icon_color' => 'white',
                'icon'       => 'fas fa-fw fa-exclamation-triangle icon-separation-sidebar',
                'route'      => 'facturas.index',
                'active'     => ['facturas*'],
                'can'      => 'ver-facturas',
            ],

            [
                'text'       => 'Ingresos',
                'icon_color' => 'white',
                'icon'       => 'fas fa-fw fa-money-bill-alt icon-separation-sidebar',
                'route'      => 'ingresos.index',
                'active'     => ['ingresos*'],
                'can'      => 'ver-ingresos',
            ],

            [
                'text'       => 'Egresos',
                'icon_color' => 'white',
                'icon'       => 'fas fa-fw fa-money-bill-wave icon-separation-sidebar',
                'route'      => 'egresos.index',
                'active'     => ['egresos*'],
                'can'      => 'ver-egresos',
            ],

            [
                'text'       => 'Empleados',
                'icon_color' => 'white',
                'icon'       => 'fas fa-fw fa-users icon-separation-sidebar',
                'route'      => 'empleados.index',
                'active'     => ['empleados*'],
                'can'      => 'ver-empleados',
            ],
            [
                'text'       => ' Productos',
                'icon_color' => 'white',
                'icon'       => 'fas fa-fw fa-box',
                'route'      => 'productos.index',
                'active'     => ['productos*'],
                'can'      => '',
            ],
            [
                'text'       => ' ventas',
                'icon_color' => 'white',
                'icon'       => 'fas fa-fw fa-shopping-cart',
                'route'      => 'ventas.index',
                'active'     => ['ventas*'],
                'can'      => '',
            ],

            [
                'text'       => 'Reportes',
                'icon_color' => 'white',
                'icon'       => 'fas fa-fw fa-file-alt icon-separation-sidebar',
                'route'      => 'reportes.index',
                'active'     => ['reportes*'],
                'can'      => '',
              
            ],

            [
                'text'       => 'Finanzas',
                'icon_color' => 'white',
                'icon'       => 'fas fa-fw fa-chart-bar icon-separation-sidebar',
                'route'      => 'finanzas.index',
                'active'     => ['finanzas*'],
                'can'      => '',
               
            ],

           
                    [
                        'text'       => 'Usuarios',
                        'icon_color' => 'white',
                        'icon'       => 'fas fa-fw fa-users',
                        'route'      => 'usuarios.index',
                        'active'     => ['Usuarios*'],
                        'can'      => 'ver-usuarios',
                    ],
                    [
                        'text'       => 'Roles de usuarios',
                        'icon_color' => 'white',
                        'icon'       => 'fas fa-fw fa-user-lock',
                        'route'      => 'roles.index',
                        'active'     => ['roles*'],
                        'can'      => 'ver-roles',
                    ],
              
            
           
       
        ],
   

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
