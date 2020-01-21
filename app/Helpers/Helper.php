<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\Routing\UrlGenerator;

if (!function_exists('ddd')) {
    function ddd($var)
    {
        print_r($var);
        die();
    }
}

if (! function_exists('adminUrl')) {
    /**
     * Generate a url for the application.
     *
     * @param  string  $path
     * @param  mixed   $parameters
     * @param  bool    $secure
     * @return Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function adminUrl($path = null, $parameters = [], $secure = null)
    {
        if (is_null($path)) {
            return app(UrlGenerator::class);
        }

        $prefix = env('PATH_TO_ADMIN', 'admin');
        $path = ($prefix) ? $prefix . DIRECTORY_SEPARATOR . $path : $path;

        return app(UrlGenerator::class)->to($path, $parameters, $secure);
    }
}

if (! function_exists('logSQL')) {
    /**
     * Save all SQL queries to log file
     * Just add this function to __construct() method
     *
     * @param $ClassName
     */
    function logSQL($ClassName = null)
    {
        global $fileName;

        $ClassName = $ClassName ? $ClassName . '_' : $ClassName;

        $fileName = storage_path('logs' . DIRECTORY_SEPARATOR . $ClassName . date('Y-m-d') . '_query.log');

        $logFile = fopen($fileName, 'a+');
        fwrite($logFile, PHP_EOL .'========================='.date('H:i:s').'========================='. PHP_EOL);
        fclose($logFile);

        if (substr(sprintf('%o', fileperms($fileName)), -4) != '0666') {
            chmod($fileName, 0666);
        }

        DB::listen(
            function ($sql) {
                // $sql is an object with the properties:
                //  sql: The query
                //  bindings: the sql query variables
                //  time: The execution time for the query
                //  connectionName: The name of the connection

                // To save the executed queries to file:
                // Process the sql and the bindings:
                foreach ($sql->bindings as $i => $binding) {
                    if ($binding instanceof \DateTime) {
                        $sql->bindings[$i] = $binding->format('H:i:s');
                    } else {
                        if (is_string($binding)) {
                            $sql->bindings[$i] = "'$binding'";
                        }
                    }
                }

                // Insert bindings into query
                $query = str_replace(array('%', '?'), array('%%', '%s'), $sql->sql);

                $query = vsprintf($query, $sql->bindings);

                // Save the query to file
                global $fileName;
                $logFile = fopen($fileName, 'a+');
                fwrite($logFile, date('H:i:s') . ' | ' . $query . PHP_EOL);
                fclose($logFile);
            }
        );
    }
}

if (!function_exists('UUID')) {
    /**
     * Generate UUID string.
     *
     * @return string
     */
    function UUID()
    {
        $uuid = array(
            'time_low'  => 0,
            'time_mid'  => 0,
            'time_hi'  => 0,
            'clock_seq_hi' => 0,
            'clock_seq_low' => 0,
            'node'   => array()
        );

        $uuid['time_low'] = mt_rand(0, 0xffff) + (mt_rand(0, 0xffff) << 16);
        $uuid['time_mid'] = mt_rand(0, 0xffff);
        $uuid['time_hi'] = (4 << 12) | (mt_rand(0, 0x1000));
        $uuid['clock_seq_hi'] = (1 << 7) | (mt_rand(0, 128));
        $uuid['clock_seq_low'] = mt_rand(0, 255);

        for ($i = 0; $i < 6; $i++) {
            $uuid['node'][$i] = mt_rand(0, 255);
        }

        $uuid = sprintf('%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
            $uuid['time_low'],
            $uuid['time_mid'],
            $uuid['time_hi'],
            $uuid['clock_seq_hi'],
            $uuid['clock_seq_low'],
            $uuid['node'][0],
            $uuid['node'][1],
            $uuid['node'][2],
            $uuid['node'][3],
            $uuid['node'][4],
            $uuid['node'][5]
        );

        return $uuid;
    }
}

if (!function_exists('msDate')) {
    /**
     * Generate Date string with microseconds.
     *
     * @param string $format
     * @param string $divider
     * @return string
     */
    function msDate($format = 'Y-m-d.H-i-s', $divider = '.')
    {
        $mt = microtime(true);
        $micro = sprintf("%06d",($mt - floor($mt)) * 1000000);
        return date($format, time()) . $divider . $micro;
    }
}

if (!function_exists('statusTrue')) {
    function statusTrue($array = []) {
        return array_merge(['status' => true], $array);
    }
}

if (!function_exists('statusFalse')) {
    function statusFalse($array = []) {
        return array_merge(['status' => false], $array);
    }
}

if (!function_exists('filterSelected')) {
    function filterSelected($name, $field) {
        $input = Input::get($name);
        return isset($input[$field]) ? $input[$field] : null;
    }
}

if (!function_exists('array_exist')) {
    function array_exist($array, $key, $default = null) {
        return isset($array[$key]) ? $array[$key] : $default;
    }
}

if (!function_exists('object_exist')) {
    function object_exist($object, $key, $default = null) {
        return (isset($object) && $object->$key) ? $object->$key : $default;
    }
}

if (!function_exists('mailTo')) {
    function mailTo($item) {
        return ($item) ? HTML::mailto($item) : null;
    }
}