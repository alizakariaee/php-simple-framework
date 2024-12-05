<?php
namespace Module;

use serviceInterface\User as userInterface;


final class userService implements userInterface {


    public function findById($id): mixed{
        if($id == 123){
            return ["username"=>"User1"];
        }
        return false;
    }
}