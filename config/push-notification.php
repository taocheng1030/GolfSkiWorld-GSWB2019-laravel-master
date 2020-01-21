<?php

return [

    'IOS'     => [
        'environment' => 'development',
        'certificate' => storage_path('certificates/apns.pem'),
        'passPhrase'  => 'password',
        'service'     => 'apns'
    ],

    'Android' => [
        'environment' => 'production',
        'apiKey'      => 'AIzaSyD18OuSihPxfUdqZ4bC5QQoZqjm6WJYOuQ',
        'service'     => 'gcm'
    ]

];