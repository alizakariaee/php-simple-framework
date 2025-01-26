<?php
namespace Http;

abstract class Routing extends Http{

    public static function Handler(string $route,array $module): mixed {
      if(isset($_GET['module']) && !empty($_GET['module']) && trim(strtolower($_GET['module'])) == trim(strtolower($route))){

    [$className, $methodName] = $module;
    $reflectionClass = new \ReflectionClass($className::class);
    $reflectionMethod = new \ReflectionMethod($className,$methodName);

    
    $parameters = $reflectionMethod->getParameters();
    
    $queryParams = [];
    foreach ($parameters as $parameter) {
        $paramName = $parameter->getName();
        $paramType = $parameter->getType();
        
        if(isset($_GET[$paramName])){
        $queryParams[$paramName] = $_GET[$paramName];
        }else if($paramType && !$paramType->isBuiltin()){
        //$paramType = ($paramType instanceof ReflectionNamedType) ? $paramType->getName() : "Mixed";
        $defaultValue = $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null; 
        if($paramType == 'Request\Body'){
          $queryParams[$paramName]  = call_user_func([\Request\Body::class,'data'],$defaultValue);
        }else if($paramType == 'Request\Json'){
          $queryParams[$paramName]  = call_user_func([\Request\Json::class,'data'],$defaultValue);
        }else if($paramType == 'Request\Headers'){
          $queryParams[$paramName] = new \Request\Headers();
        }
        }
    }    


    $classAttributes = $reflectionClass->getAttributes(\Auth\UseGuard::class);
    foreach ($classAttributes as $attribute) {
        $guardClass = $attribute->newInstance();
        $guardName = $guardClass->guardName;
        $className = '\\Guards\\' . $guardName . 'Guard';
        $guard = new $className();
        $userObj = $guard->verify(\Request\Headers::Authorization()->Bearer());
        if($userObj){

        }

    }   

    if ($reflectionMethod->isStatic()) {
        return call_user_func_array([$className, $methodName], $queryParams);
    }

    $object = new $className();
    return call_user_func_array([$object, $methodName], $queryParams);


      }
      return false;
    }

    
    
    public static function Post(string $route,array $module): mixed 
    {
      if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        return self::Handler($route,$module);
      }
      return false;
    }



    public static function Put(string $route,array $module): mixed 
    {
      if ($_SERVER['REQUEST_METHOD'] === 'PUT'){
        return self::Handler($route,$module);
      }
      return false;
    }

}