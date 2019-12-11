<!-- PAGE TEMPLATE -->
<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
?>
<!doctype html>
<html lang="fr">
    <head>
	<?php include($WWWPATH . "template/head.html"); ?>
    <link rel="stylesheet" type="text/css" href="feedback.css" media="screen" />
    <!--<script type="text/javascript" src="feedback.js"></script>-->   
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ajouter évènement</title>
    </head>
    <body>
    <h1 class="text-center" alt="Simple"><b>Notez cet évènement</b></h1>
     
    <div class="container">
            <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 star">5</label>
                <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 star">4</label>
                <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 star">3</label>
                <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 star">2</label>
                <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star">1</label>
            </div>
      </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
    </body>
</html>
<?php $_SESSION['token']->cycle(); ?>

