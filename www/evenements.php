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
        <?php
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


            //values check
            if (!(isset($_GET['taxId']) && ctype_digit($_GET['taxId']))) {
                $ancestor = 0;
            } else {
                $ancestor = $_GET['taxId'];
            }

            //We parse the taxonomy table onto an array, as $taxArray[id] = parent
            //Then we use this array to make a list of ids that are childs of an ancestor

            $taxArray = array();
            $prepared = $bdd->prepare('SELECT * FROM taxonomie');
            if ($prepared->execute()) {
                while ($row = $prepared->fetch()) {
                    $taxArray[$row['id']] = $row['parent'];
                }
                $taxChilds = allChild($ancestor, $taxArray);
            } else {
                echo "error  -1";
                exit(-1);
            }

            //We then get the event list and use $taxChilds to display events
            $prepared = $bdd->prepare('SELECT nom, description, mot, taxonomie.id FROM evenement, taxonomie WHERE evenement.id_mot_clef = taxonomie.id AND DATE(NOW()) < DATE(date_fin)');
            if ($prepared->execute()) {
                while ($row = $prepared->fetch()) {
                    if ($taxChilds[$row['id']]) {
                        //This row can be printed
                        echo "$row[nom] $row[description] <br>";
                    }
                }
            } else {
                echo "error  -2";
                exit(-2);
            }
        ?>
	    <?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
    </body>
</html>
<?php $_SESSION['token']->cycle(); ?>
