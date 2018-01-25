<?php

namespace Classes\Service;
use Classes\Utility\GeneralUtility;
use Classes\Utility\UsersUtility;

/**
 * Class AuthService
 * @package Classes\Service
 */

class AuthService
{

    /**
     * Authenticate a user
     *
     * @param $uuid
     * @param bool $id
     */
    public function createNewAuthenticate($uuid = null, $id = null){

        if (!$uuid) {
            $uuid = UsersUtility::userDataExists("id", $id, true)["uuid"];
        }

        $_SESSION["authcode"] = sha1(GeneralUtility::randomString());
        $_SESSION["uuid"] = $uuid;

        UsersUtility::update("authcode", $_SESSION["authcode"]);


    }

    /**
     * Logging out the user
     */
    public function logout(){

        session_destroy();

    }

    /**
     * Checking if the user is logged in
     *
     * @param bool $array
     * @return bool|string
     *
     */
    public function loggedIn(){

        return UsersUtility::checkAuth();

    }


}