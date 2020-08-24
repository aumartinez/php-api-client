<?php

class Details extends Search implements Handlers {
  
  protected $output;
  protected $results;
  
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);
            
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("PageModel");
    $this->load_model("ApiModel");
    
    # Instantiate custom view output
    $this->output = new PageView();
    $this->results = new ResultsView();
    
    $id = $this->method;
    
    $this->get_page_id($id);
  }
    
  public function get_page_id($id) {    
    # CSRF hash
    if (empty($_SESSION["token"]) || !isset($_SESSION["token"])) {
        $_SESSION["token"] = bin2hex(random_bytes(32));
    }
    
    $query = isset($_SESSION["query"])? $_SESSION["query"]:"";
    
    $src = $this->get_model("ApiModel")->get_idcall($id);
    $src = json_decode($src);
        
    if (!$src) {
      # 404 page
      $this->get_model("PageModel")->page_title = "Not found";
      $this->build_page("not-found");
      exit();
    }
    
    if (isset($src->error) && $src->error == "invalid id") {
      # 404 page
      $this->get_model("PageModel")->page_title = "Not found";
      $this->build_page("not-found");
      exit();
    }
    
    if ($src) {
      $res = $this->results->get_pageid($src);      
    }
    else {
      $res = "";
    }

    # Initial state
    $locales = array(
    "CSRF" => $_SESSION["token"],
    "QUERY" => $query,
    "RESULTS" => $res,
    );
    
    $this->output->add_localearray($locales);
    
    $this->build_page("details");
  }  
    
  # Not found handler
  public function not_found() { 
  
  }
  
  # Controller/Model/View link
  protected function build_page($page_name) {    
    $html_src = $this->get_model("PageModel")->get_page($page_name);    
    $html = $this->output->replace_localizations($html_src);
    
    $this->get_view()->render($html);
  }
  
}

?>