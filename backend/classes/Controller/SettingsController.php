<?php

namespace Classes\Controller;

use Classes\Domain\Modal\User;
use Classes\Utility\GeneralUtility;

/**
 * Class SettingsController
 * @package Classes\Controller
 */
class SettingsController
{

    /**
     * Changing the password for the current session
     */
    public function changePassword()
    {

        GeneralUtility::checkReqFields(array("password", "password_again"), $_POST);

        if ($_POST["password"] !== $_POST["password_again"])
            GeneralUtility::kill("The passwords don't match!");

        $user = new User($_SESSION["uuid"]);
        $user->update("password", sha1($_POST["password"]));

    }

}
