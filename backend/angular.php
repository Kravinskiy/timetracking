<?php

	session_start();
	require_once("../vendor/autoload.php");

	// Setting the response / output to a default value
	$handle = null;

	// Defining the $_POST global
  	if (!empty($_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
    	$_POST = json_decode(file_get_contents('php://input'), true);


  	// One of the followings must be set
	if (empty($_GET["type"]) || empty($_GET["include"]))
		exit;


    // Preventing injection
  	if (!empty($_GET["include"])) {
        $_GET["include"] = \Classes\Utility\GeneralUtility::cleanString($_GET["include"]);
    }

	// Preventing injection
  	if (!empty($_GET["function"])) {
        $_GET["function"] = \Classes\Utility\GeneralUtility::cleanString($_GET["function"]);
    }

  	// If we resolve a view
	if ($_GET["type"] == "view" && file_exists("pages/".$_GET["include"].".html")) {

        // Security procedure
        $_GET["include"] = \Classes\Service\SecurityService::checkInclude($_GET["include"]);

        $handle = file_get_contents("pages/".$_GET["include"].".html");

    // If we resolve a function
    } elseif ($_GET["type"] == "php" &&  !empty($_GET["function"])) {

        $className = "Classes\Controller\\" . $_GET["include"];
        $class = new $className;
        $handle = $class->$_GET["function"]();

    }

	// Outputting the corresponding value(s)
	if (is_array($handle))
		echo json_encode($handle);
	else
		echo $handle;
