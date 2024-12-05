<?php
namespace serviceInterface;

interface User{
    public function findById(int $id): mixed;

}