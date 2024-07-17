<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */
    'admin_id' => 1,

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', true),
//    todo - для прод - заменить на false!!!

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */

//    стоковое:
//    'timezone' => env('APP_TIMEZONE', 'UTC'),
    'timezone' => 'Europe/Moscow',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

//    'locale' => 'ru',
//    'locales' => ['en', 'ru'],
//    'langs' => [
//        'ru' => 'Рус',
//        'en' => 'Eng',
//    ],

//    стоковые:
    'locale' => env('APP_LOCALE', 'ru'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'ru'),
    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],



    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],






    'roles' => [
        0 => 'Отключен',
        1 => 'Пользователь',
        100 => 'Администратор',
        777 => 'ВИП',

    ],

    //lang - account.acd_tx5
    'types' => [
        1 => 'Путешественник',
        2 => 'Организатор туров',
    ],
    //lang - travel.transport_categories
    'transport_categories' => [
        2 => 'Наземный',
        3 => 'Водный',
        4 => 'Воздушный',
        5 => 'Животные',

    ],
    //lang - travel.crt_vars1
    'transport_surfaces' => [
        10 => 'Автобан, автомагистраль',
        20 => 'Асфальтированная дорога',
        30 => 'Разбитая асфальтированная дорога',
        40 => 'Ровная грунтовая дорога',
        50 => 'Разбитая грунтовая дорога',
        60 => 'Бездорожье',
        70 => 'Бездорожье с бродами ',
        80 => 'Бездорожье с узкими участками ',
        90 => 'Бездорожье с узкими участками и бродами',
        100 => 'Скалы',
        110 => 'Скалы с грязью',
        120 => 'Скалы с узкими участками',
        130 => 'Скалы с бродами',
        140 => 'Скалы со снегом и льдом',
        150 => 'Снег, лед',
        160 => 'Водоем (река, озеро)',
        170 => 'Водоем с порогами, водопадами',
        180 => 'Водоем искусственный',
        190 => 'Водоем (океан, море)',
        200 => 'Пещеры, подземелья',
        210 => 'Велосипедная дорожка',
        220 => 'Тротуар',
        230 => 'Стадион',
        240 => 'Трек',
        250 => 'По воздуху',
        260 => 'Другое'
    ],

    'admins_telegram' => [
        '158130984',
        '1087260956'
    ],

    //lang - account.aci_tx5
    'genders' => [
        1 => 'Мужской',
        2 => 'Женский',
        3 => 'Другое',
    ],

    'messages_targets' => [
        1 => 'Событие',
        2 => 'Пользователь',
    ],

    'event_states' => [
        1 => 'Активное',
        2 => 'Отменено по просьбе пользователя',
        3 => 'Отменено администратором'
    ],

    'travel_states' => [
        1 => 'Активный',
        2 => 'Отключен по просьбе пользователя',
        3 => 'Отключен администратором'
    ],

    'admin_email' => 'info@green-course.com',

    'ratings' => [
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
    ],

    'page_bottom_positions' => [
        0 => 'Не показывать',
        1 => 'Колонка 1',
        2 => 'Колонка 2',
        3 => 'Колонка 3',
    ],

];
