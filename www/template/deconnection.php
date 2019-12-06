<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
//We delete the userToken cookie and reset the session
setcookie('userToken', time() - 3600);
session_destroy();
session_start();
header("location: ../index.php")
?>
