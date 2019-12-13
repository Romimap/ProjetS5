
<!-- PAGE TEMPLATE -->
<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
?>
<!doctype html>
<html lang="fr">
    <head>
	<?php include($WWWPATH . "template/head.html"); ?>
	<link rel="stylesheet" type="text/css" href="css/stylespc.css" media="screen" />
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Hello, world!</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    </head>
    <body class="d-flex flex-column">
    <div class="container-fluid">
      <div class="row no-gutter">
        <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
        <div class="col-md-8 col-lg-6">
          <div class="login d-flex align-items-center py-5">
            <div class="container">
              <div class="row">
                <div class="col-md-9 col-lg-8 mx-auto">
                  <h3 class="login-heading mb-4">Ah, vous revoilà !</h3>
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
					    <!--<div class="form-group text-center">
						<input type="submit" value="Se connecter"/>
					    </div>-->

                    <div class="custom-control custom-checkbox mb-3">
                      <input type="checkbox" class="custom-control-input" id="customCheck1">
                      <label class="custom-control-label" for="customCheck1">Rester connecté</label>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit">Connexion</button>
                    <div class="text-center">
                      <a class="small" href="#">Mot de passe oublié ?</a></div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	<footer id="sticky-footer" class="py-4 bg-dark text-white-50">
      <div class="container text-center">
        <small>Copyright &copy; Projet HLIN510 & HLIN511 - 2019/2020</small>
      </div>
    </footer>
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

	     var regUsername = new RegExp('^[a-zA-Z]{1}\\w{4,19}$');
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
