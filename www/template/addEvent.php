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
    echo 'a';
    //Token check
    if ($_SESSION['token']->verify($_POST['token'])) {
        echo 'b';
        var_dump($_POST);
    	//We check if the form is complete and valid
        if (isset($_SESSION['userInfo']['role']) && $_SESSION['userInfo']['role'] == 'Contributeur'
            && isset($_POST['name'])
            && preg_match('/^[a-z0-9\s.,\']*$/i', $_POST['name']) //alphanum with space and quotes (dangerous)
            && isset($_POST['event-start']) && $_POST['event-start'] != "" //there is a date
            && isset($_POST['event-end'])
            && isset($_POST['description'])
            && preg_match('/^[a-z0-9\s.,\']*$/i', $_POST['description']) //alphanum with space and quotes (dangerous)
            && isset($_POST['adresse'])
            && preg_match('/^[a-z0-9\s.,\']*$/i', $_POST['adresse']) //alphanum with space and quotes (dangerous)
            && isset($_POST['gps']) //dangerous
            && isset($_POST['min']) && ($_POST['min'] == "" || is_numeric($_POST['min']))
            && isset($_POST['max']) && ($_POST['max'] == "" || is_numeric($_POST['max']))
            && isset($_POST['theme']) && is_numeric($_POST['theme'])) {
            //The form is complete, but there are still dangerous values

            //First we convert the dates to the mysql format
            $dateDebut=date("Y-m-d H:i:s",strtotime($_POST['event-start']));
            if ($_POST['event-end'] == "") {
                //If there is no end date, we set it as the beggining
                $dateFin = $dateDebut;
            } else {
                $dateFin=date("Y-m-d H:i:s",strtotime($_POST['event-end']));
                if (strtotime($_POST['event-start']) > strtotime($_POST['event-end'])) {
                    //If there is an end date, and if the end date is before the begining, we switch the dates
                    $tmp = $dateFin;
                    $dateFin = $dateDebut;
                    $dateDebut = $tmp;
                }
            }
            //We now try to insert a new event, quoting the dangerous values
            $prepared = $bdd->prepare("INSERT INTO evenement (id, id_mot_clef, id_membre, nom, description, addresse, gps, date_debut, date_fin, effectif_min, effectif_max)
                                    VALUES (NULL, :idt, :idm, :nom, :descr, :adr, :gps, :dated, :datef, :min, :max)");
            $values = array (
              ':idt'    => $_POST['theme']
            , ':idm'    => $_SESSION['userInfo']['id']
            , ':nom'    => $bdd->quote($_POST['name'])
            , ':descr'  => $bdd->quote($_POST['description'])
            , ':adr'    => $bdd->quote($_POST['adresse'])
            , ':gps'    => $bdd->quote($_POST['gps'])
            , ':dated'  => $dateDebut
            , ':datef'  => $dateFin
            , ':min'    => $_POST['min']
            , ':max'    => $_POST['max']
            );
            if ($prepared->execute($values)) {
                echo 'ok';
            }
        }
    }
}
?>
