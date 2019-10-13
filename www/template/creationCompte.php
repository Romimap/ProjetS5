<?php
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
    if (!preg_match('/^[a-z]{1}\w{4, 14}$/i', $str))
	return false;
    return true;
}

/**
 * name regex: /^[a-z]{2,20}$/i
 * letters, 5-20 chars, case insensitive
 */
function isName ($str) {
    if (!is_string($str))
	return false;
    if (!preg_match('/^[a-z]{2,20}$/i', $str))
	return false;
    return true;
}

/**
 * password regex: /^[a-zA-Z0-9!@#._]{2,20}$/
 * alphanumeric and !@#._    , 8-20 chars, case sensitive
 */
function isPassword ($str) {
    if (!is_string($str))
	return false;
    if (!preg_match('/^[a-zA-Z0-9!@#._]{2,20}$/', $str))
	return false;
    return true;
}

/**
 * mail regex: /^[a-z0-9._]{1,20}@{1}[a-z0-9._]{1,20}$/i
 * alphanumeric + underscore + dot  @  alphanumeric + underscore + dot, 5-50 chars, case insensitive
 */
function isMail ($str) {
    if (!is_string($str))
	return false;
    if (!preg_match('/^[a-z0-9._]{1,20}@{1}[a-z0-9._]{1,20}$/i', $str))
	return false;
    return true;
}



/**
 * Needs a token and a complete, valid form
 * token: $_POST['token']
 */

//We need a token and an instance of the class token
if (isset($_POST['token'] && isset($_SESSION['tokenInstance'])) {
    //Token check
    if ($_SESSION['tokenInstance']->verify($_POST['token'])) {
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
	    //From now on, we will consider that the form is complete, valid and\
	    //was sent by the owner of the session
	    
	}
    }
}

?>
