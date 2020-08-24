<?php

class ResultsView extends PageView {  
  
  # Initialize keywords dictionary
  public function __construct(){
    parent::__construct();   
  }
  
  public function get_results($src) {
    $html = "";
        
    for($i = 0; $i < count($src); $i++) {
      
      $img = $src{$i}->image->url;
      
      $curl = curl_init($img);
      curl_setopt($curl, CURLOPT_NOBODY, true);
      $result = curl_exec($curl);
      
      if ($result) {
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        if ($status == 404) {
          $img = '{$MEDIA$}/img/unknown.jpg';
        }
      }
            
      curl_close($curl);
      
      $html .= '<div class="hero-card">
                  <div class="iterator">
                    '. ($i + 1) .'
                  </div>
                  <div class="hero-img">
                    <img src="'. $img .'" alt="'. $src{$i}->name .'" />
                  </div>
                  <div class="hero-info">
                    <p class="hero-name">
                      <a href="{$SITE_ROOT$}/details/'. $src{$i}->id .'" title="'. $src{$i}->name .'">'. $src{$i}->name .'</a>
                    </p>
                    
                    <p>
                      <span><strong>Character specs</strong></span><br />
                      <span>Full name: </span> <span>'. $src{$i}->biography->{'full-name'} .'</span><br />
                      <span>Gender: </span> <span>'. $src{$i}->appearance->gender .'</span><br />
                      <span>Race: </span> <span>'. $src{$i}->appearance->race .'</span><br />
                      <span>Publisher: </span> <span>'. $src{$i}->biography->publisher .'</span>
                    </p>
                  </div>
                </div>';
    }
            
    return $this->replace_localizations($html);
  }
  
  public function get_idpage($src) {
    $html = '';
    
    return $this->replace_localizations($html);
  }
  
}

?>
