<?php

namespace Classes\Service;
use Classes\Service\SqlConnectionService;
use Classes\Utility\GeneralUtility;

/**
 * Class ProjectsService
 * @package Classes\Service
 */

class ProjectsService
{

	public function newProject($name, $uuid) {

		$stmt = SqlConnectionService::connect()->prepare("INSERT INTO projects (name, uuid, created_at) VALUES (:name,:uuid,NOW())");

		try {

			$stmt->bindValue(":name", $name);
			$stmt->bindValue(":uuid", $uuid);
			$stmt->execute();


		} catch (\PDOException $e) {
			GeneralUtility::sqlError($e);
		}

	}

	/**
	 * Getting the status of a project
	 *
	 * @param $projectid
	 */
	public function getStatus($projectId)
	{

		$stmt = SqlConnectionService::connect()->prepare("SELECT 'from', 'to' FROM time_log WHERE project_id = :projectid ORDER BY id DESC");

		try {

			$stmt->bindValue(":projectid", $projectId);
			$stmt->execute();

		} catch (\PDOException $e) {
			GeneralUtility::sqlError($e);
		}

	}

	/**
	 * Checking if a user has access for the project
	 *
	 * @param $projectid
	 * @return bool
	 */
	public function projectAccess($projectId, $uuid)
	{

		$stmt = SqlConnectionService::connect()->prepare("SELECT uuid FROM projects WHERE id = :projectid AND uuid = :uuid AND active = true");

		try {

			$stmt->bindValue(":projectid", $projectId);
			$stmt->bindValue(":uuid", $uuid);
			$stmt->execute();

			if ($stmt->rowCount() > 0)
				return true;

		} catch (\PDOException $e) {
			GeneralUtility::sqlError($e);
		}

		return false;

	}

	/**
	 * Breaking the project
	 *
	 * @param null $projectid
	 */
	public function pauseProject($projectId = NULL)
	{

		$stmt = SqlConnectionService::connect()->prepare('UPDATE time_log SET "to" = NOW() WHERE "to" IS NULL AND project_id = :projectid');

		try {

			$stmt->bindValue(":projectid", $projectId);
			$stmt->execute();

		} catch (\PDOException $e) {
			GeneralUtility::sqlError($e);
		}

	}

	/**
	 * Starting the project
	 *
	 * @param null $projectid
	 */
	public function startProject($projectId = NULL)
	{

		$stmt = SqlConnectionService::connect()->prepare('INSERT INTO time_log (project_id, "from") VALUES (:projectid, NOW())');

		try {

			$stmt->bindValue(":projectid", $projectId);
			$stmt->execute();

		} catch (\PDOException $e) {
			GeneralUtility::sqlError($e);
		}

	}

	/**
	 * Disabling / deactivating the project
	 *
	 * @param $projectid
	 */
	public function deactivateProject($projectId)
	{

		$this->pauseProject($projectId);
		$stmt = SqlConnectionService::connect()->prepare("UPDATE projects SET active = false WHERE id = :projectid");

		try {

			$stmt->bindValue(":projectid", $projectId);
			$stmt->execute();

		} catch (\PDOException $e) {
			GeneralUtility::sqlError($e);
		}

	}

}