<?php

namespace Auth;

abstract class BaseGuard {


    public function verify(string $token){

        return \Request\Auth::Verify($token);

        /* if($result){
          return new \Request\User($result);
        }
        return false; */
    }
}
