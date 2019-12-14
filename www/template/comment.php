<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . 'template/sql.php');
require($WWWPATH . 'template/token.php');
session_start();
# @Author: FOURNIER Romain
# @Date: 11th of December, 2019
# @Email: romain.fournier.095@gmail.com

//We need a token and an instance of the class token
if (isset($_POST['token']) && isset($_SESSION['token'])) {
    //Token check
    if ($_SESSION['token']->verify($_POST['token'])) {
    	//We check if the form is complete and valid
        if (isset($_SESSION['userInfo']['role']) && $_SESSION['userInfo']['role'] == 'Visiteur'
        && isset($_SESSION['userInfo']['id']) && is_int($_SESSION['userInfo']['id'])
        && isset($_POST['id']) && ctype_digit($_POST['id'])
        && isset($_POST['star']) && ctype_digit($_POST['star'])
        && isset($_POST['comment']) && strlen($_POST['comment']) <= 240) {
            $_POST['comment'] = $bdd->quote($_POST['comment']);
            //From now on we have a valid form and safe values
            //We now try to update the note and comment for that inscription
            $prepared = $bdd->prepare("UPDATE inscriptions SET commentaire=IF(:comment='', null, :comment1), note=:star
            WHERE id_evenement=:ide AND id_membre=:idm");
            $values = array(
                ':comment'  => $_POST['comment'],
                ':comment1' => $_POST['comment'],
                ':star'     => $_POST['star'],
                ':idm'      => $_SESSION['userInfo']['id'],
                ':ide'      => $_POST['id']);
            if ($prepared->execute($values)) {
                //everything went well, we redirect the user
                header("location: ../PageEvenement.php?id=$_POST[id]");
            }
        }
    }
}
