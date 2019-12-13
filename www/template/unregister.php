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
        if (isset($_POST['id']) && ctype_digit($_POST['id'])
        && isset($_SESSION['userInfo']['id']) && ctype_digit($_SESSION['userInfo']['id'])) {
            //the form is safe
            //We can now unregister the client
            $prepared = $bdd->prepare("DELETE FROM inscriptions WHERE id_membre=:idm AND id_evenement=:ide");
            $values = array(':idm' => $_SESSION['userInfo']['id'], ':ide' => $_POST['id']);
            if ($prepared->execute($values)) {
                //The user is now unregistered to the event
                header('location: ../PageEvenement.php?id='.$_POST['id']);
            } else {
                //an error occured
                header('location: ../PageEvenement.php?id='.$_POST['id']);
            }
        }
    }
}
?>
