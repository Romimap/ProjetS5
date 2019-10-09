<?php
# @Author: FOURNIER Romain
# @Date:   9th of October, 2019
# @Email:  romain.fournier.095@gmail.com


  /**
  * a simple token class used to put tokens into forms
  */
  public class token {
    private $_token;
    private $_nextToken;

    __construct () {
      $_token = null;
      $_nextToken = hash('md5', rand()); //Generate a token
    }

    /**
    * returns the next token
    */
    function nextToken() {
      return $_nextToken;
    }

    function formToken() {
      echo '<input type="hidden" name="token" value="' . $_nextToken . '"';
    }

    /**
    * returns true if the token given is valid
    */
    function verify($tokenToVerify) {
      return $_token == $tokenToVerify;
    }

    /**
    * cycles the tokens, a new one is generated
    */
    function cycle() {
      $_token = $_nextToken;
      $_nextToken = hash('md5', rand());
    }
  }
 ?>
