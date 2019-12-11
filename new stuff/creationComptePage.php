
<!-- PAGE TEMPLATE -->
<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
?>
<!doctype html>
<html lang="fr">
    <head>
	<?php include($WWWPATH . "template/head.html"); ?>
	<link rel="stylesheet" type="text/css" href="css/styleins.css" media="screen" />
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/all.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <title>Page d'inscription</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/stylepro.css" media="screen" />
    </head>
    <body class="container">
	<!-- BODY -->
	<div class="row">
		<div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card card-signin flex-row my-5">
          <div class="card-img-left d-none d-md-flex">
             <!-- Background image for card set in CSS! -->
          </div>

          <div class="card-body">
            <h5 class="card-title text-center">Inscription</h5>
            <form class="form-signin" method="POST" action="./template/creationCompte.php" id="creationCompteid">
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
			<input type="text" class="form-control" name="prenom"/>
			<small class="form-text text-danger invisible" id="danger">Le prénom doit contenir au plus 20 caractères et ne doit contenir aucun caractère spéciaux.</small>
		    </div>
		    <div class="form-group" id="lastNameid">
			<label>Nom</label>
			<input type="text" class="form-control" name="nom"/>
			<small class="form-text text-danger invisible" id="danger">Le nom doit contenir au plus 20 caractères et ne doit contenir aucun caractère spéciaux.</small>
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
		    <!--<div class="form-group text-center">
			<input type="submit" value="S'enregistrer"/>
		    </div>-->      

              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Finaliser l'inscription</button>
              <a class="d-block text-center mt-2 small" href="#">Vous avez déjà un compte ?</a>
              <hr class="my-4">
              <button class="btn btn-lg btn-google btn-block text-uppercase" type="submit"><i class="fab fa-google mr-2"></i> Connexion Google</button>
              <button class="btn btn-lg btn-facebook btn-block text-uppercase" type="submit"><i class="fab fa-facebook-f mr-2"></i> Connexion Facebook</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
		    <!-- Optional JavaScript -->
		    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
		    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		  </body>
	
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

