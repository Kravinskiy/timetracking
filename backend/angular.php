<?php

	session_start();
	require_once("../vendor/autoload.php");

	$handle = null;

  	if (!empty($_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
    	$_POST = json_decode(file_get_contents('php://input'), true);


	if (empty($_GET["type"]) || empty($_GET["include"]))
		exit;

  	if (!empty($_GET["function"]))
  		$_GET["function"] = \Classes\Utility\GeneralUtility::cleanString($_GET["function"]);

  	$_GET["include"] = \Classes\Service\Security::checkInclude($_GET["include"]);

	if ($_GET["type"] == "view" && file_exists("pages/".$_GET["include"].".html"))
		$handle = file_get_contents("pages/".$_GET["include"].".html");
	elseif($_GET["type"] == "php" && file_exists("classes/".$_GET["include"] . ".php") && !empty($_GET["function"])){
		$className = "Classes\\".$_GET["include"];
		$class = new $className;
		$handle = $class->$_GET["function"]();

	}

	if (is_array($handle))
		echo json_encode($handle);
	else
		echo $handle;

?>
