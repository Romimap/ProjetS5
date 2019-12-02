<!-- PAGE TEMPLATE -->
<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
//Permission check
if (isset($_SESSION['userInfo']['role']) && $_SESSION['userInfo']['role'] == "Admin") {
    //TODO, form processing
?>
<!doctype html>
<html lang="fr">
    <head>
	<?php include($WWWPATH . "template/head.html"); ?>
	<script>
	 function selectWord(id) {
	     var buttons = document.getElementsByTagName("button");
	     for (var i = 0; i < buttons.length; i++)
		 buttons[i].className = "list-group-item list-group-item-action";
	     document.getElementById(id).className = "list-group-item list-group-item-action active";
	     document.getElementsByClassName("selectedWord")[0].innerHTML = document.getElementById(id).innerHTML;
	     document.getElementsByClassName("selectedWord")[1].innerHTML = document.getElementById(id).innerHTML;
	 }
	</script>
    </head>
    <body>
	<!-- BODY -->
	<div class="row">
	    <div class="col-12 col-md-4 border-right">
		<h3 class="text-center pt-3 pb-3 mb-4 bg-dark text-light">Catégories</h3>
		<div style="overflow-y: scroll; height: 50vh;">
		    <?php
		    function rlist ($id, $rows) {
			echo '<ul style="list-style-type: none;" class="mt-1 md-1">';
			foreach($rows as $r) {
			    if ($id == $r['parent_id']) {
				echo '<li>' . '<button id="' . $r['id'] . '" onclick="selectWord(' . $r['id'] . ')" class="list-group-item list-group-item-action">'
				   . ucwords(strtolower($r['name'])) . '</button>';
				rlist($r['id'], $rows);
				echo '</li>';
			    }
			}
			echo "</ul>";
		    }

		    $prepared = $bdd->prepare("SELECT * FROM taxonomy");
		    if ($prepared->execute()) {
			if ($rows = $prepared->fetchAll()) {
			    rlist(1, $rows);
			}
		    }
		    ?>
		</div>
	    </div>

	    <div class="col-12 col-md-8">
		<h3 class="text-center pt-3 pb-3 mb-4 bg-dark text-light">Ajout</h3>
		<div class="row">
		    <div class="col-4">
			<form method="POST" action="./taxonomyAdd.php">
			    <?php $_SESSION['token']->formToken(); ?>
			    <hidden name="id" value=""/>
			    <ul class="list-group">
				<input class="list-group-item mt-1 mb-1 text-center" type="text"/>
			    </ul>
			    <input type="submit" value="Valider" class="btn btn-primary"/>
			</form>
		    </div>
		    <div class="col-4">
			<p class="list-group-item border-0 text-center"> sera ajouté sous </p>
		    </div>
		    <div class="col-4">
			<ul class="list-group">
			    <li class="selectedWord list-group-item mt-1 mb-1 active text-center">ROOT</li>
			</ul>
		    </div>
		</div>

		<h3 class="text-center pt-3 pb-3 mt-4 mb-4 bg-dark text-light">Suppréssion</h3>
		<div class="row">
		    <div class="col-4">
			<p class="text-center list-group-item border-0"> La catégorie </p>
		    </div>
		    <div class="col-4">
			<ul class="list-group">
			    <li class="selectedWord list-group-item mt-1 mb-1 active text-center">ROOT</li>
			</ul>
		    </div>
		    <div class="col-4">
			<p class="text-center list-group-item border-0"> sera supprimée </p>
		    </div>
		    <div class="col">
			<form method="POST" action="./taxonomyAdd.php">
			    <?php $_SESSION['token']->formToken(); ?>
			    <hidden name="id" value=""/>
			    <input type="submit" value="Valider" class="btn btn-primary"/>
			</form>
		    </div>
		</div>
	    </div>
	<?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
    </body>
</html>
<?php
$_SESSION['token']->cycle();
}
?>
