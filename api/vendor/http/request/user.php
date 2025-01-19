<?php
namespace Request;

class User{


public function __construct(
    private array $data = []
){

}


public function __get($name) {
    if (isset($this->data[$name])) {
        return $this->data[$name];
    }
    return null;
}


public function data(){
    return $this->data;
}


}