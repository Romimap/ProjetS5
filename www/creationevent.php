<!-- PAGE TEMPLATE -->
<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
?>
<!doctype html>
<html lang="fr">
    <head>
    	<?php include($WWWPATH . "template/head.html"); ?>
    	<link rel="stylesheet" type="text/css" href="css/event.css" media="screen" />
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Ajouter évènement</title>
    </head>
    <body>
    <?php include($WWWPATH . "template/menu/menu.php") ?>
    <?php
        if (isset($_SESSION['userInfo']['role']) && $_SESSION['userInfo']['role'] == "Contributeur") {
            //We show the page only if the user is a contributor
    ?>
    <div id="form">
        <form id="addform" method="post" action="template/addEvent.php">
        <?php $_SESSION['token']->formToken(); ?>
        <div class="formgroup" id="name-form">
            <label for="name">Nom de l'évènement</label>
            <input type="text" id="name" name="name" />
        </div>

        <div class="formgroup" id="date-form">
            <label for="start">Début:</label>
                <input type="date" id="start" name="event-start"
                   value="">

            <label for="end">Fin:</label>
                <input type="date" id="start" name="event-end"
                   value="">
        </div>

        <div class="formgroup" id="description-form">
            <label for="description">Description de l'évènement</label>
            <textarea id="description" name="description"></textarea>
        </div>

        <div class="formgroup" id="particpants-form">
            <label for="start">Nombre minimum de participants:</label>

                <input type="number"
                   value=""
                   min="0"
                   name="min">

            <label for="end">Nombre maximum de participants:</label>

                <input type="number"
                   value=""
                   min="0"
                   name="max">
        </div>

        <div class="form-group" id="theme-form">
            <label for="theme">Veuillez choisir le thème de l'évènement :</label>
            <select class="form-control" name="theme" id="theme">
            <?php
            function rlist ($id, $rows, $indent) {
    			foreach($rows as $r) {
    			    if ($id == $r['parent']) {
        				echo '<option value="' . $r['id'] . '">';
                        for ($i = 0; $i < $indent; $i = $i + 1) { //Ugly way to add indentation
                            echo '&nbsp&nbsp&nbsp&nbsp';
                        }
        				echo ucwords(strtolower($r['mot'])) . '</option>';
        				rlist($r['id'], $rows, $indent + 1);
    			    }
    			}
		    }

		    $prepared = $bdd->prepare("SELECT * FROM taxonomie");
		    if ($prepared->execute()) {
    			if ($rows = $prepared->fetchAll()) {
    			    rlist(0, $rows, 0);
    			}
		    }
		    ?>
        </select>
            <div class="form-group" id="name-form">
                <label for="name">addresse</label>
                <input type="text" id="name" name="adresse" />
            </div>
            <div class="form-group" id="name-form">
                <label for="name">GPS</label>
                <input type="text" id="name" name="gps" />
            </div>
            <input type="submit" value="Ajouter l'évènement" />
        </form>
        <hr>
    </div>
    <?php
        }
     ?>
	<?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
    </body>
</html>
<?php $_SESSION['token']->cycle(); ?>
