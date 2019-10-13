<?php
# @Author: FOURNIER Romain
# @Date:   9th of October, 2019
# @Email:  romain.fournier.095@gmail.com


  /**
  * a simple token class used to put tokens into forms
  */
class token {
    private $_token;
    private $_nextToken;
    
    function __construct () {
	$this->_token = null;
	$this->_nextToken = hash('md5', rand()); //Generate a token
    }
    
    /**
     * returns the next token
     */
    function nextToken() {
	return $this->_nextToken;
    }

    function formToken() {
	echo '<input type="hidden" name="token" value="' . $this->_nextToken . '"/>';
    }

    /**
     * returns true if the token given is valid
     */
    function verify($tokenToVerify) {
	return $this->_token == $tokenToVerify;
    }

    /**
     * cycles the tokens, a new one is generated
     */
    function cycle() {
	$this->_token = $this->_nextToken;
	$this->_nextToken = hash('md5', rand());
    }
}

 ?>
