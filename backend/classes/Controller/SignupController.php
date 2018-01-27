<?php

namespace Classes\Controller;

use Classes\Domain\Modal\User;
use Classes\Service\AuthService;
use Classes\Utility\GeneralUtility;
use Classes\Utility\UsersUtility;

/**
 * Class SignupController
 * @package Classes\Controller
 */
class SignupController
{

    /**
     * The actual signing up
     */
    public function signUpSQL()
    {

        GeneralUtility::checkReqFields(array("fullname", "email", "password"), $_POST);

        if (!GeneralUtility::validEmail($_POST["email"]))
            GeneralUtility::kill("The e-mail is not valid!");

        if (UsersUtility::userDataExists("email", $_POST["email"]))
            GeneralUtility::kill("A user with this e-mail address has already been registered!");
        else {

            if (strlen($_POST["password"]) < 5)
                GeneralUtility::kill("Password must be at least 5 characters!");

            $user = new User();
            $newUser = $user->create($_POST["fullname"], $_POST["email"], $_POST["password"]);

            if ($newUser !== false) {
                $authService = new AuthService();
                $authService->createNewAuthenticate(false, $newUser);
			}


        }


    }


}
