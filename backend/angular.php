<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);

	session_start();
	include_once("autoloader.php");

	$handle = null;

  if (!empty($_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
    $_POST = json_decode(file_get_contents('php://input'), true);


	if (empty($_GET["type"]) || empty($_GET["include"]))
		exit;

  if (!empty($_GET["function"]))
    $_GET["function"] = clean($_GET["function"]);

  $_GET["include"] = SYSTEM\Security::checkInclude($_GET["include"]);

	if ($_GET["type"] == "view" && file_exists("pages/".$_GET["include"].".html"))
		$handle = file_get_contents("pages/".$_GET["include"].".html");
	elseif($_GET["type"] == "php" && file_exists("classes/".$_GET["include"] . ".class.php") && !empty($_GET["function"])){

		$class = new $_GET["include"]();
		$handle = $class->$_GET["function"]();

	}

	if (is_array($handle))
		echo json_encode($handle);
	else
		echo $handle;

?>
