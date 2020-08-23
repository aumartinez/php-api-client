<?php

# Helper functions

function randomstr($length) {  
  return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

function snake_case($str) {
  return str_replace("-", "_", $str);
}

function redirect($page) {
  header ("Location: " . SITE_ROOT . $page);  
  exit();
}

function is_controller($str) {
  if (file_exists(ROOT . DS . "controllers" . DS . strtolower($str) . ".php")){
    return true;
  }
  else {
    return false;
  }
}

function deep_flatten($arr) {
  $res = array();
  
  foreach ($arr as $item) {
      if (!is_array($item)) {
          $res[] = $item;
      } 
      else {
          $res = array_merge($res, deep_flatten($item));
      }
  }

  return $res;
}


?>