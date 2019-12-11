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

        <div class="formgroup" id="name-form">
            <label for="name">Nom de l'évènement</label>
            <input type="text" id="name" name="name" />
        </div>

        <div class="formgroup" id="date-form">
            <label for="start">Début:</label>
                <input type="date" id="start" name="event-start"
                   value="2020-01-01"
                   min="2020-01-01" max="2021-12-31">

            <label for="end">Fin:</label>
                <input type="date" id="start" name="event-end"
                   value=""
                   min="2020-01-01" max="2022-12-31">
        </div>

        <div class="formgroup" id="description-form">
            <label for="description">Description de l'évènement</label>
            <textarea id="description" name="description"></textarea>
        </div>

        <div class="formgroup" id="particpants-form">
            <label for="start">Nombre minimum de participants:</label>

                <input type="number"
                   value=""
                   min="0">

            <label for="end">Nombre maximum de participants:</label>

                <input type="number"
                   value=""
                   min="0">
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
