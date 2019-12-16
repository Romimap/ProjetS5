<!-- PAGE TEMPLATE -->
<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
?>
<!doctype html>
<html lang="fr">
    <head>
        <?php include($WWWPATH . "template/head.html"); ?>
        <!-- HEAD -->
    </head>
    <body>
        <!-- BODY -->
        <?php include($WWWPATH . "template/menu/menu.php") ?>

        <?php
        //page display
    	require($WWWPATH . "template/sql.php");
        //We check that GET[id] contains a numeric value, if not we try to set it as the id of the user
    	if (!(isset($_GET['id']) && ctype_digit($_GET['id']))) {
            if (isset($_SESSION['userInfo']['id']) && is_int($_SESSION['userInfo']['id'])) {
                $_GET['id'] = $_SESSION['userInfo']['id'];
            } else {
                //if not we exit
                exit(0);
            }
    	}
        //From now on we consider $_GET['id'] valid
    	$prepared = $bdd->prepare("SELECT nom, prenom, username, role, email, ville, adresse, telephone FROM membres WHERE id=:id");
    	$array=array(":id" => $_GET['id']);
    	if ($prepared->execute($array)) {
    	    if ($row = $prepared->fetch()) {
                //The request executed and returned a line
                ?>

        <div class="container py-4 my-2">
            <div class="row">
                <div class="col-md-4 pr-md-5">
                    <img class="w-100 rounded border" src="https://icon-library.net/images/user-png-icon/user-png-icon-10.jpg" />
                    <div class="pt-4 mt-2">
                        <section class="mb-4 pb-1">
                            <?php //Event history display
                            if ($row['role'] == 'Contributeur') { //Created events
                                    echo '<h3 class="h6 font-weight-light text-secondary text-uppercase">Evenements à venir</h3>';
                                    echo '<div class="work-experience pt-2">';
                                    $prepared = $bdd->prepare("SELECT evenement.id AS eid, nom, description, mot, etat, UNIX_TIMESTAMP(date_debut) AS datets FROM evenement, taxonomie
                                                               WHERE evenement.id_mot_clef=taxonomie.id
                                                               AND evenement.id_membre=:id
                                                               ORDER BY datets DESC
                                                               LIMIT 5");
                                    $values = array(':id' => $_GET['id']);
                                    if ($prepared->execute($values)) {
                                        while ($eventList = $prepared->fetch()) {
                                            echo '
                                            <div class="col-12">
                                                <div class="card mt-3">
                                                    <div class="card-body">
                                                        <h6 class="card-title">'. substr($eventList['nom'], 1, -1);
                                                        if ($eventList['etat'] == "Annule") {echo  '<p class="text-danger d-inline"> Annulé </p></h4>';} else {echo '</h4>';}
                                            echo        '
                                                        <h6 class="card-subtitle text-muted">' . $eventList['mot'] . '
                                                        <a href="PageEvenement.php?id='. $eventList['eid'] .'" class="stretched-link"></a>
                                                    </div>
                                                </div>
                                            </div>
                                            ';
                                        }
                                        echo '</div>';
                                    }
                            } else if ($row['role'] == 'Visiteur') { //Participations
                                echo '<h3 class="h6 font-weight-light text-secondary text-uppercase">Dernieres participations</h3>';
                                echo '<div class="work-experience pt-2">';
                                $prepared = $bdd->prepare("SELECT nom, description, mot, UNIX_TIMESTAMP(date_debut) AS datets FROM evenement, taxonomie, inscriptions
                                                           WHERE evenement.id_mot_clef=taxonomie.id
                                                           AND evenement.id=inscriptions.id_evenement
                                                           AND inscriptions.id_membre=:id
                                                           ORDER BY datets DESC
                                                           LIMIT 5");
                                $values = array(':id' => $_GET['id']);
                                if ($prepared->execute($values)) {
                                    while ($eventList = $prepared->fetch()) {
                                        echo '
                                        <div class="work mb-4">
                                            <strong class="h5 d-block text-secondary font-weight-bold mb-1">'. $eventList['nom'] .'</strong>
                                            <strong class="h6 d-block text-warning mb-1">'. $eventList['mot'] .'</strong>
                                            <p class="text-secondary">'. $eventList['description'] .'</p>
                                        </div>';
                                    }
                                    echo '</div>';
                                }
                            }


                            ?>
                        </section>
                    </div>
                    </div>
                    <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <h2 class="font-weight-bold m-0">
                            <?php echo $row['username']; ?>
                        </h2>
                    </div>
                    <p class="h5 text-primary mt-2 d-block font-weight-light">
                        <?php echo $row['role']; ?>
                    </p>
                    <!--p class="lead mt-4">Description pr ofile blablablabosu uibiubsuisvnu sn vsuvnsuovbsuvbs  vjsbvjk bsvkj sdbv isbvihdbv h  jsd vjhsd vshjv</p-->
                    <section class="mt-5">
                        <?php if ($row['role'] == "Visiteur") {
                            $prepared = $bdd->prepare("SELECT COUNT(*) AS count FROM inscriptions WHERE id_membre=:id");
                            $values = array(':id' => $_GET['id']);
                            if ($prepared->execute($values)) {
                                if ($events = $prepared->fetch()) {
                                    echo '<h3 class="h6 font-weight-light text-secondary text-uppercase">Nombre de participations</h3>
                                    <div class="d-flex align-items-center">
                                    <strong class="h1 font-weight-bold m-0 mr-3">'. $events['count'] .'</strong>
                                    <div>
                                        <input data-filled="fa fa-2x fa-star mr-1 text-warning" data-empty="fa fa-2x fa-star-o mr-1 text-light" value="5" type="hidden" class="rating" data-readonly />
                                    </div>
                                    </div>';
                                }
                            }
                        } else if ($row['role'] == "Contributeur") {
                            $prepared = $bdd->prepare("SELECT COUNT(*) AS count FROM evenement WHERE id_membre=:id");
                            $values = array(':id' => $_GET['id']);
                            if ($events = $prepared->execute($values)) {
                                if ($events = $prepared->fetch()) {
                                    echo '<h3 class="h6 font-weight-light text-secondary text-uppercase">Nombre d\'evenements créés</h3>
                                    <div class="d-flex align-items-center">
                                        <strong class="h1 font-weight-bo\ld m-0 mr-3">'. $events['count'] .'</strong>
                                        <div>
                                            <input data-filled="fa fa-2x fa-star mr-1 text-warning" data-empty="fa fa-2x fa-star-o mr-1 text-light" value="5" type="hidden" class="rating" data-readonly />
                                        </div>
                                    </div>';
                                }
                            }
                        } ?>

                    </section>
                    <section class="mt-4">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                                    A propos
                                </a>
                            </li>
                            <?php
                                if (isset($_SESSION['userInfo']['id']) && $_GET['id'] == $_SESSION['userInfo']['id']) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                            Historique
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                                            Modifier
                                        </a>
                                    </li>
                            <?php }
                            ?>
                        </ul>
                        <div class="tab-content py-4" id="myTabContent">
                            <div class="tab-pane py-3 fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <?php if ($row['role'] != "Visiteur") {
                                    ?>
                                    <h6 class="text-uppercase font-weight-light text-secondary">
                                        Contacts
                                    </h6>
                                    <dl class="row mt-4 mb-4 pb-3">
                                        <?php //Contact display
                                        if ($row['telephone'] != "") {
                                            echo '
                                            <dt class="col-sm-3">tel</dt>
                                            <dd class="col-sm-9">'. $row['telephone'] .'</dd>';
                                        }
                                        if ($row['adresse'] != "") {
                                            echo '
                                            <dt class="col-sm-3">tel</dt>
                                            <dd class="col-sm-9">
                                                <address class="mb-0">
                                                    '. $row['adresse'] .'
                                                </address>
                                            </dd>';
                                        }
                                        if ($row['email'] != "") {
                                            echo '
                                            <dt class="col-sm-3">adresse mail</dt>
                                            <dd class="col-sm-9">
                                                <a href="mailto:'. $row['email'] .'">'. $row['email'] .'</a>
                                            </dd>';
                                        }
                                        ?>
                                    </dl>
                                <?php }
                                ?>

                                <h6 class="text-uppercase font-weight-light text-secondary">
                                    Qui suis-je ?
                                </h6>
                                <dl class="row mt-4 mb-4 pb-3">
                                    <dt class="col-sm-3">Nom & Prénom</dt>
                                    <dd class="col-sm-9"><?php echo "$row[nom] $row[prenom]"; ?></dd>
                                </dl>
                            </div>
                            <?php
                                if (isset($_SESSION['userInfo']['id']) && $_GET['id'] == $_SESSION['userInfo']['id']) { ?>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <?php
                                    if (is_int($_SESSION['userInfo']['id'])) {
                                        if ($_SESSION['userInfo']['role'] == 'Visiteur') {
                                            $prepared = $bdd->prepare("SELECT evenement.id AS eid, nom, date_debut, date_fin, UNIX_TIMESTAMP(date_debut) AS datets, etat
                                            FROM inscriptions, evenement
                                            WHERE inscriptions.id_evenement=evenement.id AND inscriptions.id_membre=:id
                                            ORDER BY datets DESC");
                                            $values = array(':id' => $_GET['id']);
                                            if ($prepared->execute($values)) {
                                                while ($row = $prepared->fetch()) {
                                                    setlocale(LC_ALL, 'fr_FR');
                                                    $dateDebut = strtotime($row['date_debut']);
                                                    $dateStr = strftime("%e %B", $dateDebut);
                                                    $dateFin = strtotime($row['date_fin']);
                                                    if ($row['date_fin'] != $row['date_debut'])
                                                        $dateStr = "du " . $dateStr . " au " . strftime("%e %B", $dateFin);
                                                    echo '
                                                    <div class="col-12">
                                                        <div class="card mt-3">
                                                            <div class="card-body">
                                                                <h4 class="card-title">'. $row['nom'];
                                                                if ($row['etat'] == "Annule") {echo  '<p class="text-danger d-inline"> Annulé </p></h4>';} else {echo '</h4>';}
                                                    echo        '<p class="card-text text-muted text-right">'. $dateStr .'</p>
                                                                <a href="PageEvenement.php?id='. $row['eid'] .'" class="stretched-link"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    ';
                                                }
                                            }
                                        } else if ($_SESSION['userInfo']['role'] == 'Contributeur') {
                                            $prepared = $bdd->prepare("SELECT id AS eid, nom, date_debut, date_fin, UNIX_TIMESTAMP(date_debut) AS datets, etat
                                            FROM evenement
                                            WHERE id_membre=:id
                                            ORDER BY datets DESC");
                                            $values = array(':id' => $_GET['id']);
                                            if ($prepared->execute($values)) {
                                                while ($row = $prepared->fetch()) {
                                                    setlocale(LC_ALL, 'fr_FR');
                                                    $dateDebut = strtotime($row['date_debut']);
                                                    $dateStr = strftime("%e %b %G", $dateDebut);
                                                    $dateFin = strtotime($row['date_fin']);
                                                    if ($row['date_fin'] != $row['date_debut'])
                                                        $dateStr = $dateStr . " - " . strftime("%e %b %G", $dateFin);
                                                    echo '
                                                    <div class="col-12">
                                                        <div class="card mt-3">
                                                            <div class="card-body">
                                                            <h4 class="card-title">'. $row['nom'];
                                                            if ($row['etat'] == "Annule") {echo  '<p class="text-danger d-inline"> Annulé </p></h4>';} else {echo '</h4>';}
                                                echo        '<p class="card-text text-muted text-right">'. $dateStr .'</p>
                                                                <a href="PageEvenement.php?id='. $row['eid'] .'" class="stretched-link"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                            <?php }
                            ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    <?php }
        }
        ?>
        <?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
    </body>
</html>
<?php $_SESSION['token']->cycle(); ?>
