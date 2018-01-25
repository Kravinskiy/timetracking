<?php

namespace Classes\Controller;
use Classes\Service\AuthService;
use Classes\Service\SqlConnectionService;
use Classes\Utility\GeneralUtility;
use Classes\Utility\UsersUtility;

/**
 * Class SignupController
 * @package Classes\Controller
 */

class SignupController {

	/**
	 * The actual signing up
	 */
    public function signUpSQL() {

      GeneralUtility::checkReqFields(array("fullname","email","password"),$_POST);

      if (!validEmail($_POST["email"]))
        GeneralUtility::kill("The e-mail is not valid!");

      if (UsersUtility::userDataExists("email",$_POST["email"]))
        GeneralUtility::kill("A user with this e-mail address has already been registered!");
      else{

        if(strlen($_POST["password"]) < 5)
          GeneralUtility::kill("Password must be at least 5 characters!");

        $stmt = SqlConnectionService::connect()->prepare('INSERT INTO users (name, email, password, last_login) VALUES (?,?,?,NOW())');

        try {

          $stmt->bindValue(1, $_POST['fullname'], \PDO::PARAM_STR);
          $stmt->bindValue(2, $_POST['email'], \PDO::PARAM_STR);
          $stmt->bindValue(3, sha1($_POST['password']), \PDO::PARAM_STR);
          $stmt->execute();

          $authService = new AuthService();
          $authService->createNewAuthenticate(false,ConnectionService::connect()->lastInsertId());

        } catch(\PDOException $e) {
          GeneralUtility::sqlError($e->getMessage());
        }

      }


    }


}
