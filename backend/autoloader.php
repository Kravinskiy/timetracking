<?php

  include_once("system/connection.php");
  include_once("system/security.php");

  // SQL Auth
  include_once("system/_defines.php");

  include_once("functions.php");

  spl_autoload_register(function ($class) {
    if (file_exists("classes/".$class.".class.php"))
      include_once 'classes/' . $class . '.class.php';
  });

?>
