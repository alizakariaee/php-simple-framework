<?php
namespace controllerInterface;
use Request\Body;
use Request\Json;
interface User{
    public function find(int $id): mixed;
    public function login(Body $data): mixed;
    public function update(Json $data, int $id): mixed;

}