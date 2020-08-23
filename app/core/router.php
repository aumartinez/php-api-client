<?php

class Router {
  
  # Initial states
  protected $default_controller = DEFAULT_CONTROLLER;
  protected $default_method = DEFAULT_METHOD;
  protected $params = array();

  # Route handler method
  public function route($url) {
        
    # Split url using "/" as separator
    $url_array = array();
    $url_array = explode("/", trim($url, "/"));
              
    # Remove app folder value
    if(in_array(PATH, $url_array)){
      while ($url_array[0] != PATH) {        
        array_shift($url_array);
      }
      
      array_shift($url_array);
    }
            
    # If any, pass the corresponding controller, method and parameters
    if (isset($url_array[0])){
      # Extract parameters
      $str = array_shift($url_array);      
      $ind = strpos($str, "?");      
      $str = $ind ? substr($str, 0, $ind): $str;
      
      $controller = $str;
    }
    else {
      $controller = "";
    }
            
    if (isset($url_array[0])){
      # Extract parameters
      $str = array_shift($url_array);      
      $ind = strpos($str, "?");
      $str = $ind ? substr($str, 0, $ind): $str;
      
      $method = $str;
    }
    else {
      $method = "";
    }    
    
    # Pull URL query parameters if any
    $this->params = $url_array;
                                
    # If controller is not found or not exists as a class handler
    # set default controller and not found method
    if (empty($controller)) {
      $controller = $this->default_controller;
      $method = $this->default_method;
    }
    else if (!is_controller($controller) || !class_exists($controller)) {
      $controller = $this->default_controller;      
      $method = NOT_FOUND;
    }
        
    if (empty($method)) {
      $method = $this->default_method;
    }    

    # If hyphens are used in methods turn them into valid controller and method name
    $controller = snake_case($controller);
    $method = snake_case($method);    
        
    # Instantiate controller class and call to appropriate method
    $controller_name = $controller;
    $controller = ucfirst($controller);
    $dispatch = new $controller($controller_name, $method);
        
    if (method_exists($controller, $method)) {
      call_user_func_array(array($dispatch, $method), $this->params);
    }
    else {
      # Error handler not found method
      call_user_func_array(array($dispatch, NOT_FOUND), $this->params);
    }
    
  }  
}

?>
