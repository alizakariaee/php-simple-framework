<?php

trait Facade{

    public function __call( $method, $arguments )
  {
    //$method = 'set' . ucfirst( $name ) . 'Attribute';
    $method = strtolower($method);
    if ( method_exists( $this, $method ) ) {
      return call_user_func_array( [ $this, $method ], $arguments );
    }
  }
 
  public static function __callStatic( $method, $arguments )
  {
    $instance = new static();
 
    //$method = 'set' . ucfirst( $name ) . 'Attribute';
    $method = strtolower($method);
    if ( method_exists( $instance, $method ) ) {
      return call_user_func_array( [ $instance, $method ], $arguments );
    }
  }

  public function args_with_keys( array $args, $class = null, $method = null, $includeOptional = false )
  {
      if ( is_null( $class ) || is_null( $method ) )
      {
          $trace = debug_backtrace()[1];
  
          $class = $trace['class'];
          $method = $trace['function'];
      }
  
      $reflection = new \ReflectionMethod( $class, $method );
  
      if ( count( $args ) < $reflection->getNumberOfRequiredParameters() )
          throw new \RuntimeException( "Something went wrong! We had less than the required number of parameters." );
  
      foreach ( $reflection->getParameters() as $param )
      {
          if ( isset( $args[$param->getPosition()] ) )
          {
              $args[$param->getName()] = $args[$param->getPosition()];
              unset( $args[$param->getPosition()] );
          }
          else if ( $includeOptional && $param->isOptional() )
          {
              $args[$param->getName()] = $param->getDefaultValue();
          }
      }
  
      return $args;
  }
}