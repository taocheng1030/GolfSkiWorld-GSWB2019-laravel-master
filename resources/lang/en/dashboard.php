<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dashboard Language Lines
    |--------------------------------------------------------------------------
    */

    'header' => [

        'notifications' => [
            'noMessages' => 'No messages',
            'total' => 'You have :total notification|You have :total notifications',
            'readAll' => 'Read all',
        ],

    ],

    'CRUD' => [

        'create' => [
            'success' => 'Successfully created!',
            'failed'  => '',
        ],

        'update' => [
            'success' => 'Successfully updated!',
            'failed'  => '',
        ],

        'delete' => [
            'success' => '',
            'failed'  => '',
            'confirm' => '<div>Would you delete this?</div><div class="text-warning">After deleting this, you can not recover.</div>',
        ],

    ],

    'notification' => [
        'push' => [
            'success' => '',
            'failed' => '',
            'confirm' => '<div>Would you push this notification?</div>'
        ]
    ],

    'photo' => [

        'thumbnail' => [
            'title' => 'Set as thumbnail',
            'confirm' => 'Are you sure you want to mark this photo as thumbnail?',
        ],

        'delete' => [
            'title' => 'Delete photo',
            'confirm' => 'Are you sure you want to delete this photo?',
        ],

    ],

    'video' => [

        'award' => [
            'title' => 'Award video',
            'confirm' => 'Are you sure you want to award this video?',
        ],

        'promo' => [
            'title' => 'Mark as promotional',
            'confirm' => 'Are you sure you want to mark this video as promotional?',
        ],

        'delete' => [
            'title' => 'Delete video',
            'confirm' => 'Are you sure you want to delete this video?',
        ],

        'forever' => [
            'title' => 'Delete video forever',
            'confirm' => '<div>Are you sure you want to delete forever this video?</div><div class="text-warning">After deleting this, you can not recover.</div>',
        ],

        'trash' => [
            'title' => 'Restore video',
            'confirm' => 'Are you sure you want to restore this video?',
        ],

        'tag' => [
            'title' => 'Assign tags',
        ],

    ],

];
