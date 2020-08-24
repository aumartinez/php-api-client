<?php

class ApiModel implements Sanitize {
    
  public function api_call($query) {
    # Tried with cURL but API returned 302 message    
    $query = $this->sanitize_str($query);        
    $url = "https://superheroapi.com/api/10222456123421825/search/" . $query;
            
    $res = file_get_contents($url);
    
    return $res;
  }
  
  public function get_idcall($id) {
    $query = $this->sanitize_str($id);
    $url = "https://superheroapi.com/api/10222456123421825/" . $query;
            
    $res = file_get_contents($url);
    
    return $res;
  }
  
  public function validate_form($token) {
    $token = $this->sanitize_str($token);
    
    if (!hash_equals($token, $_SESSION["token"])) {
      return false;
    }
    else {
      return true;
    }
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