<?php

namespace Classes\Controller;
use Classes\Utility\GeneralUtility;
use Classes\Utility\UsersUtility;

/**
 * Class SettingsController
 * @package Classes\Controller
 */

class SettingsController {

	/**
	 * Changing the password of the current session
	 */
    public function changePassword() {

      GeneralUtility::checkReqFields(array("password","password_again"),$_POST);

      if ($_POST["password"] !== $_POST["password_again"])
        GeneralUtility::kill("The passwords don't match!");

      UsersUtility::update("password", sha1($_POST["password"]));

    }

}
