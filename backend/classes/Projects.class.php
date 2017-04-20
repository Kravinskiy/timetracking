<?php

  use System\Connection as Connection;

  class Projects{

    public function listProjects(){

      $stmt = Connection::connect()->prepare("SELECT id,name,uuid FROM projects WHERE uuid = :uuid");

      try{

        $stmt->bindParam(":uuid", $_SESSION["uuid"]);
        $stmt->execute();

        foreach ($stmt->fetch(PDO::FETCH_ASSOC){

          

        }

      }catch(PDOException $e){
        sqlError($e);
      }

    }

  }

?>
