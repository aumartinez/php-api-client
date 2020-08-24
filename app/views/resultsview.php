<?php

class ResultsView extends PageView {  
  
  # Initialize keywords dictionary
  public function __construct(){
    parent::__construct();   
  }
  
  public function get_results($src) {
    $html = "";
    
    $html = "<ul>\n";
    $html = $src;
    $html = "</ul>\n";
    
    return $this->replace_localizations($html);
  }
  
}

?>
