<?php

class Search extends Controller implements Handlers {
  
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);        
        
    session_start();
            
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("ApiModel");    
  }
  
  public function name ($name = null) {
    
  }
    
  public function not_found() {
    $_SESSION["error"][] = "Incorrect request";
    
    redirect("/");
  }
  
}

?>