<!-- PAGE TEMPLATE -->
<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
?>
<!doctype html>
<html lang="fr">
    <?php include($WWWPATH . "template/head.html"); ?>
    <body>
	<form method="POST" action="creationCompte.php">
	    <?php $_SESSION['token']->formToken(); ?>
	    <input type="text" name="username" placeholder="username" value="Username"/>
	    <input type="text" name="password" placeholder="passwd" value="Passwordaaa"/>
	    <input type="text" name="passwordConfirmation" placeholder="passwd" value="Passwordaaa"/>
	    <input type="text" name="firstName" placeholder="prenom" value="Prenom"/>
	    <input type="text" name="lastName" placeholder="nom" value="NomFamille"/>
	    <input type="text" name="email" placeholder="mail@aa.cc" value="abcd@abcd.abcd"/>
	    <input type="text" name="city" placeholder="city" value="Paris"/>
	    <input type="submit"/>
	</form>
	<?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
    </body>
</html>
<?php $_SESSION['token']->cycle(); ?>

