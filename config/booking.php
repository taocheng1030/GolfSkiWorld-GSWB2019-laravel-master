<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Subject for booking mail
    |--------------------------------------------------------------------------
    */

    'subject' => [
        'user'  => 'You just made a booking of last minute deal',
        'admin' => 'A GolfSkiWorld user just made a booking of the deal',
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    */

    'from' => [
        'name'    => 'Booking department',
        'address' => 'booking.system@example.com',
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "To" Address
    |--------------------------------------------------------------------------
    */

    'to' => [
        'name'    => 'Booking manager',
        'address' => 'booking.manager@example.com',
    ],

    /*
    |--------------------------------------------------------------------------
    | Setting for push notification with reminder about his adventure starts
    | time - days till
    |--------------------------------------------------------------------------
    */

    'reminder' => [
        'time' => 3
    ],

    /*
    |--------------------------------------------------------------------------
    | Timeout for queue
    |--------------------------------------------------------------------------
    */

    'queue' => [
        'name' => 'booking',
        'time' => 5
    ],
];
