<!-- PAGE TEMPLATE -->
<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
?>
<!doctype html>
<html lang="fr">
    <head>
	<?php include($WWWPATH . "template/head.html"); ?>
	<!-- HEAD -->
    </head>
    <body>
	<!-- BODY -->
	<?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
    </body>
</html>
<?php $_SESSION['token']->cycle(); ?>

