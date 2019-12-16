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
                        //FUNCTIONS

                        //Returns true if id is a child of ancestor
                        function isChild ($id, $ancestor, $array) {
                            if ($id == $ancestor) {
                                return true;
                            }
                            while ($id != 0) {
                                $id = $array[$id];
                                if ($id == $ancestor) {
                                    return true;
                                }
                            }
                            return false;
                        }

                        //Returns a table $t[id] = mot/NULL, if the value is set to NULL, it
                        //means that the id isnt a child of the ancestor
                        function allChild ($ancestor, $array) {
                            $ansArray = array();
                            foreach ($array as $k => $v) {
                                if (isChild($k, $ancestor, $array)) {
                                    $ansArray[$k] = true;
                                } else {
                                    $ansArray[$k] = false;
                                }
                            }
                            return $ansArray;
                        }



                        //We check the taxonomy table to show the childs of the current word selected (parentId)
                        //Directory style

                        //first we initialise the variables
                        $parentId = 0;
                        //We check if we have a token
                        if (isset($_POST['token']) && isset($_SESSION['token'])) {
                            //Token check
                            if ($_SESSION['token']->verify($_POST['token'])) {
                                if (isset($_POST['parentId']) && ctype_digit($_POST['parentId'])) {
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

                            //We parse the taxonomy table onto an array, as $taxArray[id] = parent
                            //Then we use this array to make a list of ids that are childs of an ancestor
                            $taxArray = array();
                            foreach ($row as $k => $v) {
                                $taxArray[$row[$k]['id']] = $row[$k]['parent'];
                            }
                            $taxChilds = allChild($parentId, $taxArray);

                        }
                    ?>
                    <hr>
                    <form class="" action="EventList.php" method="post" id="taxonomyForm">
                        <?php $_SESSION['token']->formToken(); ?>
                        <input type="hidden" name="parentId" value="<?php echo $parentId; ?>" id="selectWord">
                        <hr>
                        <input class="form-control btn-primary" type="submit" value="Filtrer">
                    </form>
                    <hr>
                </div>
            </div>
            <div class="col-12 col-md-9">
                <div class="row">
                    <?php //We print the events based on the filters
                        $prepared = $bdd->prepare("SELECT evenement.id AS eid, taxonomie.id AS mid, nom, description, mot, date_debut, date_fin FROM evenement, taxonomie
                            WHERE id_mot_clef=taxonomie.id
                            AND DATEDIFF(NOW(), date_fin) < 0
                            AND etat='Normal'");
                        $values = array();
                        if ($prepared->execute($values)) {
                            while ($row = $prepared->fetch()) {
                                if ($taxChilds[$row['mid']]) {
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
                        }
                     ?>
                </div>
            </div>
        </div>
        <?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
    </body>
</html>
<?php $_SESSION['token']->cycle(); ?>
