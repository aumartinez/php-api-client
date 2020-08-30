<?php

class ApiModel implements Sanitize {
    
  public function api_call($query) {
    # Tried with cURL but API returned 302 message    
    $query = $this->sanitize_str($query);        
    $url = "https://superheroapi.com/api/10222456123421825/search/" . $query;
           
    if (!file_get_contents($url)) {
      $err = array(
      "response" => "error",
      "error" => "Couldn't connect to API",
      );
                  
      $res = json_encode($err);
    }
    else {
      $res = file_get_contents($url);
    }
    
    return $res;
  }
  
  public function get_idcall($id) {
    $query = $this->sanitize_str($id);
    $url = "https://superheroapi.com/api/10222456123421825/" . $query;
            
    if (!file_get_contents($url)) {
      $err = array(
      "response" => "error",
      "error" => "Couldn't connect to API",
      );
                  
      $res = json_encode($err);
    }
    else {
      $res = file_get_contents($url);
    }
    
    return $res;
  }
  
  public function validate_form($token) {
    $token = $this->sanitize_str($token);
    
    if (!hash_equals($token, $_SESSION["token"])) {
      return false;
    }
    else {
      unset($_SESSION["token"]);
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