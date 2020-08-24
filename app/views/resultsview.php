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
                <div class="col-md-4 pl-md-0 p-xs-0">
                  <img src="'. $img .'" class="img-fluid" />
                </div>
                <div class="col-md-8 hero-card bg-white">
                  <div class="hero-bio">
                    <h2>
                      Biography
                    </h2>
                    
                    <p>
                      <span><strong>Full name:</strong></span> <span>'. $src->biography->{'full-name'} .'</span><br />
                      <span><strong>Alter egos:</strong></span> <span>'. $src->biography->{'alter-egos'} .'</span><br />
                      <span><strong>Aliases:</strong></span> <span>'. implode(", ", $src->biography->aliases) .'</span><br />
                      <span><strong>Place of birth:</strong></span> <span>'. $src->biography->{'place-of-birth'} .'</span><br />
                      <span><strong>First appearance:</strong></span> <span>'. $src->biography->{'first-appearance'} .'</span><br />
                      <span><strong>Publisher:</strong></span> <span>'. $src->biography->publisher .'</span><br />
                      <span><strong>Alignment:</strong></span> <span>'. $src->biography->alignment .'</span><br />
                    </p>
                    
                    <h2>
                      Power stats
                    </h2>
                    
                    <p>
                      <span><strong>Intelligence:</strong></span> <span>'. $src->powerstats->intelligence .'</span><br />
                      <span><strong>Strength:</strong></span> <span>'. $src->powerstats->strength .'</span><br />
                      <span><strong>Speed:</strong></span> <span>'. $src->powerstats->speed .'</span><br />
                      <span><strong>Durability:</strong></span> <span>'. $src->powerstats->durability .'</span><br />
                      <span><strong>Power:</strong></span> <span>'. $src->powerstats->power .'</span><br />
                      <span><strong>Combat:</strong></span> <span>'. $src->powerstats->combat .'</span><br />
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
