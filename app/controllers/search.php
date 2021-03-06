<?php

class Search extends Controller implements Handlers {
  
  protected $res;
  
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);        
        
    session_start();
            
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("ApiModel");    
  }
  
  public function name (string $query = null):void {
    $query = isset($_GET["search"])?$_GET["search"]:"";
    $token = isset($_GET["token"])?$_GET["token"]:"";
    
    $query = $this->get_model("ApiModel")->sanitize_str($query);
    $_SESSION["query"] = $query;
    
    # CSRF validation
    $is_valid = $this->get_model("ApiModel")->validate_form($token);
    
    if (!$is_valid) {
      $_SESSION["error"][] = "Invalid request";
      redirect("/#search-form");
    }
    
    $this->res = $this->get_model("ApiModel")->api_call($query);
    $this->res = json_decode($this->res);
    
    # If error is received from API
    if (isset($this->res->response) && $this->res->response == "error") {
      $_SESSION["error"][] = ucfirst($this->res->error);
      
      # If previous results were displayed, remove them
      if (isset($_SESSION["results"])) {
        unset($_SESSION["results"]);
      }
      redirect("/#search-form");
    }
    
    $_SESSION["results"] = $this->res->results;      
    redirect("/#search-form");
  }
    
  public function not_found():void {
    $_SESSION["error"][] = "Incorrect request";
    
    redirect("/#search-form");
  }
  
}

?>
