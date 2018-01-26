<?php

namespace Classes\Domain\Repository;

/**
 * Class ProjectsRepository
 * @package Classes\Modal\Repositoryx
 */

class ProjectsRepository
{

	public static function findByUser($uuid) {

		$stmt = SqlConnectionService::connect()->prepare("SELECT projects.id as id, projects.name as name,to_char(projects.created_at, 'yyyy-mm-dd hh24:mi:ss') as created_at, projects.active as active, to_char(time_log.from, 'yyyy-mm-dd hh24:mi:ss') as timefrom,to_char(time_log.to, 'yyyy-mm-dd hh24:mi:ss') as timeto, to_char(NOW(), 'yyyy-mm-dd hh24:mi:ss') as now 
		FROM projects
      	LEFT JOIN time_log ON time_log.project_id = projects.id
     	 WHERE projects.uuid = :uuid");

		$data = array();

		try {

			$stmt->bindValue(":uuid", $uuid);
			$stmt->execute();

			while ($fetch = $stmt->fetch(\PDO::FETCH_ASSOC)) {

				if (!isset($data[$fetch["id"]]))
					$data[$fetch["id"]] = array(
						"id" => $fetch["id"],
						"name" => $fetch["name"],
						"created_at" => $fetch["created_at"],
						"active" => $fetch["active"],
						"timelogs" => array(),
						"status" => false,
						"hours" => 0,
						"minutes" => 0
					);

				if (!empty($fetch["timefrom"])) {

					if (empty($fetch["timeto"])) {
						$data[$fetch["id"]]["status"] = true;
						$fetch["timeto"] = $fetch["now"];
					}

					$time = strtotime($fetch["timeto"]) - strtotime($fetch["timefrom"]);
					$hours = 0;

					if ($time > 3600) {
						$hours = floor($time / 3600);
						$data[$fetch["id"]]["hours"] += $hours;
						$time -= 3600 * $hours;
					}

					$minutes = (floor($time / 60) > 0) ? floor($time / 60) : 0;
					$data[$fetch["id"]]["minutes"] += $minutes;

					array_push(
						$data[$fetch["id"]]["timelogs"],
						array(
							"from" => $fetch["timefrom"],
							"to" => $fetch["timeto"],
							"hours" => $hours,
							"minutes" => $minutes
						)
					);

				}

			}

		} catch (\PDOException $e) {
			GeneralUtility::sqlError($e);
		}

		return $data;

	}

}