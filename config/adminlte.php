<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Nightlife',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => "<b>NightLife</b>",

    'logo_mini' => "<b>N</b>LF",

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | light variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'purple',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => 'fixed',

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => '/',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and a URL. You can also specify an icon from Font
    | Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    */

    'menu' => [
        [
            'header'    => 'GERERENCIAMENTO PRINCIPAL',
            'can'       => 'manage-establishment'
        ],
        [
            'text'      => 'Gerenciar Estabelecimento',
            'icon'      => 'fas fa-warehouse',
            'can'       => 'manage-establishment',
            'submenu'   => [
                [
                    'text'      => 'Categoria',
                    'icon'      => 'fas fa-list-ul',
                    'route'     => 'category.index',
                    'active'    => ['category', 'category/*', 'category?*']
                ],
                [
                    'text'      => 'Endereços',
                    'icon'      => 'fas fa-map-marked-alt',
                    'route'     => 'establishmentAddress.prepareIndex',
                    'active'    => ['establishmentAddress', 'establishmentAddress/*', 'establishmentAddress?*']
                ],
                [
                    'text'      => 'Estabelecimento',
                    'icon'      => 'far fa-building',
                    'route'     => 'establishment.index',
                    'active'    => ['establishment', 'establishment/*', 'establishment?*'],
                ],
                [
                    'text'      => 'Ritmo Musical',
                    'icon'      => 'fas fa-music',
                    'route'     => 'rhythm.index',
                    'active'    => ['rhythm', 'rhythm/*', 'rhythm?*']
                ],
//                [
//                    'text'  => 'Faturas',
//                    'url'   => '#',
//                    'icon'  => 'fas fa-file-invoice-dollar'
//                ],
            ],
        ],
        [
            'text'      => 'Gerenciar Usuários',
            'icon'      => 'fas fa-users',
            'can'       => 'manage-users',
            'submenu'   => [
                [
                    'text'      => 'Usuários',
                    'icon'      => 'fas fa-users',
                    'active'    => ['user', 'user/*', 'user?*'],
                    'route'     => 'user.index',
                ],
                [
                    'text'      => 'Permissões',
                    'active'    => ['permission', 'permission/*', 'permission?*'],
                    'route'     => 'permission.index',
                    'icon'      => 'fas fa-user-shield',
                ],
                [
                    'text'      => 'Funções',
                    'active'    => ['role', 'role/*', 'role?*'],
                    'route'     => 'role.index',
                    'icon'      => 'fas fa-cog',
                ],
            ],
        ],
        [
            'header'    => 'ATENDIMENTO ESTABELECIMENTO',
            //'can'     => 'WorkerPolicy'
        ],
        [
            'text'      => 'Chamados',
            'url'       => 'admin/pages',
            'active'    => ['roles', 'roles/*', 'roles?*'],
            'icon'      => 'fas fa-phone-volume',
            //'can'     => 'WorkerPolicy'
        ],
        [
            'header'    => 'GERENCIAMENTO DE ESTABELECIMENTO',
            'can'       => 'establishment-manager',
            'can'       => 'manage-establishment'
        ],
        [
            'text'      => 'Dashboard',
            'url'       => 'admin/settings',
            'icon'      => 'fas fa-chart-line',
//            'can'       => 'manage-establishment'
        ],
        [
            'text'      => 'Eventos',
            'icon'      => 'far fa-calendar-alt',
            'route'     => 'event.prepareIndex',
            'active'    => ['event', 'event/*', 'event?*']
            //'can'     => 'EstablishmentPolicy'
        ],
        [
            'text'      => 'Chamados',
            'url'       => 'admin/settings',
            'icon'      => 'fas fa-phone-alt',
            //'can'     => 'EstablishmentPolicy'
        ],
        [
            'text'      => 'Configurações',
            'icon'      => 'fas fa-cog',
            //'can'     => 'EstablishmentPolicy'
            'submenu'   => [
                [
                    'text'      => 'Configurações Perfil',
                    'url'       => '#',
                    'icon'      => 'far fa-list-alt',
                ],
                [
                    'text'      => 'Fotos Perfil',
                    'url'       => '#',
                    'icon'      => 'fas fa-images',
                ],
                [
                    'text'          => 'Detalhes Conta',
                    'url'           => '#',
                    'icon'          => 'fas fa-info-circle',
                    'icon_color'    => 'red',
                ],
                [
                    'text'      => 'Mudar Senha',
                    'url'       => '#',
                    'icon'      => 'fas fa-key'
                ],
            ],
        ],
        [
            'text'      => 'Relatórios',
            'url'       => '#',
            'icon'      => 'far fa-file-alt',
            //'can'     => 'EstablishmentPolicy'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Configure which JavaScript plugins should be included. At this moment,
    | DataTables, Select2, Chartjs and SweetAlert are added out-of-the-box,
    | including the Javascript and CSS files from a CDN via script and link tag.
    | Plugin Name, active status and files array (even empty) are required.
    | Files, when added, need to have type (js or css), asset (true or false) and location (string).
    | When asset is set to true, the location will be output using asset() function.
    |
    */

    'plugins' => [
        [
            'name' => 'Datatables',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css',
                ],
            ],
        ],
        [
            'name' => 'Select2',
            'active' => true,
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
        [
            'name' => 'Chartjs',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        [
            'name' => 'Sweetalert2',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//unpkg.com/sweetalert/dist/sweetalert.min.js',
                ],
            ],
        ],
        [
            'name' => 'Pace',
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
];
