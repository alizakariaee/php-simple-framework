<?php
$delimiter = '/';
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
$delimiter = '\\';
}
spl_autoload_register(function ($class) use($delimiter) {

   $class     = strtolower($class);
   $class_dir = str_replace('\\', $delimiter, $class);
   $dir_list  = explode($delimiter,$class_dir);
   $dir_list  = array_filter($dir_list);

   $namespace_dir = '';
   $class_file = '';
   
   if($dir_list[0] == 'controllerinterface'){
   $namespace_dir = 'interface'.$delimiter.'controllers';
   $class_file = strtolower($dir_list[1]).'.interface';
   }
   
   if($dir_list[0] == 'serviceinterface'){
   $namespace_dir = 'interface'.$delimiter.'services';
   $class_file = strtolower($dir_list[1]).'.interface';
   }

   if($dir_list[0] == 'module'){
    $controller = stristr($dir_list[1],'Controller',true);
    if($controller){
    $controller = strtolower($controller);
    $namespace_dir = 'modules'.$delimiter.$controller;
    $class_file = $controller.'.controller';
    }else{

     $service = stristr($dir_list[1],'Service',true);
     if($service){
     $service = strtolower($service);
     $namespace_dir = 'modules'.$delimiter.$service;
     $class_file = $service.'.service';   
     }else{

        $model = stristr($dir_list[1],'Model',true);
        if($model){
        $model = strtolower($model);
        $namespace_dir = 'modules'.$delimiter.$model;
        $class_file = $model.'.model';   
        }

     }


    }
    }

    if($dir_list[0] == 'http'){
        $namespace_dir = 'vendor'.$delimiter.'http';
        $class_file    = $dir_list[1];
    }

    if($dir_list[0] == 'request'){
        $namespace_dir = 'vendor'.$delimiter.'http'.$delimiter.'request';
        $class_file    = $dir_list[1];
    }

    if($dir_list[0] == 'validation'){
        $namespace_dir = 'vendor'.$delimiter.'http'.$delimiter.'validation';
        $class_file    = $dir_list[1];
    }

    if($dir_list[0] == 'guards'){
        $namespace_dir = 'guards'.$delimiter.str_replace('guard','',str_replace('Permissions','',$dir_list[1]));
        $class_file = $dir_list[1];
    }
    

    $correct_dir = str_replace($delimiter.'bootstrap','',__DIR__);

    $file = $correct_dir .$delimiter. $namespace_dir .$delimiter. $class_file . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});