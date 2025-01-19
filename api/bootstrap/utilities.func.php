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