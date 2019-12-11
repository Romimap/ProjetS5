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
      <!--<script type="text/javascript" src="makeevent. js"></script>-->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ajouter évènement</title>
    </head>
    <body>
    <?php include($WWWPATH . "template/menu/menu.php") ?>
    <div class="container contact-form">
            <div class="contact-image">
                <img src="https://cdn.icon-icons.com/icons2/317/PNG/512/calendar-icon_34471.png" alt="rocket_contact"/>
                <img src="https://cdn.icon-icons.com/icons2/317/PNG/512/calendar-icon_34471.png" alt="rocket_contact"/>
                <img src="https://cdn.icon-icons.com/icons2/317/PNG/512/calendar-icon_34471.png" alt="rocket_contact"/>
            </div>
            <form method="post">
                <h1>Créer un évènement</h1>
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="txtName" class="form-control" placeholder="Nom de l'évènement *" value="" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="txtAdresse" class="form-control" placeholder="Adresse *" value="" />
                        </div>
                        
                        <div class="form-group">
                            <input type="number" name="long" class="form-control" placeholder="Longitude *" value="" />
                        </div>
                        <div class="form-group">
                            <input type="number" name="lat" class="form-control" placeholder="Latitude *" value="" />
                        </div>

                        <div class="form-group">
                            <label for="deb">Début:</label>
                            <input type="date" name="deb" class="form-control" value="2020-01-01"
                            min="2020-01-01" max="2021-12-31"/>
                        </div>
                        <div class="form-group">
                            <label for="fin">Fin:</label>
                            <input type="date" name="fin" class="form-control" value="2020-01-01"
                            min="2020-01-01" max="2021-12-31"/>
                        </div>

                        <div class="form-group">
                            <input type="number" name="long" class="form-control" placeholder="Nombre minimum de participants:" value="" />
                        </div>
                        <div class="form-group">
                            <input type="number" name="lat" class="form-control" placeholder="Nombre maximum de participants:" value="" />
                        </div>

                        <div class="form-group">
                            <input type="text" name="txtTheme" class="form-control" placeholder="Votre thème *" value="" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="txtMsg" class="form-control" placeholder="Description de l'évènement" style="width: 100%; height: 427px;"></textarea>
                        </div>
                        <center><div class="form-group">
                            <input type="submit" name="btnSubmit" class="btnContact" value="Ajouter évènement" />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="btnSubmit" class="btnContact" value="Valider les modifs" />
                        </div></center>
                    </div>
                </div>
            </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
    </body>
</html>
<?php $_SESSION['token']->cycle(); ?>

