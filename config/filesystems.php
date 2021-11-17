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
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID', 'AKIAZZ6PVMKG2U4CCYMF'),
            'secret' => env('AWS_SECRET_ACCESS_KEY', '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'),
            'region' => env('AWS_DEFAULT_REGION', 'ap-northeast-2'),
            'bucket' => env('AWS_BUCKET', 'bucket-market-dev-private'),
            'token' => env('AWS_TOKEN', ''),
            'expiration' => env('AWS_EXPIRATION', ''),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'url_bucket' => env('AWS_URL_BUCKET', 'https://s3.ap-northeast-2.amazonaws.com/bucket-market-dev-private'),
            'url_cloudfront' => env('AWS_URL_CLOUDFRONT', 'https://d2tsr9h9qf61nl.cloudfront.net')
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
    ],

];
