<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'imagick',
    'allow_sizes' => [
        'thumbnail' => [
            'width' => env('THUMBNAIL_WIDTH', 220),
            'height' => env('THUMBNAIL_HEIGHT', null),
            'quality' => 65
        ],
        'medium' => [
            'width' => env('MEDIUM_WIDTH', 500),
            'height' => env('MEDIUM_HEIGHT', null),
            'quality' => 70
        ]
    ],
];
