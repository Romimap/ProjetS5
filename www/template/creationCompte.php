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
    echo 'isusername';
    if (!is_string($str))
	return false;
    return preg_match('/^[a-z]{1}\w{4,14}$/i', $str) == 1;
}

/**
 * name regex: /^[a-z]{2,20}$/i
 * letters, 2-20 chars, case insensitive
 */
function isName ($str) {
    echo 'isNAME';
    if (!is_string($str))
	return false;
    return preg_match('/^[a-z]{2,20}$/i', $str) == 1;
}

/**
 * password regex: /^[a-zA-Z0-9!@#._]{2,20}$/
 * alphanumeric and !@#._    , 8-20 chars, case sensitive
 */
function isPassword ($str) {
    echo 'isPW';
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
    echo 'is@';
    if (!is_string($str))
	return false;
    return preg_match('/^[a-z0-9._]{1,20}@{1}[a-z0-9._]{1,20}$/i', $str) == 1;
}



/**
 * Needs a token and a complete, valid form
 * 
 * token, username, password, passwordConfirmation, firstName, lastName, email, city
 */

$createUserState = -1; //-1 error, -2 username already taken, -3 email already taken, 0 success

$_SESSION['token']->formToken();
echo 'x';
//We need a token and an instance of the class token
if (isset($_POST['token']) && isset($_SESSION['token'])) {
    echo 'a';
    //Token check
    if ($_SESSION['token']->verify($_POST['token'])) {
	echo 'b';
	//We check if the form is complete and valid (TODO: test it)
	if (isset($_POST['username']) &&
	    isUsername($_POST['username']) &&
	    isset($_POST['password']) &&
	    isPassword($_POST['password']) &&
	    isset($_POST['passwordConfirmation']) &&
	    isPassword($_POST['passwordConfirmation']) &&
	    isset($_POST['firstName']) &&
	    isName($_POST['firstName']) &&
	    isset($_POST['lastName']) &&
	    isName($_POST['lastName']) &&
	    isset($_POST['email']) &&
	    isMail($_POST['email']) &&
	    isset($_POST['city']) &&
	    isName($_POST['city'])) {
	    //From now on, we will consider that the form is complete, valid and
	    //was sent by the owner of the session
	    echo 'c';
	    $_POST['username'] = strtolower($_POST['username']);
	    $_POST['email'] = strtolower($_POST['email']);

	    //First we check if the passwords match
	    if ($_POST['password'] == $_POST['passwordConfirmation']) {
		echo 'd';
		//Then we check if the username or email is already taken*
		$prepared = $bdd->prepare('SELECT username, email FROM users WHERE username=:username OR email=:email');
		$values = array(":username" => $_POST['username'], ":email" => $_POST['email']);
		echo 'X';
		if ($prepared->execute($values)) {
		    echo 'X';
		    if ($row = $prepared->fetch()) {
			echo 'e';
			var_dump($row);
			//Rows were returned, either the email or the username is already taken
			if ($row['username'] == $_POST['username'])
			    $createUserState = -2; //Username already taken
			else
			    $createUserState = -3; //Email already taken
		    } else {
			echo 'f';
			//No rows were returned, it means that we can add a new user with that username and email
			//First we start by adding a new row with everything but the password, so we can get its id and generate a salt
			$prepared = $bdd->prepare('INSERT INTO users (username, firstname, lastname, email, city) ' .
						  'VALUES (:username, :firstname, :lastname, :email, :city);');
			$values = array(":username" => $_POST['username'],
					":firstname" => $_POST['firstName'],
					":lastname" => $_POST['lastName'],
					":email" => $_POST['email'],
					":city" => $_POST['city'],);
			if ($prepared->execute($values)) {
			    echo 'g';
			    //Now we get the id of the new user
			    $prepared = $bdd->prepare('SELECT id FROM users WHERE username=:username');
			    $values = array(":username" => $_POST['username']);
			    if ($prepared->execute($values)) {
				if ($row = $prepared->fetch()) {
				    echo 'h';
				    //We now have the id of the new user, we can hash and salt the password, then add it to the database
				    $id = (int)$row['id'];
				    $salt = substr(hash('md5', $id * 57), 0, 8); //the salt is the first 8 chars of a hash of id * 57
				    $passwd = hash('sha256', $_POST['password'] . $salt);
				    
				    $prepared = $bdd->prepare('UPDATE users SET password=:password WHERE id=:id');
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
print_r($bdd->errorInfo());
echo $createUserState;

?>
