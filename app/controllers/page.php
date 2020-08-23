<?php

class Page extends Controller implements Handlers, Errors {    
    
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);        
        
    session_start();
            
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("PageModel");
    
    # Instantiate custom view output
    $this->output = new PageView();
    
  }
  
  public function home() {
    
    # CSRF hash
    if (empty($_SESSION["token"]) || !isset($_SESSION["token"])) {
        $_SESSION["token"] = bin2hex(random_bytes(32));
    }
    
    $active = isset($_SESSION["error"])? "active":"";
    
    # Initial state
    $locales = array(
    "ERRORS" => $this->get_errors(),
    "ACTIVE" => $active,
    "CSRF" => $_SESSION["token"],
    "RESULTS" => $this->get_results(),
    );
    
    $this->output->add_localearray($locales);
    
    $this->get_model("PageModel")->page_title = "SuperHero Home";
    $this->build_page("home");
  }
  
  public function details($id = null) {
    echo "details page";
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
  
  public function get_results() {
    return;
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