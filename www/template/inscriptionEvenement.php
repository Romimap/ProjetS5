<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . 'template/includes.php');
session_start();
# @Author: FOURNIER Romain
# @Date: 12th of October, 2019
# @Email: romain.fournier.095@gmail.com


//requiered: token, id

//We check if the user is connected
if (!isset($_SESSION['userInfo'])) {
    //TODO: Redirection
    exit(0);
}
$registeredStatus = -1; //-1 error, 0 ok
//We need a token and an instance of the class token
if (isset($_POST['token']) && isset($_SESSION['token'])) {
    //Token check
    if ($_SESSION['token']->verify($_POST['token'])) {
        //we check if the form is valid
        if (isset($_POST['id']) && ctype_digit($_POST['id'])) {
            //From now on, we will consider that the form is complete, valid and
    	    //was sent by the owner of the session
            $userId = $_SESSION['userInfo']['id'];
            $eventId = $_POST['id'];
            //We now check if we can register the user to the event
            //id == eventid  &&  now < date_fin  &&  idUser ni inscription (effectif_max == NULL  ||  effectif_max > count(*))
            $prepared = $bdd->prepare("SELECT id FROM evenement
                WHERE id=:idEvent
                AND DATE(NOW()) < DATE(date_fin)
                AND :idUser NOT IN (SELECT id_membre FROM inscriptions WHERE id_evenement=:idEventb)
                AND (effectif_max IS NULL
                    OR effectif_max > (SELECT COUNT(*) FROM inscriptions WHERE id_evenement=:idEventc)
                )");
            $values = array(':idEvent' => $eventId, ':idEventb' => $eventId, ':idEventc' => $eventId, ':idUser' => $userId);
            if ($prepared->execute($values)) {
                //We check that a row was returned
                if ($prepared->fetch()) {
                    //The event exists, isn't finished yet, there is still room for an inscription and the user isn't already registered
                    //We now try to register the user to the event
                    $prepared = $bdd->prepare("INSERT INTO inscriptions (id_evenement, id_membre) VALUES (:idEvent, :idUser)");
                    $values = array(':idEvent' => $eventId, ':idUser' => $userId);
                    if ($prepared->execute($values)) {
                        //The member is now registered
                        $registeredStatus = 0;
                    }
                }
            }
        }
    }
}

echo $registeredStatus;

if ($registeredStatus == 0) {
    //TODO: Redirection
} else {
    //TODO: Redirection
}
?>
