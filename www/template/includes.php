<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/sql.php");
require($WWWPATH . "template/token.php");
session_start();

//Connection check
if (isset($_SESSION['userInfo'])) {
    $error = true;
    //the user token is set on the server and the client
    if (isset($_SESSION['userToken']) && isset($_COOKIE['userToken'])) {
	$_SESSION['userToken']->cycle();
	//the user token match
	if ($_SESSION['userToken']->verify($_COOKIE['userToken'])) {
	    //we store a new user token
	    if (setcookie("userToken", $_SESSION['userToken']->nextToken(), time() + 3600, '/')) {
		$error = false;
	    }
	}
    }
    //if there is an incoherence with the user token
    if ($error) {
	session_destroy();
	session_start();
    }
}

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = new token;
}


?>
