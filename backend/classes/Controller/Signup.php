<?php

namespace Classes\Controller;
use Classes\Service\Connection as Connection;
use Classes\Utility\GeneralUtility;

/**
 * Class Signup
 * @package Classes\Controller
 */

class Signup {

	/**
	 * The actual signing up
	 */
    public function signupSQL() {

      GeneralUtility::heckReqFields(array("fullname","email","password"),$_POST);

      if (!validEmail($_POST["email"]))
        GeneralUtility::kill("The e-mail is not valid!");

      if (Users::userDataExists("email",$_POST["email"]))
        GeneralUtility::kill("A user with this e-mail address has already been registered!");
      else{

        if(strlen($_POST["password"]) < 5)
          GeneralUtility::kill("Password must be at least 5 characters!");

        $stmt = Connection::connect()->prepare('INSERT INTO users (name, email, password, last_login) VALUES (?,?,?,NOW())');

        try {

          $stmt->bindValue(1, $_POST['fullname'], \PDO::PARAM_STR);
          $stmt->bindValue(2, $_POST['email'], \PDO::PARAM_STR);
          $stmt->bindValue(3, sha1($_POST['password']), \PDO::PARAM_STR);
          $stmt->execute();


          Users::createNewAuthenticate(false,Connection::connect()->lastInsertId());

        } catch(\PDOException $e) {
          sqlError($e->getMessage());
        }

      }


    }


}
