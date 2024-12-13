<?php

namespace Http;

trait request
{


    public function httpQuery() {}


    public function httpParam() {}

    public function httpData($data = null): \Request\Body
    {
        return \Request\Body::data($data);
    }
}
