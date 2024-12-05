<?php
require_once('./bootstrap/bootstrap.php');



use Http\Routing;
use Module\userController as User;

Routing::Handler('findUser',[User::class,'find']);

Routing::Handler('updateUser',[User::class,'update']);
