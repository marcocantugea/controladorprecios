<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'canalesventa'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => env('DB_PREFIX', ''),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', 3306),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_PREFIX', ''),
            'strict' => env('DB_STRICT_MODE', true),
            'engine' => env('DB_ENGINE'),
            'timezone' => env('DB_TIMEZONE', '+00:00'),
        ],

        'users' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_USERS', '127.0.0.1'),
            'port' => env('DB_PORT_USERS', 3306),
            'database' => env('DB_DATABASE_USERS', 'forge'),
            'username' => env('DB_USERNAME_USERS', 'forge'),
            'password' => env('DB_PASSWORD_USERS', ''),
            'unix_socket' => env('DB_SOCKET_USERS', ''),
            'charset' => env('DB_CHARSET_USERS', 'utf8mb4'),
            'collation' => env('DB_COLLATION_USERS', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_PREFIX_USERS', ''),
            'strict' => env('DB_STRICT_MODE_USERS', true),
            'engine' => env('DB_ENGINE_USERS'),
            'timezone' => env('DB_TIMEZONE_USERS', '+00:00'),
        ],

        'productos' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_PRODUCTOS', '127.0.0.1'),
            'port' => env('DB_PORT_PRODUCTOS', 3306),
            'database' => env('DB_DATABASE_PRODUCTOS', 'forge'),
            'username' => env('DB_USERNAME_PRODUCTOS', 'forge'),
            'password' => env('DB_PASSWORD_PRODUCTOS', ''),
            'unix_socket' => env('DB_SOCKET_PRODUCTOS', ''),
            'charset' => env('DB_CHARSET_PRODUCTOS', 'utf8mb4'),
            'collation' => env('DB_COLLATION_PRODUCTOS', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_PREFIX_PRODUCTOS', ''),
            'strict' => env('DB_STRICT_MODE_PRODUCTOS', true),
            'engine' => env('DB_ENGINE_PRODUCTOS'),
            'timezone' => env('DB_TIMEZONE_PRODUCTOS', '+00:00'),
        ],

        'canalesventa' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_CANALESVENTA', '127.0.0.1'),
            'port' => env('DB_PORT_CANALESVENTA', 3306),
            'database' => env('DB_DATABASE_CANALESVENTA', 'forge'),
            'username' => env('DB_USERNAME_CANALESVENTA', 'forge'),
            'password' => env('DB_PASSWORD_CANALESVENTA', ''),
            'unix_socket' => env('DB_SOCKET_CANALESVENTA', ''),
            'charset' => env('DB_CHARSET_CANALESVENTA', 'utf8mb4'),
            'collation' => env('DB_COLLATION_CANALESVENTA', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_PREFIX_CANALESVENTA', ''),
            'strict' => env('DB_STRICT_MODE_CANALESVENTA', true),
            'engine' => env('DB_ENGINE_CANALESVENTA'),
            'timezone' => env('DB_TIMEZONE_CANALESVENTA', '+00:00'),
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', 5432),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => env('DB_PREFIX', ''),
            'search_path' => env('DB_SCHEMA', 'public'),
            'sslmode' => env('DB_SSL_MODE', 'prefer'),
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', 1433),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => env('DB_PREFIX', ''),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            //'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'lumen'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
