<?php

function arrayFlat($array,$valueLevel=1){
    array_walk($array,function (&$value,$key,$level)
    {
    $value=$value[$level];
    },--$valueLevel);
    return $array;
}


function env($key, $default = null) {
    static $env = null;

    if ($env === null) {
        $env = [];
        $lines = file('../.env');

        foreach ($lines as $line) {
            $line = trim($line);

            if (empty($line) || $line[0] == '#') {
                continue;
            }

            list($keyItem, $value) = explode('=', $line, 2);
            $value = trim($value, '"');
            $value = trim($value, '\'');
            $env[trim($keyItem)] = $value;
        }
    }

    return $env[$key] ?? $default;
}


function convertToSeconds($timeStr) {
    $seconds = 0;

    if (preg_match('/(\d+)([dhmsw])/', $timeStr, $matches)) {
        $value = (int)$matches[1];
             $unit = $matches[2];
        switch ($unit) {
            case 'w':
             $seconds = $value * (86400 * 7);
            break;
            case 'd':
                $seconds = $value * 86400;
                break;
            case 'h':
                $seconds = $value * 3600;
                break;
            case 'm':
                $seconds = $value * 60;
                break;
            case 's':
                $seconds = $value;
                break;
        }
    }

    return time() + $seconds;
}