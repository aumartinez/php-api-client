<?php

class Page extends Controller {
    
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);        
        
    session_start();
            
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("PageModel");
    
    # Instantiate custom view output
    $this->output = new PageView();
  }
  
  public function home() {
    echo "landing";
  }
  
  public function details($id = null) {
    echo "details page";
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