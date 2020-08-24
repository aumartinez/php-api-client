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
    
    $res = $this->get_model("ApiModel")->get_thisid($id);
    
    if (!$res) {
      $this->not_found();
    }

    # Initial state
    $locales = array(
    "CSRF" => $_SESSION["token"],
    "QUERY" => $query,
    );
    
    $this->output->add_localearray($locales);
    
    $this->build_page("details");
  }  
    
  # Not found handler
  public function not_found() { 
    
    # 404 page
    $this->build_page("not-found");
  }
  
  # Controller/Model/View link
  protected function build_page($page_name) {    
    $html_src = $this->get_model("PageModel")->get_page($page_name);    
    $html = $this->output->replace_localizations($html_src);
    
    $this->get_view()->render($html);
  }
  
}

?>