<!-- PAGE TEMPLATE -->
<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
?>
<!doctype html>
<html lang="fr">
    <head>
	<?php include($WWWPATH . "template/head.html"); ?>
    <link rel="stylesheet" type="text/css" href="css/stylespa.css" media="screen" />
	<!-- HEAD -->
    </head>
  <body class="d-flex flex-column">
      <?php include($WWWPATH . "template/menu/menu.php")?>
    <div id="page-content">
      <div class="container text-center">
        <div class="row justify-content-center">
          <div class="col-md-7">
            <h1 class="font-weight-light mt-4 text-white">Lancez-vous dès maintenant !</h1>
            <p class="lead text-white-50"></p>
          </div>
        </div>
      </div>
    </div>

    <header>
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="carousel-item active" style="background-image: url('https://g2e-gamers2mediasl.netdna-ssl.com/wp-content/uploads/2019/08/are-you-ready.jpg')">
          <div class="carousel-caption d-none d-md-block">
          </div>
        </div>
        <div class="carousel-item" style="background-image: url('https://mgoblue.com/images/2018/8/17/gf_poster_2018.jpg')">
          <div class="carousel-caption d-none d-md-block">
          </div>
        </div>
        <div class="carousel-item" style="background-image: url('https://www.numerama.com/content/uploads/2019/08/zevent-2019.jpg')">
          <div class="carousel-caption d-none d-md-block">
          </div>
        </div>
      </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
      </div>
    </header>

    <div id="page-content">
      <div class="container text-center">
        <div class="row justify-content-center">
          <div class="col-md-7">
            <h2 class="font-weight-light mt-4 text-white"></h2>
            <p class="lead text-white">Des milliers d'évènements pour toutes vos envies</p>
          </div>
        </div>
      </div>
    </div>

    </div>
    <!-- /.container -->
    <footer id="sticky-footer" class="py-4 bg-dark text-white-50">
      <div class="container text-center">
        <small>Copyright &copy; Projet HLIN510 & HLIN511 - 2019/2020</small>
      </div>
    </footer>
    <?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
</body>
</html>
<?php $_SESSION['token']->cycle(); ?>
