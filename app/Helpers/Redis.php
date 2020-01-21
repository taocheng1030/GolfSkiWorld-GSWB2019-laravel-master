<?php

/*
* Redis helper
*/

if (!function_exists('publish_notification')) {
    function publish_notification($data) {
        Redis::publish('notification', json_encode($data));
    }
}