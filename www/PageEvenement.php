<!-- PAGE TEMPLATE -->
<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
?>
<!doctype html>
<html lang="fr">
    <head>
	<?php include($WWWPATH . "template/head.html"); ?>
    <link rel="stylesheet" type="text/css" href="css/pageevent.css" media="screen" />
  </head>
     <body>
        <?php include($WWWPATH . "template/menu/menu.php"); ?>
        <?php
        if (!(isset($_GET['id']) && ctype_digit($_GET['id']))) {
            //If we dont have an id to work with, we redirect
            header('location: EventList.php');
        }
        $prepared = $bdd->prepare("SELECT membres.id as uid, username, evenement.nom, mot, description, email, telephone, addresse, etat
            FROM evenement, membres, taxonomie
            WHERE evenement.id_membre = membres.id AND evenement.id_mot_clef = taxonomie.id
            AND evenement.id = :id");
        $values = array(':id' => $_GET['id']);
        if ($prepared->execute($values)) {
            if ($row = $prepared->fetch()) {
                //The query executed and returner at least a row, we can display the page
            } else {
                header('location: EventList.php');
            }
        } else {
            header('location: EventList.php');
        }
        ?>
        <div class="container mt-5" id="container">
            <h1 class="text-center"><?php echo $row['nom']; ?></h1>
            <hr>
            <div class="row">
                <div class="col-sm-8">
                    <?php //changing the spaces and the comas as codes
                    $gmapAdr = str_replace (" ", "%20", $row['addresse']);
                    $gmapAdr  = str_replace (",", "%2C", $gmapAdr ); ?>
                    <iframe src="<?php echo "https://maps.google.com/maps?q=" . $gmapAdr . "&hl=fr&z=15&output=embed"; ?>" width="100%" height="640" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
                <div class="col-sm-4" id="contact2">
                    <?php if ($row['etat'] == "Annule") {
                        echo '<h3 class="text-danger"> Annulé </h3>';
                    } ?>
                    <h3><?php echo $row['mot']; ?></h3>
                    <hr class="col-6">
                    <br>
                    <i class="fas fa-globe" style="color:#000"></i><?php echo $row['addresse']; ?><br>
                    <br>
                    <p><?php echo $row['description']; ?></p>
                    <br>
                    <hr class="col-6">
                    <i class="fas fa-phone" style="color:#000"></i> <a href="ProfilePage.php?id=<?php echo $row['uid']; ?>"><?php echo $row['username']; ?></a><br>
                    <br>
                    <?php
                    if ($row['telephone'] != "")
                        echo '<i class="fas fa-phone" style="color:#000"></i>'. $row['telephone']. '<br>';
                    if ($row['email'] != "")
                        echo '<i class="fas fa-phone" style="color:#000"></i>'. $row['email']. '<br>';?>
                    <br>
                    <?php
                    //Here we display the form on the bottom of the page
                    // Cancel: if the user is the owner of the event, the event is on the normal state and the event isn't finished yet
                    // Reenact: if the user is the owner, the event is on the canceled state and the event isnt finished yet
                    // Register: the user is a visitor, the user isnt registered and the event isn't finished
                    // Unegister: the user is a visitor, the user is registered and the event isn't finished
                    // Comment: the user is a visitor, the user is registered and the event is finished

                    //We check if the user is connected
                    if (isset($_SESSION['userInfo']['id']) && is_int($_SESSION['userInfo']['id'])) {
                        //then we check if the user is a contributor
                        if ($_SESSION['userInfo']['role'] == 'Contributeur') {
                            //the user is a contributor, we check if the user made this event, and if this event is still pending
                            $prepared = $bdd->prepare("SELECT id, etat FROM evenement WHERE id=:ide
                            AND id_membre=:idm AND DATEDIFF(NOW(), date_fin) < 0");
                            $values = array(':ide' => $_GET['id'], ':idm' => $_SESSION['userInfo']['id']);
                            if ($prepared->execute($values)) {
                                if ($row = $prepared->fetch()) {
                                    //The request returned a row, it means that the user created this event, and that the event is still pending
                                    if ($row['etat'] == "Normal") {
                                        //we display the cancel button
                                        echo '
                                        <form class="" action="template/cancelEvent.php" method="post">';
                                            $_SESSION['token']->formToken();
                                        echo '
                                            <input type="hidden" name="id" value="'. $_GET['id'] .'">
                                            <input class="btn btn-lg btn-danger btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit" value="Annuler l\'evenement">
                                        </form>';
                                    } else {
                                        //we display the reenact button
                                        echo '
                                        <form class="" action="template/cancelEvent.php" method="post">';
                                            $_SESSION['token']->formToken();
                                        echo '
                                            <input type="hidden" name="id" value="'. $_GET['id'] .'">
                                            <input class="btn btn-primary btn-lg btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit" value="Reconstituer l\'evenement">
                                        </form>';
                                    }

                                }
                            }
                        } else if ($_SESSION['userInfo']['role'] == 'Visiteur'){
                            //the user is a visitor, we check if the event is canceled or isn't pending anymore
                            $prepared = $bdd->prepare("SELECT etat, DATEDIFF(NOW(), date_fin) AS dateDiff FROM evenement WHERE id=:ide");
                            $values = array(':ide' => $_GET['id']);
                            if ($prepared->execute($values)) {
                                if ($row = $prepared->fetch()) {
                                    if ($row['etat'] == "Normal") {
                                        // the event isnt canceled
                                        //we can now check if the user is registered for this event
                                        $prepared = $bdd->prepare("SELECT id FROM inscriptions WHERE
                                            id_evenement=:ide AND id_membre=:idm");
                                        $values = array(':ide' => $_GET['id'], ':idm' => $_SESSION['userInfo']['id']);
                                        if ($prepared->execute($values)) {
                                            if ($regRow = $prepared->fetch()) {
                                                if ($row['dateDiff'] < 0) {
                                                    //the event is still to end
                                                    //The user is registered for this event, we show him the unregister form
                                                    echo '
                                                    <form class="" action="template/unregister.php" method="post">';
                                                        $_SESSION['token']->formToken();
                                                    echo '
                                                        <input type="hidden" name="id" value="'. $_GET['id'] .'">
                                                        <input class="btn btn-lg btn-danger btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit" value="Se désinscrire">
                                                    </form>';
                                                } else {
                                                    //The event is finished, we display the comment form
                                                    echo '
                                                    <form class="" action="template/unregister.php" method="post">';
                                                        $_SESSION['token']->formToken();
                                                    echo '
                                                        <input type="hidden" name="id" value="'. $_GET['id'] .'">
                                                        <input class="btn btn-lg btn-danger btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit" value="COMMENT">
                                                    </form>';
                                                }
                                            } else {
                                                //The user is not registered for this event
                                                if ($row['dateDiff'] < 0) {
                                                    //The event isn't finished yet, we show him the register form
                                                    echo '
                                                    <form class="" action="template/register.php" method="post">';
                                                        $_SESSION['token']->formToken();
                                                    echo '
                                                        <input type="hidden" name="id" value="'. $_GET['id'] .'">
                                                        <input class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit" value="s\'inscrire">
                                                    </form>';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                     ?>
                </div>
            </div>
        </div>
        <?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
    </body>
</html>
<?php $_SESSION['token']->cycle(); ?>
