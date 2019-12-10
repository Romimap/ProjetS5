<!-- PAGE TEMPLATE -->
<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
?>
<!doctype html>
<html lang="fr">
    <head>
	<?php include($WWWPATH . "template/head.html"); ?>
    <script type="text/javascript">
        function selectedWord(id) {
            document.getElementById('selectWord').value = id;
            document.getElementById('taxonomyForm').submit();
        }
    </script>
    <style media="screen">
    body{
        padding-bottom: 50px;
        background: #007bff;
        background: linear-gradient(to right, #0062E6, #33AEFF);
    }
    </style>
    </head>
    <body>
        <?php include($WWWPATH . "template/menu/menu.php"); ?>
        <div class="row">
            <div class="col-12 col-md-3 bg-light">
                <div class="col-10 mx-auto">
                    <hr>
                    <h3>Mot clefs</h3>
                    <?php
                        //We check the taxonomy table to show the childs of the current word selected (parentId)
                        //Directory style

                        //first we initialise the variables
                        $parentId = 0;
                        //We check if we have a token
                        if (isset($_POST['token']) && isset($_SESSION['token'])) {
                            //Token check
                            if ($_SESSION['token']->verify($_POST['token'])) {
                                if (isset($_POST['parentId']) && is_numeric($_POST['parentId'])) {
                                    //We have a valid and signed form
                                    $parentId = $_POST['parentId'];
                                }
                            }
                        }
                        $prepared = $bdd->prepare("SELECT id, parent, mot FROM taxonomie");
                        if ($prepared->execute()) {
                            //The request executed
                            $row = $prepared->fetchAll();
                            //First we check if we have to display the return button
                            foreach ($row as $k => $v) {
                                if ($v['id'] == $parentId && $v['parent'] != -1) {
                                    //The parent word isnt the root, we can display the button
                                    echo '
                                        <button id="' . $v['parent'] . '" onclick="selectedWord(' . $v['parent'] . ')" class="list-group-item list-group-item-action bg-light">
                                            Retours
                                        </button>';
                                }
                            }
                            //Then we display the childs of the parent word
                            foreach ($row as $k => $v) {
                                if ($v['parent'] == $parentId) {
                                    //The word is a child of parentId, we can display the button
                                    echo '
                                        <button id="' . $v['id'] . '" onclick="selectedWord(' . $v['id'] . ')" class="list-group-item list-group-item-action">
                                            '. $v['mot'] .'
                                        </button>';
                                }
                            }
                        }
                    ?>
                    <hr>
                    <form class="" action="EventList.php" method="post" id="taxonomyForm">
                        <?php $_SESSION['token']->formToken(); ?>
                        <input type="hidden" name="parentId" value="<?php echo $parentId; ?>" id="selectWord">
                        <h3> Date </h3>
                        <div class="input-group">
                            <input type="text" class="form-control" name="" placeholder="jj/mm/aaaa" value="" id="dateTimeInput">
                            <div class="input-group-append">
                                <input type="submit" class="form-control btn btn-outline-secondary" value="Envoyer">
                            </div>
                        </div>
                    </form>
                    <hr>
                </div>
            </div>
            <div class="col-12 col-md-9">
                <div class="row">
                    <?php //We print the events based on the filters
                        $prepared = $bdd->prepare("SELECT evenement.id AS eid, nom, description, mot, date_debut, date_fin FROM evenement, taxonomie WHERE id_mot_clef=taxonomie.id AND id_mot_clef=:idParent");
                        $values = array(':idParent' => $parentId);
                        if ($prepared->execute($values)) {
                            while ($row = $prepared->fetch()) {
                                setlocale(LC_ALL, 'fr_FR');
                                $dateDebut = strtotime($row['date_debut']);
                                $dateStr = strftime("%e %B", $dateDebut);
                                $dateFin = strtotime($row['date_fin']);
                                if ($row['date_fin'] != $row['date_debut'])
                                    $dateStr = "du " . $dateStr . " au " . strftime("%e %B", $dateFin);
                                echo '
                                <div class="col-3">
                                    <div class="card mt-3">
                                        <img src="" class="card-img-top" alt="">
                                        <div class="card-body">
                                            <h4 class="card-title">'. $row['nom'] .'</h4>
                                            <h6 class="card-subtitle text-muted">'. $row['mot'] .'</h6>
                                            <hr>
                                            <p class="card-text">'. $row['description'] .'</p>
                                            <hr>
                                            <p class="card-text text-muted text-right">'. $dateStr .'</p>
                                            <a href="PageEvenement.php?id='. $row['eid'] .'" class="stretched-link"></a>
                                        </div>
                                    </div>
                                </div>
                                ';
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
