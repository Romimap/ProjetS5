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
        if (!(isset($_GET['id']) && is_numeric($_GET['id']))) {
            //If we dont have an id to work with, we redirect
            header('location: EventList.php');
        }
        $prepared = $bdd->prepare("SELECT membres.id as uid, username, evenement.nom, mot, description, email, telephone, addresse, gps
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
                    <iframe src="<?php echo "https://maps.google.com/maps?q=" . $row['addresse'] . "&hl=fr&z=15&output=embed"; ?>" width="100%" height="640" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
                <div class="col-sm-4" id="contact2">
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
                    <?php //We check if the user is connected
                    if (isset($_SESSION['userInfo']['id']) && is_numeric($_SESSION['userInfo']['id'])) {
                        //then we check if the user is registered for this event
                        $prepared = $bdd->prepare("SELECT id FROM inscriptions WHERE id_evenement=:ide
                        AND id_membre=:idm");
                        $values = array(':ide' => $_GET['id'], ':idm' => $_SESSION['userInfo']['id']);
                        if ($prepared->execute($values)) {
                            if ($row = $prepared->fetch()) {
                                //The user is registered for this event, we show him the unregister form
                                echo '
                                <form class="" action="template/unregister.php" method="post">';
                                    $_SESSION['token']->formToken();
                                echo '
                                    <input type="hidden" name="id" value="'. $_GET['id'] .'">
                                    <input class="btn btn-lg btn-danger btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit" value="Se désinscrire">
                                </form>';
                            } else {
                                //The user is not registered for this event, we show him the register form
                                echo '
                                <form class="" action="template/register.php" method="post">';
                                    $_SESSION['token']->formToken();
                                echo '
                                    <input type="hidden" name="id" value="'. $_GET['id'] .'">
                                    <input class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit" value="s\'inscrire">
                                </form>';
                            }
                        }
                    } ?>
                </div>
            </div>
        </div>
        <?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
    </body>
</html>
<?php $_SESSION['token']->cycle(); ?>
