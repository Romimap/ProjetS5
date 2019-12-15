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

            //If there is no values for min or max
            if ($_POST['min'] == "") {
                $_POST['min'] = "-1";
            }
            if ($_POST['max'] == "") {
                $_POST['max'] = "-1";
            }

            //We invert min and max if max < min
            if ($_POST['max'] < $_POST['min']) {
                $tmp = $_POST['max'];
                $_POST['max'] = $_POST['min'];
                $_POST['min'] = $tmp;
            }

            //We try to insert a new event, quoting the dangerous values
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
                //The event is now created we try to add the files to the server and database
                $last_id = $bdd->lastInsertId();
                var_dump($_FILES);
                foreach ($_FILES['eventFile']['error'] as $k => $v) { //For each file
                    if (!$v) { //If there is no error
                        $target_dir = "uploadedFiles/";
                        $target_fname = rand();
                        $target_file = $target_dir . basename($_FILES["eventFile"]["name"][$k]);
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                        $uploadOk = 1;

                        // Check if image file is a actual image or fake image
                        $check = getimagesize($_FILES["eventFile"]["tmp_name"][$k]);
                        if($check !== false) {
                            echo "File is an image - " . $check["mime"] . ".";
                            $uploadOk = 1;
                        } else {
                            echo "File is not an image.";
                            $uploadOk = 0;
                        }

                        // Check if file already exists
                        for ($i = 0; $i < 100; $i++) {
                            if (!file_exists($target_dir . $target_fname . $i . '.' . $imageFileType)) { //We try to find a valid name
                                $target_fname = $target_fname . $i;
                                break;
                            }
                            if ($i == 99) { //If the loop ended, we cannot upload
                                $uploadOk = 0;
                                break;
                            }
                        }

                        $target_file = $target_dir . $target_fname . '.' . $imageFileType;

                        // Check file size
                        if ($_FILES["eventFile"]["size"][$k] > 500000) {
                            echo "Sorry, your file is too large.";
                            $uploadOk = 0;
                        }

                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif" ) {
                            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $uploadOk = 0;
                        }

                        // Check if $uploadOk is set to 0 by an error
                        if ($uploadOk == 0) {
                            echo "Sorry, your file was not uploaded.";

                        // if everything is ok, try to upload file
                        } else {
                            if (move_uploaded_file($_FILES["eventFile"]["tmp_name"][$k], $target_file)) {
                                echo "The file ". basename( $_FILES["eventFile"]["name"][$k]). " has been uploaded.";
                                //We now try to add the file to the database
                                $prepared = $bdd->prepare("INSERT INTO photos (id_evenement, lien) VALUES (:ide, :link)");
                                $values = array(':ide' => $last_id, ':link' => $target_file);
                                if ($prepared->execute($values)) {
                                    //upload + query ok
                                }
                            } else {
                                echo "Sorry, there was an error uploading your file.";
                            }
                        }
                    }
                }
                header("location: ../EventList.php");
            }


            exit(0);

        }
    }
}
?>
