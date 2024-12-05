<?php
namespace Validation;

class Rule{

    private ?array $pattern;
    
    public function __construct( private array $data )
        {
            $this->pattern = array_values($data);
        }


    public function generate() : mixed {
    $rules = [];       
        foreach($this->data as $k => $v){
         
            
            $rules[$k] = $this->makeRule($v[1]);
            
        }
        return $rules;
    }


    private function makeRule($rule_string){
        $rules = [];
        $ruleList = explode('|',$rule_string);
        foreach($ruleList as $rule){
            if(strstr($rule,':')){
               $rules[] = explode(':',$rule);
            }else{
               $rules[] = $rule;
            }
        }
        return $rules;
    }

}