<?php

return [

    'vision_api' => [
        'enabled' => env('VISION_API_ENABLED', true),
        'url'     => env('VISION_API_URL'),
        'key'     => env('VISION_API_KEY'),
        'language_hints' => ['dv']
    ],

];
