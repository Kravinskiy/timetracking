<?php

namespace Classes\Service;

use Classes\Controller\UsersController;
use Classes\Utility\GeneralUtility;
use Classes\Utility\UsersUtility;

/**
 * Class SecurityService
 * @package Classes\Service
 */
class SecurityService
{

    private static $roleTypes = array();
    private static $myRoles = array();
    private static $modules = array(
        "myaccount" => array("user"),
        "login" => array("notUser"),
        "signup" => array("notUser"),
        "users" => array("everyone"),
        "home" => array("everyone"),
        "settings" => array("user"),
        "projects" => array("user")
    );

    /**
     * Initalize the class
     */
    public static function init()
    {

        if (empty(self::$roleTypes)) {
            self::$roleTypes = array(
                "user" => !empty(UsersUtility::checkAuth()) ? true : false,
                "notUser" => !UsersUtility::checkAuth(),
                "everyone" => true,
            );
        }

        if (empty(self::$myRoles))
            self::$myRoles = array_keys(self::$roleTypes, true);

    }


    /**
     * Permission check
     *
     * @param $include
     * @return string
     */
    public static function checkInclude($include)
    {

        self::init();

        $include = GeneralUtility::cleanString(strtolower($include));

        // In case it's a child page
        $exploded = explode("/", $include)[0];

        if (isset(self::$modules[$exploded])) {

            foreach (self::$myRoles as $role) {
                if (in_array($role, self::$modules[$exploded]))
                    return $include;
            }

        }

        return "home";

    }

}
