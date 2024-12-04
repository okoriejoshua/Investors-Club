<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

        'photos' => [
            'driver' => 'local',
            'root' => storage_path('app/public/photos'),
            'url' => env('APP_URL') . '/storage/photos',
            'visibility' => 'public',
        ],

        'investments' => [
            'driver' => 'local',
            'root' => storage_path('app/public/investments'),
            'url' => env('APP_URL') . '/storage/investments',
            'visibility' => 'public',
        ],
        'kyc' => [
            'driver' => 'local',
            'root' => storage_path('app/public/kyc'),
            'url' => env('APP_URL') . '/storage/kyc',
            'visibility' => 'public',
        ],
        'pops' => [
            'driver' => 'local',
            'root' => storage_path('app/public/pops'),
            'url' => env('APP_URL') . '/storage/pops',
            'visibility' => 'public',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
        public_path('storage/photos') => storage_path('app/public/photos'),
        public_path('storage/investments') => storage_path('app/public/investments'),
        public_path('storage/kyc') => storage_path('app/public/kyc'),
        public_path('storage/coins') => storage_path('app/public/coins'),
        public_path('storage/pops') => storage_path('app/public/pops'),
    ],

   

];
