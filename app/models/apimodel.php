<?php

class ApiModel implements Sanitize {
  
  private $sanitized;
  private $curl;
  
  public function __construct() {
    $this->curl = curl_init();
    $this->sanitized = "";
  }
  
  public function api_call($query) {
    
    $query = $this->sanitize_str($query);
    
    $url = "https://superheroapi.com/api/10222456123421825/search/" . $query;
    
    curl_setopt_array($this->curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
    ));
    
    $this->response = curl_exec($this->curl);
    $this->error = curl_error($this->curl);

    curl_close($this->curl);

    if ($this->error) {
      return "cURL Error #:" . $this->error;
    } else {
      return $this->response;
    }
  }
  
  
  public function sanitize_str($str) {
    $str = trim($str);
    $str = strip_tags($str);
    $str = stripslashes($str);
    $str = htmlspecialchars($str);
    
    $this->sanitized = $str;
    
    return $this->sanitized;
  }
  
}
?>