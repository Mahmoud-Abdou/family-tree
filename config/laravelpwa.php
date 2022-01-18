<?php

return [
    'name' => 'Al Saheel',
    'manifest' => [
        'name' => 'Al Saheel',
        'short_name' => 'Al Saheel Family',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#3d85c6',
        'display' => 'fullscreen',
//        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> '#3d85c6',
//        'status_bar'=> 'black',
        'icons' => [
            '72x72' => [
                'path' => '/assets/icons/icon-72x72.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/assets/icons/icon-96x96.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/assets/icons/icon-128x128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/assets/icons/icon-144x144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/assets/icons/icon-152x152.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/assets/icons/icon-192x192.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/assets/icons/icon-384x384.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/assets/icons/icon-512x512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/assets/icons/splash-640x1136.png',
            '750x1334' => '/assets/icons/splash-750x1334.png',
            '828x1792' => '/assets/icons/splash-828x1792.png',
            '1125x2436' => '/assets/icons/splash-1125x2436.png',
            '1242x2208' => '/assets/icons/splash-1242x2208.png',
            '1242x2688' => '/assets/icons/splash-1242x2688.png',
            '1536x2048' => '/assets/icons/splash-1536x2048.png',
            '1668x2224' => '/assets/icons/splash-1668x2224.png',
            '1668x2388' => '/assets/icons/splash-1668x2388.png',
            '2048x2732' => '/assets/icons/splash-2048x2732.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Al Saheel',
                'description' => 'Al Saheel Family',
                'url' => '/app-link',
                'icons' => [
                    "src" => "/assets/icons/icon-72x72.png",
                    "purpose" => "any"
                ]
            ],
        ],
        'custom' => []
    ]
];
