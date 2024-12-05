<?php
namespace Validation;

class Validator{

    private array $validate_data = [];
    private array $inValidate_data = [];
    private $test;

    public function __construct(
        private array $data,
        private array $rule
    ){
     $this->validation();
    }


    private function validation()
    {
      foreach($this->data as $k => $v){
        if(isset($this->rule[$k])){
            $invalidData = false;
            foreach($this->rule[$k] as $rule){
             $param2 = null;
             if(is_array($rule)){
             $param2 = $rule[1];
             $rule   = $rule[0];
             }
             if(is_callable([$this,$rule])){
             
             if(!call_user_func_array([$this,$rule],[$v,$param2])){
                $invalidData = true;
             }
             
             }
             
            }
            if(!$invalidData){
                $this->validate_data[$k]   = $v;
            }else{
                $this->inValidate_data[$k] = $v;
            }
        }else{
            $this->validate_data[$k] = $v;
        }
      }
    }

    public function onlyValidData() : array
    {
        return $this->validate_data;
    }

    public function getAll() : array
    {
      return array_merge($this->validate_data,$this->inValidate_data);
    }




    private function string($value){
     return is_string($value);
    }

    private function number($value){
     return is_numeric($value);
    }

    private function max($value,$limit){
        return (strlen($value) <= $limit);
    }

    private function min($value,$limit){
        return (strlen($value) >= $limit);
    }

    private function int($value){
        return (is_numeric($value) && intval($value));
    }
}