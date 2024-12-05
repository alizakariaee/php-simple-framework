<?php
namespace Validation;

class DataSanitizer{

    private ?array $rules;

    public function __construct(
        private array $data
    ){
    
        $this->rules = (new Rule($data))->generate();

    }


    public function getData() : mixed
    {

        $filteredData = new Validator(arrayFlat($this->data),$this->rules);
        return $filteredData->onlyValidData();
    }

}