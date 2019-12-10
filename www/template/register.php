<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . 'template/sql.php');
require($WWWPATH . 'template/token.php');
session_start();
var_dump($_POST);
echo '<br>' . $_SESSION['token']->nextToken();
echo 'p';
//We check if we have a token
if (isset($_POST['token']) && isset($_SESSION['token'])) {
    echo 'a';
    //Token check
    if ($_SESSION['token']->verify($_POST['token'])) {
        echo 'b';
        //we check if the form is valid
        if (isset($_POST['id']) && is_numeric($_POST['id'])
        && isset($_SESSION['userInfo']['id']) && is_numeric($_SESSION['userInfo']['id'])) {
            //the form is safe
            //First we check that the user isnt already registered to this events
            $prepared = $bdd->prepare("SELECT id FROM inscriptions WHERE id_membre=:idm AND id_evenement=:ide");
            $values = array(':idm' => $_SESSION['userInfo']['id'], ':ide' => $_POST['id']);
            if ($prepared->execute($values)) {
                if ($row = $prepared->fetch()) {
                    //The user is already registered to this event
                    header('location: ../PageEvenement.php?id='.$_POST['id']);
                }
            }
            //We can now register the client
            $prepared = $bdd->prepare("INSERT INTO inscriptions (id_membre, id_evenement) VALUES (:idm, :ide)");

            if ($prepared->execute($values)) {
                //The user is now registered to the event
                header('location: ../PageEvenement.php?id='.$_POST['id']);
            } else {
                //The user is not registered
                header('location: ../PageEvenement.php?id='.$_POST['id']);
            }
        }
    }
}

 ?>
