<?php

namespace Classes\Controller;
use Classes\Service\Connection;

/**
 * Class Users
 * @package Classes\Controller
 */

class Users {

    public static $myData;

	/**
	 * Checking if the user data exists
	 *
	 * @param $what
	 * @param $tobe
	 * @param bool $return
	 * @return bool
	 */
    public static function userDataExists($what,$tobe, $return = false){

      if (!is_array($what) && !is_array($tobe)){
        $what = array($what);
        $tobe = array($tobe);
      }

      $sql = "SELECT uuid FROM users WHERE ";
      $count = 0;

      foreach ($what as $item){

        $sql .= $item . " = ? " . (($count+1 !== count($what)) ? "AND " : "");
        $count += 1;

      }

      $stmt = Connection::connect()->prepare($sql);

      try{

        $stmt->execute($tobe);

        if ($stmt->rowCount() > 0)
          return ($return) ? $stmt->fetch(\PDO::FETCH_ASSOC) : true;

      }catch (\PDOException $e) {
        sqlError($e->getMessage());
      }

      return false;

    }

	/**
	 * Authenticate a user
	 *
	 * @param $uuid
	 * @param bool $id
	 *
	 * @todo Put it inside of a service class
	 */
    public static function createNewAuthenticate($uuid, $id = false){

      if (!$uuid)
        $uuid = self::userDataExists("id", $id, true)["uuid"];

      $_SESSION["authcode"] = sha1(random());
      $_SESSION["uuid"] = $uuid;

      self::update("authcode", $_SESSION["authcode"]);


    }

	/**
	 * Check if the authentication is correct
	 *
	 * @return bool
	 *
	 * @todo Put it inside of a service class
	 */
    public static function checkAuth(){

      $stmt = Connection::connect()->prepare("SELECT uuid,email,name FROM users WHERE uuid = :uuid AND authcode = :authcode LIMIT 1");

      try{

        $stmt->bindParam(":uuid", $_SESSION["uuid"]);
        $stmt->bindParam(":authcode", $_SESSION["authcode"]);
        $stmt->execute();

        if ($stmt->rowCount() > 0){

          self::$myData = $stmt->fetch(\PDO::FETCH_ASSOC);

          return true;

        }elseif(isset($_SESSION["authcode"]) || isset($_SESSION["uuid"]))
          self::logout();

        return false;



      }catch(\PDOException $e){
        sqlError($e);
      }

    }

	/**
	 * Update a user's data
	 *
	 * @param $what
	 * @param $to
	 */
    public static function update($what, $to){

      if(isset($_SESSION["uuid"])){

        $stmt = Connection::connect()->prepare(sprintf("UPDATE users SET %s = ? WHERE uuid = ?",
        $what));

        try{

          $stmt->bindParam(1, $to);
          $stmt->bindValue(2, $_SESSION["uuid"]);
          $stmt->execute();

        }catch(\PDOException $e){
          sqlError($e);
        }

      }

    }


	/**
	 * Logging out the user
	 */
    public static function logout(){

      session_destroy();

    }

	/**
	 * Checking if the user is logged in
	 *
	 * @param bool $array
	 * @return bool|string
	 *
	 * @todo Put it inside of a service class
	 */
    public static function loggedIn($array = true){

      if (self::checkAuth())
        return ($array) ? json_encode(array("loggedin" => true, "data" => static::$myData)) : true;
      else
        return ($array) ? json_encode(array("loggedin" => false)) : false;

    }

 }