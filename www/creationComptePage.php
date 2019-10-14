
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
		<form method="POST" action="./template/creationCompte.php" id="creationCompteid">
		    <?php $_SESSION['token']->formToken(); ?>
		    <div class="form-group" id="usernameid">
			<label>Nom d'utilisateur*</label>
			<input type="text" class="form-control" name="username"/>
			<small class="form-text text-danger invisible" id="danger">Le nom d'utilisateur doit contenir entre 5 et 20 caractères et ne doit contenir aucun caractère spéciaux.</small>
		    </div>
		    <div class="form-group" id="passwordid">
			<label>Mot de passe*</label>
			<input type="password" class="form-control" name="password"/>
	 		<small class="form-text text-muted">Votre mot de passe doit contenir entre 8 et 20 caracteres, les characteres speciaux "!@#._" sont autorisés.</small>
			<small class="form-text text-danger invisible" id="danger">Le mot de passe n'est pas valide</small>
		    </div>
		    <div class="form-group" id="passwordConfirmationid">
			<label>Confirmation du mot de passe*</label>
			<input type="password" class="form-control" name="passwordConfirmation"/>
			<small class="form-text text-danger invisible" id="danger">Le mot de passe ne correspond pas.</small>
		    </div>
		    <div class="form-group" id="firstNameid">
			<label>Prénom</label>
			<input type="text" class="form-control" name="firstName"/>
			<small class="form-text text-danger invisible" id="danger">Le prénom doit contenir au plus 20 caractères et ne doit contenir aucun caractère spéciaux.</small>
		    </div>
		    <div class="form-group" id="lastNameid">
			<label>Nom</label>
			<input type="text" class="form-control" name="lastName"/>
			<small class="form-text text-danger invisible" id="danger">Le nom doit contenir au plus 20 caractères et ne doit contenir aucun caractère spéciaux.</small>
		    </div>
		    <div class="form-group" id="cityid">
			<label>Ville*</label>
			<input type="text" class="form-control" name="city"/>
			<small class="form-text text-muted">Le nom de la ville servira aux autres utilisateurs à localiser les services que vous proposerez !</small>
			<small class="form-text text-danger invisible" id="danger">Le nom de la ville doit contenir entre 1 et 20 caractères et ne doit contenir aucun caractère spéciaux.</small>
		    </div>
		    <div class="form-group" id="emailid">
			<label>Email*</label>
			<input type="text" class="form-control" name="email"/>
			<small class="form-text text-muted">Votre email ne sera pas affiché aux autres utilisateurs</small>
			<small class="form-text text-danger invisible" id="danger">email non valide</small>
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
	<script>
	 /**
	  * test if the form is valid, prints error messages if not (danger id)
	  */
	 document.getElementById("creationCompteid").onsubmit = function() {
	     var valid = true;

	     var regUsername = new RegExp('^[a-zA-Z]{1}\\w{4,9}$');
	     var regNameNeed = new RegExp('^[a-zA-Z]{1,20}$');
	     var regName = new RegExp('^[a-zA-Z]{0,20}$');
	     var regPass = new RegExp('^[a-zA-Z0-9$#!._]{8,20}$');
	     var regMail = new RegExp('^[a-zA-Z0-9._]{1,20}@{1}[a-z0-9._]{1,20}$');

	     //regex tests
	     if (!testInput("usernameid", regUsername)) { valid = false; }
	     if (!testInput("passwordid", regPass)) { valid = false; }
	     if (!testInput("firstNameid", regName)) { valid = false; }
	     if (!testInput("lastNameid", regName)) { valid = false; }
	     if (!testInput("lastNameid", regName)) { valid = false; }
	     if (!testInput("cityid", regNameNeed)) { valid = false; }
	     if (!testInput("emailid", regMail)) { valid = false; }

	     //password match test
	     if (document.querySelector("#passwordid input").value != document.querySelector("#passwordConfirmationid input").value) {
		 valid = false;
		 document.querySelector("#passwordConfirmationid small#danger").className = "form-text text-danger";
	     } else {
		 document.querySelector("#passwordConfirmationid small#danger").className = "form-text text-danger invisible";
	     }
	     
	     return valid;
	 };

	 /**
	  * Tests for an id, the input value related to it with the regex
	  * and prints the error message (id danger) if it returns false
	  */
	 function testInput (id, regex) {
	     var formelement = document.querySelector('#' + id + " input");
	     var selected = document.querySelector('#' + id + " small#danger");
	     if (!regex.test(formelement.value)) {
		 selected.className = "form-text text-danger";
		 return false;
	     } else {
		 selected.className = "form-text text-danger invisible";
		 return true;
	     }

	 }

	 /**
	  * changes the background color of the password confirmation 
	  * if it matches the password or not
	  */
	 var input = document.getElementById("passwordConfirmationid");
	 input.addEventListener('keyup', (event) => {
	     var pw = document.querySelector("#passwordid input");
	     var pwc = document.querySelector("#passwordConfirmationid input");
	     if (pwc.value == "") {
		 pwc.className = "form-control";
	     } else if (pwc.value == pw.value) {
		 pwc.className = "form-control bg-success";
	     } else {
		 pwc.className = "form-control bg-danger";
	     }
	 });
	</script>
    </body>
</html>
<?php $_SESSION['token']->cycle(); ?>

