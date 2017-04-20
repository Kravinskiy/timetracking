<?php

  function checkReqFields($array,$where){

    foreach ($array as $arr){

      if (empty($where[$arr]))
        kill("Some of the mandatory fields are empty!");

    }

  }

  function kill($text){

    die(json_encode(array("errors" => $text)));

  }

  function validEmail($email){

    return filter_var($email, FILTER_VALIDATE_EMAIL);

  }

  function sqlError($error){

    error_log("SQL ERROR:" . $error);
    kill("Error while processing the request, please try again later!" . $error);

  }

  function random($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
  }

  function clean($string) {
   $string = str_replace(' ', '-', $string);
   return preg_replace('/[^A-Za-z0-9\/]/', '', $string);
  }


?>
