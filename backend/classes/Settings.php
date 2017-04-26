<?php

  namespace Classes;
  use \System\Connection as Connection;

  class Settings{

    public function changePassword(){

      checkReqFields(array("password","password_again"),$_POST);

      if ($_POST["password"] !== $_POST["password_again"])
        kill("The passwords don't match!");

      Users::update("password", sha1($_POST["password"]));

    }

  }

?>