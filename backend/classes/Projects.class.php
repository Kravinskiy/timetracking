<?php

  use System\Connection as Connection;

  class Projects{

    public function listProjects(){

      $stmt = Connection::connect()->prepare("SELECT projects.id as id, projects.name as name,to_char(projects.created_at, 'yyyy-mm-dd hh24:mi:ss') as created_at, projects.active as active, to_char(time_log.from, 'yyyy-mm-dd hh24:mi:ss') as timefrom,to_char(time_log.to, 'yyyy-mm-dd hh24:mi:ss') as timeto
      FROM projects
      LEFT JOIN time_log ON time_log.project_id = projects.id
      WHERE projects.uuid = :uuid");

      try{

        $stmt->bindValue(":uuid", $_SESSION["uuid"]);
        $stmt->execute();

        $data = array();

        while ($fetch = $stmt->fetch(PDO::FETCH_ASSOC)){

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

            if (!empty($fetch["timefrom"])){

              if (empty($fetch["timeto"])){
                $data[$fetch["id"]]["status"] = true;
                $fetch["timeto"] = date("Y-m-d H:i:s");
              }

              $time = strtotime($fetch["timeto"]) - strtotime($fetch["timefrom"]);
              $hours = 0;

              if ($time > 3600){
                $hours = floor($time / 3600);
                $data[$fetch["id"]]["hours"] += $hours;
                $time -= 3600*$hours;
              }

              $minutes = (floor($time/60) > 0) ? floor($time/60) : 0;
              $data[$fetch["id"]]["minutes"] += $minutes;

              array_push($data[$fetch["id"]]["timelogs"], array("from" => $fetch["timefrom"], "to" => $fetch["timeto"], "hours" => $hours, "minutes" => $minutes));

            }
        }

        return array("data" => $data);

      }catch(PDOException $e){
        sqlError($e);
      }

    }

    public function newProject(){

      checkReqFields(array("name"),$_POST);

      $stmt = Connection::connect()->prepare("INSERT INTO projects (name, uuid, created_at) VALUES (:name,:uuid,NOW())");

      try{

        $stmt->bindValue(":name", $_POST["name"]);
        $stmt->bindValue(":uuid", $_SESSION["uuid"]);
        $stmt->execute();


      }catch(PDOException $e){
        sqlError($e);
      }

    }

    public function getStatus($projectid){

      $stmt = Connection::connect()->prepare("SELECT 'from', 'to' FROM time_log WHERE project_id = :projectid ORDER BY id DESC");

      try{

        $stmt->bindValue(":projectid", $projectid);
        $stmt->execute();

      }catch(PDOException $e){
        sqlError($e);
      }

    }

    private static function projectAccess($projectid){

      $stmt = Connection::connect()->prepare("SELECT uuid FROM projects WHERE id = :projectid AND uuid = :uuid AND active = true");

      try{

        $stmt->bindValue(":projectid", $projectid);
        $stmt->bindValue(":uuid", $_SESSION["uuid"]);
        $stmt->execute();

        if ($stmt->rowCount() > 0)
          return true;

      }catch(PDOException $e){
        sqlError($e);
      }

      return false;

    }

    public static function pauseProject($projectid = NULL){

      if ($projectid == NULL && !empty($_GET["id"]))
        $projectid = $_GET["id"];
      elseif(empty($_GET["id"]))
        kill("Project id is required.");

      if (!self::projectAccess($projectid))
        kill("Request denied.");

      $stmt = Connection::connect()->prepare('UPDATE time_log SET "to" = NOW() WHERE "to" IS NULL AND project_id = :projectid');

      try{

        $stmt->bindValue(":projectid", $projectid);
        $stmt->execute();

      }catch(PDOException $e){
        sqlError($e);
      }

    }

    public static function startProject($projectid = NULL){

      if ($projectid == NULL && !empty($_GET["id"]))
        $projectid = $_GET["id"];
      elseif(empty($_GET["id"]))
        kill("Project id is required.");

      if (!self::projectAccess($projectid))
        kill("Request denied.");

      $stmt = Connection::connect()->prepare('INSERT INTO time_log (project_id, "from") VALUES (:projectid, NOW())');

      try{

        $stmt->bindValue(":projectid", $projectid);
        $stmt->execute();

      }catch(PDOException $e){
        sqlError($e);
      }

    }

    public function deactivateProject($projectid = NULL){

      if ($projectid == NULL && !empty($_GET["id"]))
        $projectid = $_GET["id"];
      elseif(empty($_GET["id"]))
        kill("Project id is required.");

      self::pauseProject($projectid);

      $stmt = Connection::connect()->prepare("UPDATE projects SET active = false WHERE id = :projectid");

      try{

        $stmt->bindValue(":projectid", $projectid);
        $stmt->execute();

      }catch(PDOException $e){
        sqlError($e);
      }

    }

  }

?>
