<?php

namespace Classes\Utility;

/**
 * Class GeneralUtility
 * @package Classes\Utility
 */

class GeneralUtility
{

    /**
     * Checking the required fields based on the REQUEST
     *
     * @param $array
     * @param $where
     */
    public static function checkReqFields($array, $where)
    {

        foreach ($array as $arr) {

            if (empty($where[$arr]))
                kill("Some of the mandatory fields are empty!");

        }

    }

    /**
     * Returning with an error message
     *
     * @param $text
     */
    public static function kill($text)
    {

        die(json_encode(array("errors" => $text)));

    }

    /**
     * Checking if the e-mail is valid
     *
     * @param $email
     * @return mixed
     */
    public static function validEmail($email)
    {

        return filter_var($email, FILTER_VALIDATE_EMAIL);

    }

    /**
     * SQL Error outputting to a log file, then killing the page
     *
     * @param $error
     */
    public static function sqlError($error)
    {

        error_log("SQL ERROR:" . $error);
        GeneralUtility::kill("Error while processing the request, please try again later!" . $error);

    }

    /**
     * Generating a random string
     *
     * @param int $length
     * @return bool|string
     */
    public static function randomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    /**
     * Cleaning a string up
     *
     * @param $string
     * @return mixed
     */
    public static function cleanString($string)
    {
        $string = str_replace(' ', '-', $string);
        return preg_replace('/[^A-Za-z0-9\/]/', '', $string);
    }

    public static function test()
    {
        return "asd";
    }

}