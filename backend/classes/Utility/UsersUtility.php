<?php

namespace Classes\Utility;
use Classes\Service\SqlConnectionService;

/**
 * Class UsersUtility
 * @package Classes\Utility
 */

class UsersUtility
{

    public static $userData = [];

    /**
     * Getting the current logged in user from the database
     *
     * @return array
     */
    public static function getCurrentUser() {
        $stmt = SqlConnectionService::connect()->prepare("SELECT uuid,email,name FROM users WHERE uuid = :uuid AND authcode = :authcode LIMIT 1");

        if (!empty($_SESSION["uuid"]) && !empty($_SESION["authcode"])) {

            try{

                $stmt->bindParam(":uuid", $_SESSION["uuid"]);
                $stmt->bindParam(":authcode", $_SESSION["authcode"]);
                $stmt->execute();

                if ($stmt->rowCount() > 0){

                    $userData = $stmt->fetch(\PDO::FETCH_ASSO);

                    self::$userData = $userData;
                    return $userData;

                }

            }catch(\PDOException $e){
                GeneralUtility::sqlError($e);
            }

        }

        return [];
    }

    /**
     * Checking if the user data exists
     *
     * @param $what
     * @param $tobe
     * @param bool $returnArray
     * @return bool
     */
    public static function userDataExists($what,$tobe, $returnArray = false){

        if (!is_array($what) && !is_array($tobe)){
            $what = array($what);
            $tobe = array($tobe);
        }

        $sql = "SELECT uuid FROM users WHERE ";
        $count = 0;

        foreach ($what as $item){

            $sql .= $item . " = ? " . (($count+1 !== count($what)) ? "AND " : "");
            $count += 1;

        }

        $stmt = SqlConnectionService::connect()->prepare($sql);

        try{

            $stmt->execute($tobe);

            if ($stmt->rowCount() > 0)
                return ($returnArray) ? $stmt->fetch(\PDO::FETCH_ASS) : true;

        }catch (\PDOException $e) {
            GeneralUtility::sqlError($e->getMessage());
        }

        return false;

    }

    /**
     * Update a user's data
     *
     * @param $what
     * @param $to
     */
    public static function update($what, $to){

        if(isset($_SESSION["uuid"])){

            $stmt = SqlConnectionService::connect()->prepare(sprintf("UPDATE users SET %s = ? WHERE uuid = ?",
                $what));

            try{

                $stmt->bindParam(1, $to);
                $stmt->bindValue(2, $_SESSION["uuid"]);
                $stmt->execute();

            }catch(\PDOException $e){
                GeneralUtility::sqlError($e);
            }

        }

    }

    /**
     * @param null $what
     * @return mixed|null
     */
    public static function getCurrentUserData($what = null) {

        if (empty(self::$userData)) {
            self::getCurrentUser();
        }

        if (!empty($what)) {
            if (empty(self::$userData[$what])) {
                return self::$userData[$what];
            }
        } else {
            return self::$userData[$what];
        }


        return null;

    }

    /**
     * Checking if the user is authenticated
     *
     * @return array|bool
     */
    public static function checkAuth() {

        $user = UsersUtility::getCurrentUser();

        if (!empty($user)) {
            return $user;
        }

        return false;

    }

}