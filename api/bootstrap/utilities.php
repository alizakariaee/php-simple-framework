<?php

function arrayFlat($array,$valueLevel=1){
    array_walk($array,function (&$value,$key,$level)
    {
    $value=$value[$level];
    },--$valueLevel);
    return $array;
}