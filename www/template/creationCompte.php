<?php
# @Author: FOURNIER Romain
# @Date: 12th of October, 2019
# @Email: romain.fournier.095@gmail.com

/**
 * Needs a token and a complete, valid form
 * token: $_POST['token']
 */

//We need a token and an instance of the class token
if (isset($_POST['token'] && isset($_SESSION['tokenInstance'])) {
    //Token check
    if ($_SESSION['tokenInstance']->verify($_POST['token'])) {
	//We check if the form is complete and valid (TODO: test it)
	if (//Username, alphanumeric, starts with a letter
	    isset($_POST['username']) &&
	    preg_match("^[a-zA-Z]+[a-zA-Z0-9]*", $_POST['username']) &&
	    //Password, alphanumeric
	    isset($_POST['password']) &&
	    preg_match("[a-zA-Z0-9]*", $_POST['password']) &&
	    //Password Confirmation, alphanumeric
	    isset($_POST['passwordConfirmation']) &&
	    preg_match("[a-zA-Z0-9]*", $_POST['passwordConfirmation']) &&
	    //First name, Alphabetic
	    isset($_POST['firstName']) &&
	    preg_match("[A-Za-z]*", $_POST['firstName']) &&
	    //Last name, Alphabetic
	    isset($_POST['lastName']) &&
	    preg_match("[A-Za-z]*", $_POST['lastName']) &&
	    //Email, Alphanumeric+(._)  @  Alphanumeric+(._)  .  Alphabetic
	    isset($_POST['email']) &&
	    preg_match("[A-Za-z0-9._]*+@+[A-Za-z0-9._]*+.+[a-z]*", $_POST['email']) &&
	    //City, Alphabetic
	    isset($_POST['city'] &&)
	    preg_match("[A-Za-z]*", $_POST['city'])) {
	    //From now on, we will consider that the form is complete, valid and
	    //was sent by the owner of the session
	    
	}
    }
}

?>
