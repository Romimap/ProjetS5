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
        if (isset($_SESSION['userInfo']['role']) && $_SESSION['userInfo']['role'] == 'Contributeur'
        && isset($_POST['id']) && ctype_digit($_POST['id'])) {
            //We toggle the canceled flag for this event
            $prepared = $bdd->prepare("UPDATE evenement
            SET etat=IF(etat=\"Normal\", \"Annule\", \"Normal\")
            WHERE id=:id");
            $values = array(':id' => $_POST['id']);
            if ($prepared->execute($values)) {
                header("location: ../PageEvenement.php?id=$_POST[id]");
            }
        }
    }
}
echo 'error';
?>
