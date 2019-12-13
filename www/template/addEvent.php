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
            && isset($_POST['name'])//(dangerous)
            && isset($_POST['event_start']) && $_POST['event_start'] != "" //there is a date
            && isset($_POST['event_end'])
            && isset($_POST['description'])//(dangerous)
            && isset($_POST['adresse'])//(dangerous)
            && isset($_POST['min']) && ($_POST['min'] == "" || ctype_digit($_POST['min']))
            && isset($_POST['max']) && ($_POST['max'] == "" || ctype_digit($_POST['max']))
            && isset($_POST['theme']) && ctype_digit($_POST['theme'])) {
            //The form is complete, but there are still dangerous values

            //First we convert the dates to the mysql format
            $dateDebut=date("Y-m-d H:i:s",strtotime($_POST['event_start']));
            if ($_POST['event_end'] == "") {
                //If there is no end date, we set it as the beggining
                $dateFin = $dateDebut;
            } else {
                $dateFin=date("Y-m-d H:i:s",strtotime($_POST['event_end']));
                if (strtotime($_POST['event_start']) > strtotime($_POST['event_end'])) {
                    //If there is an end date, and if the end date is before the begining, we switch the dates
                    $tmp = $dateFin;
                    $dateFin = $dateDebut;
                    $dateDebut = $tmp;
                }
            }

            echo $dateDebut . "<br>" . $dateFin;

            //If there is no values for min or max
            if ($_POST['min'] == "") {
                $_POST['min'] = "-1";
            }
            if ($_POST['max'] == "") {
                $_POST['max'] = "-1";
            }

            //We now try to insert a new event, quoting the dangerous values
            $prepared = $bdd->prepare("INSERT INTO evenement (id, id_mot_clef, id_membre, nom, description, addresse, date_debut, date_fin, effectif_min, effectif_max)
                                    VALUES (NULL, :idt, :idm, :nom, :descr, :adr, :dated, :datef, :min, :max)");
            $values = array (
              ':idt'    => $_POST['theme']
            , ':idm'    => $_SESSION['userInfo']['id']
            , ':nom'    => $bdd->quote($_POST['name'])
            , ':descr'  => $bdd->quote($_POST['description'])
            , ':adr'    => $bdd->quote($_POST['adresse'])
            , ':dated'  => $dateDebut
            , ':datef'  => $dateFin
            , ':min'    => ($_POST['min'] != "") ? $_POST['min'] : null
            , ':max'    => ($_POST['max'] != "") ? $_POST['min'] : null
            );
            if ($prepared->execute($values)) {
                header("location: ../EventList.php");
            }
        }
    }
}
?>
