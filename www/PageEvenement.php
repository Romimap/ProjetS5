<!-- PAGE TEMPLATE -->
<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
?>
<!doctype html>
<html lang="fr">
    <head>
	<?php include($WWWPATH . "template/head.html"); ?>
    <link rel="stylesheet" type="text/css" href="css/pageevent.css" media="screen"/>
    <script src="https://kit.fontawesome.com/1fcdee38a3.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function starChange(n) {
            switch (n) {
                case 1:
                    document.getElementById("star1").className="fa fa-star starchecked";
                    document.getElementById("star2").className="fa fa-star";
                    document.getElementById("star3").className="fa fa-star";
                    document.getElementById("star4").className="fa fa-star";
                    document.getElementById("star5").className="fa fa-star";
                    break;
                case 2:
                    document.getElementById("star1").className="fa fa-star starchecked";
                    document.getElementById("star2").className="fa fa-star starchecked";
                    document.getElementById("star3").className="fa fa-star";
                    document.getElementById("star4").className="fa fa-star";
                    document.getElementById("star5").className="fa fa-star";
                    break;
                case 3:
                    document.getElementById("star1").className="fa fa-star starchecked";
                    document.getElementById("star2").className="fa fa-star starchecked";
                    document.getElementById("star3").className="fa fa-star starchecked";
                    document.getElementById("star4").className="fa fa-star";
                    document.getElementById("star5").className="fa fa-star";
                    break;
                case 4:
                    document.getElementById("star1").className="fa fa-star starchecked";
                    document.getElementById("star2").className="fa fa-star starchecked";
                    document.getElementById("star3").className="fa fa-star starchecked";
                    document.getElementById("star4").className="fa fa-star starchecked";
                    document.getElementById("star5").className="fa fa-star";
                    break;
                case 5:
                    document.getElementById("star1").className="fa fa-star starchecked";
                    document.getElementById("star2").className="fa fa-star starchecked";
                    document.getElementById("star3").className="fa fa-star starchecked";
                    document.getElementById("star4").className="fa fa-star starchecked";
                    document.getElementById("star5").className="fa fa-star starchecked";
                    break;
                default:
                    document.getElementById("star1").className="fa fa-star starchecked";
                    document.getElementById("star2").className="fa fa-star starchecked";
                    document.getElementById("star3").className="fa fa-star starchecked";
                    document.getElementById("star4").className="fa fa-star";
                    document.getElementById("star5").className="fa fa-star";
                    n = 3;
                    break;
            }
            document.getElementById("starFormValue").value = n;
        }
    </script>
    <style media="screen">
        .starchecked {
            color: orange;
        }
    </style>
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
        <div class="container mt-5" style="border-top-left-radius: 0; border-top-right-radius: 0; padding: 0" id="container">
            <?php
                //We display the photos
                $prepared = $bdd->prepare("SELECT lien FROM photos WHERE id_evenement=:ide");
                $values = array(':ide' => $_GET['id']);
                if ($prepared->execute($values)) {
                    echo '<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel" style="height: 350px;">
                            <div class="carousel-inner" style="height: 350px;">';
                    if ($img = $prepared->fetch()) {
                        echo '
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="template/' . $img['lien'] . '">
                            </div>
                        ';
                    }
                    while($img = $prepared->fetch()) {
                        echo '
                            <div class="carousel-item">
                                <img class="d-block w-100" src="template/' . $img['lien'] . '">
                            </div>
                        ';
                    }
                    echo '</div>
                        </div>';
                }
            ?>
            <div class="row bg-dark text-light">
                <div class="col">
                    <h1 class="text-center"><?php echo $row['nom']; ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <?php //changing the spaces and the comas as codes
                    $gmapAdr = str_replace (" ", "%20", $row['addresse']);
                    $gmapAdr  = str_replace (",", "%2C", $gmapAdr ); ?>
                    <iframe src="<?php echo "https://maps.google.com/maps?q=" . $gmapAdr . "&hl=fr&z=15&output=embed"; ?>" width="100%" height="640" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
                <div class="col-sm-4 pr-5" id="contact2">
                    <br>
                    <?php if ($row['etat'] == "Annule") {
                        echo '<h3 class="text-danger"> Annulé </h3>';
                    } ?>
                    <h3><?php echo $row['mot']; ?></h3>
                    <hr class="col-6">
                    <br>
                    <i class="fas fa-map-pin"></i><br><?php echo substr($row['addresse'], 1, -1); ?><br>
                    <br>
                    <p><?php echo substr($row['description'], 1, -1); ?></p>
                    <br>
                    <hr class="col-6">
                    <i class="fas fa-user"></i><a href="ProfilePage.php?id=<?php echo $row['uid']; ?>"><?php echo $row['username']; ?></a><br>
                    <br>
                    <?php
                    if ($row['telephone'] != "")
                        echo '<i class="fas fa-phone" style="color:#000"></i>'. $row['telephone']. '<br>';
                    if ($row['email'] != "")
                        echo '<i class="fas fa-envelope"></i>'. $row['email']. '<br>';?>
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
                                        $prepared = $bdd->prepare("SELECT id, note, commentaire FROM inscriptions WHERE
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
                                                    <hr class="col-6">
                                                    <form class="" action="template/comment.php"  method="post">';
                                                        $_SESSION['token']->formToken();
                                                    echo '
                                                        <input type="hidden" name="star" value="3" id="starFormValue">
                                                        <input type="hidden" name="id" value="'. $_GET['id'] .'">
                                                        <span class="fa fa-star starchecked" onclick="starChange(1);" id="star1"></span>
                                                        <span class="fa fa-star starchecked" onclick="starChange(2);" id="star2"></span>
                                                        <span class="fa fa-star starchecked" onclick="starChange(3);" id="star3"></span>
                                                        <span class="fa fa-star" onclick="starChange(4);" id="star4"></span>
                                                        <span class="fa fa-star" onclick="starChange(5);" id="star5"></span><br>
                                                        <div class="form-group">
                                                            <textarea name="comment" maxlength="240" class="form-control col-12" style="resize: none;height: 100px"></textarea>
                                                            <small id="emailHelp" class="form-text text-muted">240 caractères max</small>
                                                        </div>
                                                        <input class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit" value="Laisser un commentaire !">
                                                    </form>
                                                    <br>
                                                    <hr class="col-6">';
                                                    //We now show the comment of the user if it exists
                                                    if ($regRow['note'] != 0) {
                                                        //We print the comment of the user
                                                        echo '
                                                        <p> Votre avis : </p>';
                                                        for ($i = 0; $i < 5; $i++) {
                                                            if ($i < $regRow['note'])
                                                                echo '<span class="fa fa-star starchecked"></span>';
                                                            else
                                                                echo '<span class="fa fa-star"></span>';
                                                        }
                                                        if ($regRow['commentaire'] != "''") {
                                                            echo '
                                                            <p>' . substr($regRow['commentaire'], 1, -1) . '</p>';
                                                        }
                                                    }
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
            <?php
            //We print 5 random comments if the event is finished
            $prepared = $bdd->prepare("SELECT note, commentaire, username FROM inscriptions, membres, evenement
            WHERE inscriptions.id_membre = membres.id
            AND inscriptions.id_evenement = evenement.id
            AND DATEDIFF(NOW(), date_fin) > 0
            AND inscriptions.id_evenement = :ide
            AND inscriptions.id_membre <> :idm
            AND inscriptions.commentaire IS NOT NULL
            AND inscriptions.note BETWEEN 1 AND 5
            ORDER BY RAND()
            LIMIT 5;");
            if (isset($_SESSION['userInfo']['id'])) //If the user is connected, we exclude it from the search
                $idmember = $_SESSION['userInfo']['id'];
            else //If not we exclude the user with id -1, in other words we exclude nobody
                $idmember = -1;
            $values = array(':ide' => $_GET['id'], ':idm' => $idmember);
            if ($prepared->execute($values)) {
                echo '
                <br>
                <br>
                <div class="row">';
                while ($row = $prepared->fetch()) {
                    echo '
                    <div class="col">
                        <p>' . $row['username'] . '</p>';
                        for ($i = 0; $i < 5; $i++) {
                            if ($i < $row['note'])
                                echo '<span class="fa fa-star starchecked"></span>';
                            else
                                echo '<span class="fa fa-star"></span>';
                        }
                    echo '
                        <p>' . substr($row['commentaire'], 1, -1) . '</p>
                    </div>';
                }
                echo '
                </div>';
            }
            ?>
            <br>
        </div>
        <?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
    </body>
</html>
<?php $_SESSION['token']->cycle(); ?>
