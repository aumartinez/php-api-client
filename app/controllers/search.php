<?php

class Search extends Controller implements Handlers {
  
  protected $res;
  
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);        
        
    session_start();
            
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("ApiModel");    
  }
  
  public function name ($query = null) {
    $query = isset($_GET["search"])?$_GET["search"]:"";
    $token = isset($_GET["token"])?$_GET["token"]:"";
    
    $_SESSION["query"] = $query;
    
    $is_valid = $this->get_model("ApiModel")->validate_form($token);
    
    if (!$is_valid) {
      $_SESSION["error"][] = "Invalid request";
      redirect("/");
    }
    
    $this->res = $this->get_model("ApiModel")->api_call($query);
    $this->res = json_decode($this->res);
    
    $_SESSION["results"] = $this->res;
    
    redirect("/");
  }
  
  public function id($id = null) {
    $id = isset($_GET["id"])?$_GET["id"]:"";
    
    if (empty(trim($id))) {
      $this->not_found();
    }
    
  }
    
  public function not_found() {
    $_SESSION["error"][] = "Incorrect request";
    
    redirect("/");
  }
  
}

?>