<?php

namespace Classes\Controller;

use Classes\Service\AuthService;
use Classes\Utility\GeneralUtility;
use Classes\Utility\UsersUtility;

/**
 * Class LoginController
 * @package Classes\Controller
 */
class LoginController
{

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->authService = new AuthService();
    }

    /**
     * User data check, then creating a new authenticate
     *
     * @return void
     */
    public function LoginFunction()
    {

        GeneralUtility::checkReqFields(array("email", "password"), $_POST);

        if (!GeneralUtility::validEmail($_POST["email"])) {
            GeneralUtility::kill("The e-mail is not valid!");
        }


        if ($userDetails = UsersUtility::userDataExists(
            array("email", "password"),
            array($_POST["email"], sha1($_POST["password"])),
            true)
        ) {
            $this->authService->createNewAuthenticate($userDetails["uuid"]);
        } else {
            GeneralUtility::kill("Invalid e-mail and password combination!");
        }

        return;

    }
}
