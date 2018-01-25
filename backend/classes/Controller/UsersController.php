<?php

namespace Classes\Controller;

use Classes\Service\AuthService;
use Classes\Utility\UsersUtility;

/**
 * Class UsersController
 * @package Classes\Controller
 */
class UsersController
{

    public $myData;
    public $authService;

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->authService = new AuthService();

    }

    /**
     * @param $what
     * @param $tobe
     * @return bool
     */
    public function userDataExists($what, $tobe)
    {
        return UsersUtility::userDataExists($what, $tobe);
    }

    /**
     * @param $what
     * @param $to
     * @retun void
     */
    public function update($what, $to)
    {
        UsersUtility::update($what, $to);

        return;
    }

    /**
     * Checking if the user is logged in or not
     *
     * @return bool|string
     */
    public function loggedIn()
    {
        $loggedIn = $this->authService->loggedIn();

        if ($loggedIn !== false) {
            return json_encode(array("loggedin" => true, "data" => UsersUtility::getCurrentUser()));
        } else {
            return json_encode(array("loggedin" => false));
        }

    }

    public function logout()
    {
        $this->authService->logout();
    }

}