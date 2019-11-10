<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . 'template/sql.php');
require($WWWPATH . 'template/token.php');
session_start();
# @Author: FOURNIER Romain
# @Date: 12th of October, 2019
# @Email: romain.fournier.095@gmail.com


/**
 * username regex: /^[a-z]{1}\w{4,19}$/i
 * starts with a letter, then alphanumeric + underscore, 5-20 chars, case insensitive
 */
function isUsername ($str) {
    if (!is_string($str))
	return false;
    return preg_match('/^[a-z]{1}\w{4,14}$/i', $str) == 1;
}

/**
 * name regex: /^[a-z]{2,20}$/i
 * letters, 2-20 chars, case insensitive
 */
function isName ($str) {
    if (!is_string($str))
	return false;
    return preg_match('/^[a-z]{2,20}$/i', $str) == 1;
}

/**
 * password regex: /^[a-zA-Z0-9!@#._]{2,20}$/
 * alphanumeric and !@#._    , 8-20 chars, case sensitive
 */
function isPassword ($str) {
    if (!is_string($str))
	return false;
    return preg_match('/^[a-zA-Z0-9!@#._]{8,20}$/', $str) == 1;
}

/**
 * mail regex: /^[a-z0-9._]{1,20}@{1}[a-z0-9._]{1,20}$/i
 * alphanumeric + underscore + dot  @  alphanumeric + underscore + dot 
 * 5-50 chars, case insensitive
 */
function isMail ($str) {
    if (!is_string($str))
	return false;
    return preg_match('/^[a-z0-9._]{1,20}@{1}[a-z0-9._]{1,20}$/i', $str) == 1;
}



/**
 * Needs a token and a complete, valid form
 * 
 * requiered: token, username, password, passwordConfirmation
 * not requiered: prenom, nom, email
 */

$createUserState = -1; //-1 error, -2 username already taken, -3 email already taken, 0 success

$_SESSION['token']->formToken();
//We need a token and an instance of the class token
if (isset($_POST['token']) && isset($_SESSION['token'])) {
    //Token check
    if ($_SESSION['token']->verify($_POST['token'])) {
	//We check if the form is complete and valid (TODO: test it)
	if (isset($_POST['username']) &&
	    isUsername($_POST['username']) &&
	    isset($_POST['password']) &&
	    isPassword($_POST['password']) &&
	    isset($_POST['passwordConfirmation']) &&
	    isPassword($_POST['passwordConfirmation']) &&
	    isset($_POST['prenom']) &&
	    isName($_POST['prenom']) &&
	    isset($_POST['nom']) &&
	    isName($_POST['nom']) &&
	    isset($_POST['email']) &&
	    isMail($_POST['email'])) {
	    //From now on, we will consider that the form is complete, valid and
	    //was sent by the owner of the session
	    $_POST['username'] = strtolower($_POST['username']);
	    $_POST['email'] = strtolower($_POST['email']);

	    //First we check if the passwords match
	    if ($_POST['password'] == $_POST['passwordConfirmation']) {
		//Then we check if the username or email is already taken
		$prepared = $bdd->prepare('SELECT username, email FROM membres WHERE username=:username OR email=:email');
		$values = array(":username" => $_POST['username'], ":email" => $_POST['email']);
		if ($prepared->execute($values)) {
		    if ($row = $prepared->fetch()) {
			//Rows were returned, either the email or the username is already taken
			if ($row['username'] == $_POST['username'])
			    $createUserState = -2; //Username already taken
			else
			    $createUserState = -3; //Email already taken
		    } else {
			//No rows were returned, it means that we can add a new user with that username and email
			//First we start by adding a new row with everything but the password, so we can get its id and generate a salt
			$prepared = $bdd->prepare('INSERT INTO membres (username, prenom, nom, email) ' .
						  'VALUES (:username, :prenom, :nom, :email);');
			$values = array(":username" => $_POST['username'],
					":prenom" => $_POST['prenom'],
					":nom" => $_POST['nom'],
					":email" => $_POST['email']);
			if ($prepared->execute($values)) {
			    //Now we get the id of the new user
			    $prepared = $bdd->prepare('SELECT id FROM membres WHERE username=:username');
			    $values = array(":username" => $_POST['username']);
			    if ($prepared->execute($values)) {
				if ($row = $prepared->fetch()) {
				    //We now have the id of the new user, we can hash and salt the password, then add it to the database
				    $id = (int)$row['id'];
				    $salt = substr(hash('md5', $id * 57), 0, 8); //the salt is the first 8 chars of a hash of id * 57
				    $passwd = hash('sha256', $_POST['password'] . $salt);
				    
				    $prepared = $bdd->prepare('UPDATE membres SET password=:password WHERE id=:id');
				    $values = array(":password" => $passwd,
						    ":id" => $row['id']);
				    if ($prepared->execute($values)) {
					//The user has been successfully created
					$createUserState = 0; //Success !
				    }
				}
			    }
			}
		    }
		}
	    }
	}
    }
}

echo $createUserState;

?>
