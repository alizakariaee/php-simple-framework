<?php
namespace Request;

class json{


public function __construct(
    private $data = null
){

}

    public static function data($dataParam=null){
        $jsonData = file_get_contents('php://input');
        if(self::json_validator($jsonData)){
        $data = json_decode($jsonData, true);
        $ret = [];
        if(!is_null($dataParam)){
         foreach($dataParam as $k => $v){
            if(isset($data[$k])){
                $ret[$k] = array($data[$k],$v);
            }
         }
         $data = (new \Validation\DataSanitizer($ret))->getData();
        }
       }else{
        $data = json_decode([],true);
       }
        return new json($data);
    }



    public function getAll(): mixed
    {
       return $this->data;
    }

    public function get(string $k): mixed
    {
        retrun (isset($this->data[$k]))? $this->data[$k] : null;
    }

    public function __set ( string $name , mixed $value ) : void
    {
        $this->data[$name] = $value;
    }

    private static function json_validator($data) {
        if (!empty($data)) {
            @json_decode($data);
            return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
    }
}