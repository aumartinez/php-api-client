<?php

class ResultsView extends PageView {  
  
  # Initialize keywords dictionary
  public function __construct(){
    parent::__construct();   
  }
  
  public function get_results($src) {
    $html = '';
        
    for($i = 0; $i < count($src); $i++) {
      
      $img = $src{$i}->image->url;
      
      # Check if img resource returns "not found"
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
                  <div class="iterator hidden-xs">
                    '. ($i + 1) .'
                  </div>
                  <div class="hero-img">
                    <img src="'. $img .'" alt="'. $src{$i}->name .'" />
                  </div>
                  <div class="hero-info">
                    <p class="hero-name">
                      <span class="visible-xs">'. ($i + 1) .'.- </span>
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
  
  public function get_pageid($src) {
    
    $img = $src->image->url;
      
    # Check if img resource returns "not found"
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
    
    $html = '';
    
    $html .= '
            <div class="hero-profile">
              <h1>
               '. $src->name.'
              </h1>
              <div class="row">
                <div class="col-md-4">
                  <img src="'. $img .'" class="img-fluid" />
                </div>
                <div class="col-md-8">
                  <div class="hero-bio">
                    <h2>
                      Biography
                    </h2>
                    
                    <p>
                      <span>Full name:</span> <span>'. $src->biography->{'full-name'} .'</span><br />
                      <span>Alter egos:</span> <span>'. $src->biography->{'alter-egos'} .'</span><br />
                      <span>Aliases:</span> <span>'. implode(", ", $src->biography->aliases) .'</span><br />
                      <span>Place of birth:</span> <span>'. $src->biography->{'place-of-birth'} .'</span><br />
                      <span>First appearance:</span> <span>'. $src->biography->{'first-appearance'} .'</span><br />
                      <span>Publisher:</span> <span>'. $src->biography->publisher .'</span><br />
                      <span>Alignment:</span> <span>'. $src->biography->alignment .'</span><br />
                    </p>
                    
                    <h2>
                      Power stats
                    </h2>
                    
                    <p>
                      <span>Intelligence:</span> <span>'. $src->powerstats->intelligence .'</span><br />
                      <span>Strength:</span> <span>'. $src->powerstats->strength .'</span><br />
                      <span>Speed:</span> <span>'. $src->powerstats->speed .'</span><br />
                      <span>Durability:</span> <span>'. $src->powerstats->durability .'</span><br />
                      <span>Power:</span> <span>'. $src->powerstats->power .'</span><br />
                      <span>Combat:</span> <span>'. $src->powerstats->combat .'</span><br />
                    </p>
                  </div>
                </div>
              </div>
            </div>
    ';
    
    return $this->replace_localizations($html);
  }
  
}

?>
