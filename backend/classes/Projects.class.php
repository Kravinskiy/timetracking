<?php

  use System\Connection as Connection;

  class Projects{

    public function listProjects(){

      $stmt = Connection::connect()->prepare("SELECT id,name,to_char(created_at, 'yyyy-mm-dd hh24:mi') as created_at, active FROM projects WHERE uuid = :uuid");

      try{

        $stmt->bindValue(":uuid", $_SESSION["uuid"]);
        $stmt->execute();

        return array("data" => $stmt->fetchAll(PDO::FETCH_ASSOC));

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

    public function startProject(){

      if (!isset($_GET["id"]))
        kill("Project id is required!");

      

    }

  }

?>
