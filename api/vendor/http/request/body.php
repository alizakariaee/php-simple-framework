<?php

namespace Request;

class Body
{

    public function __construct(
        private $data = null
    ) {}

    public static function data($dataParam = null): \Request\Body
    {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            parse_str(file_get_contents("php://input"), $data);
        } else {
            $data = $_POST;
        }

        $ret = [];
        if (!is_null($dataParam)) {
            foreach ($dataParam as $k => $v) {
                if (isset($data[$k])) {
                    $ret[$k] = array($data[$k], $v);
                }
            }
            $data = (new \Validation\DataSanitizer($ret))->getData();
        }

        return new Body($data);
    }



    public function getAll(): mixed
    {
        return $this->data;
    }

    public function get(string $k): mixed
    {
        retrun(isset($this->data[$k])) ? $this->data[$k] : null;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->data[$name] = $value;
    }
}
