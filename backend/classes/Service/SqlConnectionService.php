<?php

namespace Classes\Service;

/**
 * Class SqlConnectionService
 * @package Classes\Service
 */

class SqlConnectionService{

    private static $con;

	/**
	 * Estabilishing the database connection
	 *
	 * @return mixed
	 */
    public static function connect(){

      if (empty(static::$con)) {
        $con = new \PDO("pgsql:dbname=".PDO_DATABASE.";host=".PDO_HOST.";user=".PDO_USER.";password=".PDO_PASSWORD."");
        $con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        static::$con = $con;
      }

      return static::$con;

    }

}
