<?php

namespace Classes\Controller;
use Classes\Utility\GeneralUtility;

/**
 * Class Settings
 * @package Classes\Controller
 */

class Settings {

	/**
	 * Changing the password of the current session
	 */
    public function changePassword() {

      GeneralUtility::checkReqFields(array("password","password_again"),$_POST);

      if ($_POST["password"] !== $_POST["password_again"])
        GeneralUtility::kill("The passwords don't match!");

      Users::update("password", sha1($_POST["password"]));

    }

}
