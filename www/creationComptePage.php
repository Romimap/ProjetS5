
<!-- PAGE TEMPLATE -->
<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
?>
<!doctype html>
<html lang="fr">
    <head>
	<?php include($WWWPATH . "template/head.html"); ?>
    </head>
    <body class="bg-primary rounded-10">
	<!-- BODY -->
	<div class="row mt-3">
	    <div class="shadow mx-auto bg-light p-3 rounded" style="">
		<h3 class="text-center border-bottom mb-3 pb-3">S'enregistrer</h3>
		<form method="POST" action="./template/creationCompte.php">
		    <div class="form-group">
			<label for="usernameid">Nom d'utilisateur*</label>
			<input type="text" class="form-control" id="usernameid" required/>
		    </div>
		    <div class="form-group">
			<label for="passwordid">Mot de passe*</label>
			<input type="password" class="form-control" id="passwordid" name="password" required/>
	 		<small class="form-text text-muted">Votre mot de passe doit contenir entre 8 et 20 caracteres, les characteres speciaux "!@#._" sont autorisés.</small>
		    </div>
		    <div class="form-group">
			<label for="passwordConfirmationid">Confirmation du mot de passe*</label>
			<input type="password" class="form-control" id="passwordConfirmationid" name="passwordConfirmation" required/>
		    </div>
		    <div class="form-group">
			<label for="firstNameid">Prénom</label>
			<input type="text" class="form-control" id="firstNameid" name="firstName" />
		    </div>
		    <div class="form-group">
			<label for="lastNameid">Nom</label>
			<input type="text" class="form-control" id="lastNameid" name="lastName" />
		    </div>
		    <div class="form-group">
			<label for="cityid">Ville*</label>
			<input type="text" class="form-control" id="cityid" name="city" required/>
			<small class="form-text text-muted">Le nom de la ville servira aux autres utilisateurs à localiser les services que vous proposerez !</small>
		    </div>
		    <div class="border-top">
			<small class="font-italic text-muted">* Champs obligatoires</small>
		    </div>
		    <div class="form-group text-center">
			<input type="submit" value="S'enregistrer"/>
		    </div>
		</form>
	    </div>
	</div>
	
	<?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
    </body>
</html>
<?php $_SESSION['token']->cycle(); ?>

