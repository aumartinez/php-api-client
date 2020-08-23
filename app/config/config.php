<?php

# App name
define ("WEB_TITLE", "Super Heroes");

# App main folder name
define ("PATH", "php-api-client"); # App container folder

# PATH to media files and site root constants
define ("SITE_ROOT", "/" . PATH);
define ("MEDIA", SITE_ROOT . "/" . "public");
define ("HTML", "public" . DS . "html");

# Default states
define ("DEFAULT_CONTROLLER", "page");
define ("DEFAULT_METHOD", "home");
define ("NOT_FOUND", "not_found");


# Startup Locales
define ("LOCALES", 
        array(
          "SITE_ROOT" => SITE_ROOT,
          "MEDIA" => MEDIA,
          "HTML" => HTML,
        ));
?>