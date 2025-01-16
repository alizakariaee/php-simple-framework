<?php

namespace Request;

class Headers{

   public private(set) mixed $authorization = '';

    public function __construct(){
     $this->authorization = $this->header_authorization();
    }

    public static function authorization() : mixed {
        return (new self())->header_authorization();
    }

    private function header_authorization() : mixed
    {
       $ret = new \myStdClass();
       $jwt = '';
       $basic = '';
       $apiKey = '';
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
            if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $jwt = $matches[1];
            }
            if (preg_match('/Basic\s(\S+)/', $authHeader, $matches)) {
                $basic = $matches[1];
            }
            if (preg_match('/ApiKey\s(\S+)/', $authHeader, $matches)) {
                $apiKey = $matches[1];
            }

        }


        $ret->Bearer = fn() : string => $jwt;
        $ret->Basic  = fn() : string => $basic;
        $ret->ApiKey = fn() : string => $apiKey;

        return $ret;
    }
}