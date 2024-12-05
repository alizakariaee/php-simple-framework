<?php
namespace Http;

abstract class Routing extends Http{

    public static function Handler(string $route,array $module): mixed {
      if(isset($_GET['module']) && !empty($_GET['module']) && trim(strtolower($_GET['module'])) == trim(strtolower($route))){

    [$className, $methodName] = $module;
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

        }else if($paramType == 'Request\Json'){
          $queryParams[$paramName]  = call_user_func([\Request\Json::class,'data'],$defaultValue);
        }
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
}