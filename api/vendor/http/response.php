<?php
namespace Http;

trait response{
    

    public function json($data): mixed {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function end($data){
        header('Content-Type: text/html; charset=UTF-8');
        echo $data;
    }
}