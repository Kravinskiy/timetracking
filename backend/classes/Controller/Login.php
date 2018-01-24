<?php

namespace Classes\Controller;
use Classes\Utility\GeneralUtility;

/**
 * Class Login
 * @package Classes\Controller
 */

class Login {

	/**
	 * User data check, then creating a new authenticate
	 *
	 * @return void
	 */
	public function LoginFunction() {

		GeneralUtility::checkReqFields(array("email","password"),$_POST);

		if (!validEmail($_POST["email"]))
		GeneralUtility::kill("The e-mail is not valid!");

		if ($userDetails = Users::userDataExists(array("email", "password"),array($_POST["email"],sha1($_POST["password"])), true))
		Users::createNewAuthenticate($userDetails["uuid"]);
		else
		GeneralUtility::kill("Invalid e-mail and password combination!");

		return;

	}
}
