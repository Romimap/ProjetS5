
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
    <body class="bg-primary">
	<!-- BODY -->
	<div class="row mt-3 mb-3">
	    <div class="shadow mx-auto bg-light p-3 rounded">
		<h3 class="text-center border-bottom mb-3 pb-3">Connection</h3>
		<form method="POST" action="./template/connectionCompte.php" id="connectionCompteid">
		    <?php $_SESSION['token']->formToken(); ?>
		    <div class="form-group" id="usernameid">
			<label>Nom d'utilisateur</label>
			<input type="text" class="form-control" name="username"/>
		    </div>
		    <div class="form-group" id="passwordid">
			<label>Mot de passe</label>
			<input type="password" class="form-control" name="password"/>
		    </div>
		    <div class="form-group text-center">
			<input type="submit" value="Se connecter"/>
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
	     var regPass = new RegExp('^[a-zA-Z0-9$#!._]{8,20}$');

	     //regex tests
	     if (!testInput("usernameid", regUsername)) { valid = false; }
	     if (!testInput("passwordid", regPass)) { valid = false; }

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

