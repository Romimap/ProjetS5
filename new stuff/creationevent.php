<!-- PAGE TEMPLATE -->
<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
?>
<!doctype html>
<html lang="fr">
    <head>
	<?php include($WWWPATH . "template/head.html"); ?>
	<link rel="stylesheet" type="text/css" href="event.css" media="screen" />
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ajouter évènement</title>
    </head>
    <body>
    <?php include($WWWPATH . "template/menu/menu.php") ?>
    <div id="form">
        <form id="addform" method="post">

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

                <input type="date" id="start" name="event-start"
                   value="2020-01-01"
                   min="2020-01-01" max="2022-12-31">
        </div>

        <div class="formgroup" id="description-form">
            <label for="description">Description de l'évènement</label>
            <textarea id="description" name="description"></textarea>
        </div>

        <div class="formgroup" id="particpants-form">
            <label for="start">Nombre minimum de participants:</label>

                <input type="number"
                   value="01"
                   min="01" max="02">

            <label for="end">Nombre maximum de participants:</label>

                <input type="number"
                   value="01"
                   min="01" max="02">
        </div>

        <div class="formgroup" id="theme-form">
            <label for="theme">Veuillez choisir le thème de l'évènement :</label>  
                    <select name="theme" id="theme">
                       <optgroup label="Divertissement">
                           <option value="aucune">Aucune</option>
                           <option value="idee">Idée</option>
                           <option value="mec">Mec</option>
                           <option value="lmao">LMAO</option>
                       </optgroup>
                       <optgroup label="Politique">
                           <option value="hehe">Hehe</option>
                           <option value="keke">Keke</option>
                       </optgroup>
                   </select>
                </center>
        </div>

            <input type="submit" value="Ajouter l'évènement" />
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
    </body>
</html>
<?php $_SESSION['token']->cycle(); ?>

