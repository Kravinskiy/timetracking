<?php

namespace Classes\Domain\Modal;
use Classes\Service\SqlConnectionService;
use Classes\Utility\GeneralUtility;

/**
 * Class Project
 * @package Classes\Domain\Modal
 */

class Project
{

	/**
	 * Creating new project
	 *
	 * @param $name
	 * @param $uuid
	 * @return bool
	 */
	public function create($name, $uuid) {
		$stmt = SqlConnectionService::connect()->prepare("INSERT INTO projects (name, uuid, created_at) VALUES (:name,:uuid,NOW())");

		try {

			$stmt->bindValue(":name", $name);
			$stmt->bindValue(":uuid", $uuid);
			$stmt->execute();

			return true;

		} catch (\PDOException $e) {
			GeneralUtility::sqlError($e);
		}

		return false;
	}

}