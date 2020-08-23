<?php

class ApiModel implements Sanitize {
    
  public function api_call($query) {
    # Tried with cURL but API returned 302 message
    
    $query = $this->sanitize_str($query);        
    $url = "https://superheroapi.com/api/10222456123421825/search/" . $query;
            
    $res = file_get_contents($url);
    
    return $res;
  }
  
  
  public function sanitize_str($str) {
    $str = trim($str);
    $str = strip_tags($str);
    $str = stripslashes($str);
    $str = htmlspecialchars($str);
    
    return $str;
  }
  
}
?>