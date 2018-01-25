<?php

namespace Classes\Controller;
use Classes\Utility\GeneralUtility;
use Classes\Utility\UsersUtility;

/**
 * Class LoginController
 * @package Classes\Controller
 */

class LoginController {

	/**
	 * User data check, then creating a new authenticate
	 *
	 * @return void
	 */
	public function LoginFunction() {

		GeneralUtility::checkReqFields(array("email","password"),$_POST);

		if (!validEmail($_POST["email"])) {
            GeneralUtility::kill("The e-mail is not valid!");
        }


		if ($userDetails = UsersUtility::userDataExists(
		    array("email", "password"),
            array($_POST["email"], sha1($_POST["password"])),
            true)
        ) {
            UsersUtility::createNewAuthenticate($userDetails["uuid"]);
        } else {
            GeneralUtility::kill("Invalid e-mail and password combination!");
        }

		return;

	}
}
