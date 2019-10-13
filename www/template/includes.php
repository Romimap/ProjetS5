<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/sql.php");
require($WWWPATH . "template/token.php");
session_start();
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = new token;
}
?>
