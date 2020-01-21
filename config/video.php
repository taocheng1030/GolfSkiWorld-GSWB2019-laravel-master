<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Files per page on TV
    |--------------------------------------------------------------------------
    */

    'perPage' => env('VIDEO_FILES_PER_PAGE', 20),

    /*
    |--------------------------------------------------------------------------
    | Max size for uploaded files, in Mb
    |--------------------------------------------------------------------------
    */

    'max_size' => env('VIDEO_MAX_SIZE', 200) * 1024,

    /*
    |--------------------------------------------------------------------------
    | Max duration for uploaded files, in minutes
    |--------------------------------------------------------------------------
    */

    'max_duration' => env('VIDEO_MAX_DURATION', 1.5) * 60,

    /*
    |--------------------------------------------------------------------------
    | Duration for cropping uploaded files, in seconds
    |--------------------------------------------------------------------------
    */

    'duration' => env('VIDEO_DURATION', 60),

    /*
    |--------------------------------------------------------------------------
    | Thumbnail settings
    |--------------------------------------------------------------------------
    | frame  - Time for make thumbnail, in seconds
    | suffix - Suffix and ext for thumbnail file
    |--------------------------------------------------------------------------
    */

    'thumbnail' => [
        'frame'  => env('VIDEO_THUMBNAIL', 15),
        'suffix' => 'thumb.jpg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Approved mime types for uploaded files
    |--------------------------------------------------------------------------
    */

    'mimeTypes' => 'video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv',

    /*
    |--------------------------------------------------------------------------
    | X264 format
    |--------------------------------------------------------------------------
    */

    'x264' => [
        'audio' => 'libfdk_aac',
        'video' => 'libx264',
        'extension' => 'mp4',
    ],

    /*
    |--------------------------------------------------------------------------
    | Subject for mail after upload
    |--------------------------------------------------------------------------
    */

    'subject' => [
        'success' => 'Your video file has been uploaded',
        'failed'  => 'Uploading video file is failed',
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    */

    'from' => [
        'address' => 'upload@example.com',
        'name' => 'GolfSkiWorld file system'
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue params
    | attempts - count of attempts of encode, after which the file is deleted from the queue
    |--------------------------------------------------------------------------
    */

    'queue' => [
        'attempts' => env('VIDEO_ENCODE_ATTEMPTS', 3),
        'folder' => 'queue',
    ],

];
