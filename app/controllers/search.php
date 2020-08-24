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
    
    $_SESSION["query"] = $query;
    
    # CSRF validation
    $is_valid = $this->get_model("ApiModel")->validate_form($token);
    
    if (!$is_valid) {
      $_SESSION["error"][] = "Invalid request";
      redirect("/");
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
      redirect("/");
    }
    
    $_SESSION["results"] = $this->res->results;      
    redirect("/");
  }
    
  public function not_found():string {
    $_SESSION["error"][] = "Incorrect request";
    
    redirect("/");
  }
  
}

?>