<!-- PAGE TEMPLATE -->
<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
//Permission check
if (isset($_SESSION['userInfo']['role']) && $_SESSION['userInfo']['role'] == "Admin") {

    //FORM PROCESSING
    //We check if we have a token
    if (isset($_POST['token']) && isset($_SESSION['token'])) {
        //Token check
        if ($_SESSION['token']->verify($_POST['token'])) {
            //we check if the form is valid
            if (isset($_POST['id']) && is_numeric($_POST['id'])
            &&  isset($_POST['type']) && ($_POST['type'] == "add" || $_POST['type'] == "rm")) {
                //We check if we add or remove an element
                if ($_POST['type'] == "add"
                &&  isset($_POST['mot']) && ctype_alpha($_POST['mot'])) {
                    //We have to add a new word to the taxonomy table
                    $prepared = $bdd->prepare("INSERT INTO taxonomie (parent, mot) VALUES (:parentId, :mot)");
                    $values = array(':parentId' => $_POST['id'], ':mot' => $_POST['mot']);
                    if ($prepared->execute($values)) {
                        //We successfully added a word to the taxonomy table
                    }
                } else if ($_POST['type'] == "rm"
                && $_POST['id'] != 0) {
                    //We have to remove a new word to the taxonomy table
                    //First we set the parent of all the childs of the element to the parent of the element
                    $bdd->query("SET foreign_key_checks = 0");
                    $prepared = $bdd->prepare("UPDATE taxonomie SET parent=(
                        SELECT parent FROM taxonomie WHERE id=:id
                    ) WHERE parent=:id1;");
                    $values = array(':id' => $_POST['id'], ':id1' => $_POST['id']);
                    if ($prepared->execute($values)) {
                        //Then if succeded we remove the element
                        $prepared = $bdd->prepare("DELETE FROM taxonomie WHERE id=:id");
                        $values = array(':id' => $_POST['id']);
                        if ($prepared->execute($values)) {
                            //We removed an element from the tree
                        }
                    }
                    $bdd->query("SET foreign_key_checks = 1");
                }
            }
        }
    }
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
         document.getElementsByClassName("hiddenSelectedWord")[0].value = id;
         document.getElementsByClassName("hiddenSelectedWord")[1].value = id;
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
    			    if ($id == $r['parent']) {
    				echo '<li>' . '<button id="' . $r['id'] . '" onclick="selectWord(' . $r['id'] . ')" class="list-group-item list-group-item-action">'
    				   . ucwords(strtolower($r['mot'])) . '</button>';
    				rlist($r['id'], $rows);
    				echo '</li>';
    			    }
    			}
    			echo "</ul>";
		    }

		    $prepared = $bdd->prepare("SELECT * FROM taxonomie");
		    if ($prepared->execute()) {
    			if ($rows = $prepared->fetchAll()) {
    			    rlist(0, $rows);
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
			    <input type="hidden" class="hiddenSelectedWord" name="id" value="0"/>
                <input type="hidden" name="type" value="add"/>
			    <ul class="list-group">
				                <input class="list-group-item mt-1 mb-1 text-center" type="text" name="mot"/>
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
                <input type="hidden" class="hiddenSelectedWord" name="id" value="0"/>
                <input type="hidden" name="type" value="rm"/>
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
