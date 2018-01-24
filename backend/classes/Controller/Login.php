<?php

namespace Classes\Controller;

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

		checkReqFields(array("email","password"),$_POST);

		if (!validEmail($_POST["email"]))
		kill("The e-mail is not valid!");

		if ($userDetails = Users::userDataExists(array("email", "password"),array($_POST["email"],sha1($_POST["password"])), true))
		Users::createNewAuthenticate($userDetails["uuid"]);
		else
		kill("Invalid e-mail and password combination!");

		return;

	}
}
