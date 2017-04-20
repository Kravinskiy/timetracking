<?php

  namespace System;

  class Security{

    private static $roleTypes = array();
    private static $myRoles = array();
    private static $modules = array(
      "myaccount" => array("user"),
      "login" => array("notUser"),
      "signup" => array("notUser"),
      "users" => array("everyone"),
      "home" => array("everyone"),
      "settings" => array("user")
    );

    public static function init(){

      if (empty(self::$roleTypes)){
        self::$roleTypes = array(
          "user" => \Users::loggedIn(false),
          "notUser" => !\Users::loggedIn(false),
          "everyone" => true,
        );
      }

      if (empty(self::$myRoles))
        self::$myRoles = array_keys(self::$roleTypes, true);



    }

    public static function __callStatic($name, $arguments){

      self::init();

      return self::$name($arguments);

    }



    private static function checkInclude($array){

      $include = clean(strtolower(explode("/", $array[0])[0]));

      if (isset(self::$modules[$include])){

        foreach (self::$myRoles as $role){
          if (in_array($role, self::$modules[$include]))
            return clean($array[0]);
        }

      }

      return "home";

    }

  }

?>
