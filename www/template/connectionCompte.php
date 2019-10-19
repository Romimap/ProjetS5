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
 * password regex: /^[a-zA-Z0-9!@#._]{2,20}$/
 * alphanumeric and !@#._    , 8-20 chars, case sensitive
 */
function isPassword ($str) {
    if (!is_string($str))
	return false;
    return preg_match('/^[a-zA-Z0-9!@#._]{8,20}$/', $str) == 1;
}


/**
 * Needs a token and a complete, valid form
 * 
 * token, username, password
 */

$connectUserState = -1; //-1 error, -2 username or password dont match, 0 success

$_SESSION['token']->formToken();

//We need a token and an instance of the class token
if (isset($_POST['token']) && isset($_SESSION['token'])) {
    //Token check
    if ($_SESSION['token']->verify($_POST['token'])) {
	//We check if the form is complete and valid
	if (isset($_POST['username']) &&
	isUsername($_POST['username']) &&
	isset($_POST['password']) &&
	isPassword($_POST['password'])) {
	    //From now on, we will consider that the form is complete, valid and
	    //was sent by the owner of the session

	    //We want usernames to be case insensitive, user TotO = user toto
	    $_POST['username'] = strtolower($_POST['username']);
	    
	    //First we check if the user exists
	    $prepared = $bdd->prepare('SELECT id, password, username FROM users WHERE username=:username');
	    $values = array(":username" => $_POST['username']);	
	    if ($prepared->execute($values)) {
		if ($row = $prepared->fetch()) {
		    //The user exists, we use its id to calculate its hashed and salted password
		    //We now have the id of the new user, we can hash and salt the password, then add it to the database
		    $id = (int)$row['id'];
		    $salt = substr(hash('md5', $id * 57), 0, 8); //the salt is the first 8 chars of a hash of id * 57
		    $passwd = hash('sha256', $_POST['password'] . $salt);
		    
		    //Now that we have a hashed password, we compare it with the database
		    if ($passwd == $row['password']) {
			//We can now connect the user
			/* We set an aditionnal cookie to prevent a php session steal, it is a pretty bad workaround but https isn't available
			 *if we have a missmatch between the serverside token and the clientside token, the session will be killed.*/
			/* Each time the client requests a new page, the server will generate a new token, making it impossible for two people
			 *to browse on the website at the same time.*/
			$_SESSION['userToken'] = new token;
			if (setcookie("userToken", $_SESSION['userToken']->nextToken(), time() + 3600, '/')) {
			    //We store informations about the user, as its username, his role ... etc
			    $_SESSION['userInfo'] = array("username" => $row['username']);
			    $connectUserState = 0;
			    //The user is now connected ! To check if the user is connected, we can compare the cookie with the serverside token
			}
		    } else {
			//Password missmatch
			$connectUserState = -2;
		    }
		} else {
		    //Username missmatch
		    $connectUserState = -2;
		}
	    }
	}
    }
}	    

echo $connectUserState;

?>
