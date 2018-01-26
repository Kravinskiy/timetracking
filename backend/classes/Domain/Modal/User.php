<?php

namespace Classes\Domain\Modal;
use Classes\Service\SqlConnectionService;
use Classes\Utility\GeneralUtility;

/**
 * Class User
 * @package Classes\Domain\Modal
 */

class User
{

	private $uuid;

	/**
	 * User constructor.
	 * @param $uuid
	 */
	public function __construct($uuid = null) {

		if (!empty($uuid))
			$this->uuid = $uuid;
	}

	/**
	 * Update a user's data
	 *
	 * @param $what
	 * @param $to
	 */
	public function update($what, $to)
	{

		$stmt = SqlConnectionService::connect()->prepare(sprintf("UPDATE users SET %s = ? WHERE uuid = ?",
			$what));

		try {

			$stmt->bindParam(1, $to);
			$stmt->bindValue(2, $this->uuid);
			$stmt->execute();

		} catch (\PDOException $e) {
			GeneralUtility::sqlError($e);
		}

	}

	/**
	 * @param $fullName
	 * @param $email
	 * @param $password
	 * @return integer|bool
	 */
	public function create($fullName, $email, $password) {
		$stmt = SqlConnectionService::connect()->prepare('INSERT INTO users (name, email, password, last_login) VALUES (?,?,?,NOW())');

		try {

			$stmt->bindValue(1, $fullName, \PDO::PARAM_STR);
			$stmt->bindValue(2, $email, \PDO::PARAM_STR);
			$stmt->bindValue(3, sha1($password), \PDO::PARAM_STR);
			$stmt->execute();

			return SqlConnectionService::connect()->lastInsertId();

		} catch (\PDOException $e) {
			GeneralUtility::sqlError($e->getMessage());
		}

		return false;
	}

}