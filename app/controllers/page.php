<?php

class Page extends Search implements Handlers, Errors {
  
  protected $output;
  protected $results;
  
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);
            
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("PageModel");
    
    # Instantiate custom view output
    $this->output = new PageView();
    $this->results = new ResultsView();    
  }
    
  public function home() {    
    # CSRF hash
    if (empty($_SESSION["token"]) || !isset($_SESSION["token"])) {
        $_SESSION["token"] = bin2hex(random_bytes(32));
    }
    
    $active = (isset($_SESSION["error"]) && count($_SESSION["error"]) > 0)? "active":"";    
    $query = isset($_SESSION["query"])? $_SESSION["query"]:"";
    $src = isset($_SESSION["results"])? $_SESSION["results"]:"";
    
    if ($src) {
      $res = $this->results->get_results($src);      
    }
    else {
      $res = "";
    }
    
    # Initial state
    $locales = array(
    "ERRORS" => $this->get_errors(),
    "ACTIVE" => $active,
    "CSRF" => $_SESSION["token"],
    "RESULTS" => $res,
    "QUERY" => $query,
    );
    
    $this->output->add_localearray($locales);
    
    $this->get_model("PageModel")->page_title = "SuperHero Home";
    return $this->build_page("home");
  }
  
  public function about() {
    $this->get_model("PageModel")->page_title = "About";
    $this->build_page("about");
  }
    
  public function get_errors() {    
    if (isset($_SESSION["error"]) && count($_SESSION["error"]) > 0){
      $err_mess = "\n";
      
      foreach ($_SESSION["error"] as $error) {
        $err_mess .= $error . "<br />\n";
      }      
      
      unset($_SESSION["error"]);
      return $err_mess;
    }
    
    return;
  }
  
    
  # Not found handler
  public function not_found():void {     
    # 404 page
    $this->get_model("PageModel")->page_title = "Not found";
    $this->build_page("not-found");
  }
  
  # Controller/Model/View link
  protected function build_page($page_name) {    
    $html_src = $this->get_model("PageModel")->get_page($page_name);    
    $html = $this->output->replace_localizations($html_src);
    
    return $this->get_view()->render($html);
  }
  
}

?>
