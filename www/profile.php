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
	require($WWWPATH . "template/sql.php");
    //We check that GET[id] contains a numeric value, if not we try to set it as the id of the user
	if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        if (isset($_SESSION['userInfo']['id']) && is_numeric($_SESSION['userInfo']['id'])) {
            $_GET['id'] = $_SESSION['userInfo']['id'];
        } else {
            //if not we exit
            exit(0);
        }
	}
    //From now on we consider $_GET['id'] valid
	$prepared = $bdd->prepare("SELECT nom, prenom, username, role, email FROM membres WHERE id=:id");
	$array=array(":id" => $_GET['id']);
	if ($prepared->execute($array)) {
	    if ($row = $prepared->fetch()) {
            //The request executed and returned a line
            ?>
    	    <div class="container">
    		<div class="row">
    		    <div class="col-12">
    			<div class="card">
    			    <div class="card-body">
    				<div class="card-title mb-4">
    				    <div class="d-flex justify-content-start">
    					<div class="image-container">
    					    <img src="http://placehold.it/150x150" id="imgProfile" style="width: 150px; height: 150px" class="img-thumbnail" />
    					    <div class="middle">
    						<input type="button" class="btn btn-secondary" id="btnChangePicture" value="Change" />
    						<input type="file" style="display: none;" id="profilePicture" name="file" />
    					    </div>
    					</div>
    					<div class="userData ml-3">
    					    <h2 class="d-block" style="font-size: 1.5rem; font-weight: bold"><a href="javascript:void(0);"><?php echo $row['username']; ?></a></h2>
    					    <?php //We print first the contributions
                            if ($row['role'] == "Contributeur") {
                                $prepared = $bdd->prepare("SELECT COUNT(*) AS count FROM evenement WHERE id_membre=:id");
                                $values = array(':id' => $_GET['id']);
                                if ($events = $prepared->execute($values)) {
                                    if ($events = $prepared->fetch()) {
                                        echo '<h6 class="d-block"><a href="javascript:void(0)">'. $events['count'] .'</a> Evenements créés</h6>';
                                    }
                                }
                            }
                            //Then the participations
                            $prepared = $bdd->prepare("SELECT COUNT(*) AS count FROM inscriptions WHERE id_membre=:id");
                            $values = array(':id' => $_GET['id']);
                            if ($prepared->execute($values)) {
                                if ($events = $prepared->fetch()) {
                                    echo '<h6 class="d-block"><a href="javascript:void(0)">'. $events['count'] .'</a> Participations</h6>';
                                }
                            }
                            ?>
    					</div>
    					<div class="ml-auto">
    					    <input type="button" class="btn btn-primary d-none" id="btnDiscard" value="Discard Changes" />
    					</div>
    				    </div>
    				</div>

    				<div class="row">
    				    <div class="col-12">
    					<ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
    					    <li class="nav-item">
    						<a class="nav-link active" id="basicInfo-tab" data-toggle="tab" href="#basicInfo" role="tab" aria-controls="basicInfo" aria-selected="true">Informations</a>
    					    </li>
                            <?php //We print the history and parameters only if it is the profile of the owner of the session
                            if (isset($_SESSION['userInfo']['id']) && $_GET['id'] == $_SESSION['userInfo']['id']) { ?>
        					    <li class="nav-item">
        						<a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">Historique des évènements</a>
        					    </li>
                                <li class="nav-item">
        						<a class="nav-link" id="parameters-tab" data-toggle="tab" href="#parameters" role="tab" aria-controls="parameters" aria-selected="false">Parametres </a>
        					    </li>
                            <?php }
                            ?>
    					</ul>
    					<div class="tab-content ml-1" id="myTabContent">
    					    <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">
        						<div class="row">
        						    <div class="col-sm-3 col-md-2 col-5">
        							<label style="font-weight:bold;">Nom et prénom</label>
        						    </div>
        						    <div class="col-md-8 col-6">
        							<?php echo $row['nom'] . " " . $row['prenom']; ?>
        						    </div>
        						</div>
        						<hr />

                                <?php //Informations personnelles
                                if ($row['role'] != "Visiteur") { ?>
            						<div class="row">
            						    <div class="col-sm-3 col-md-2 col-5">
            							<label style="font-weight:bold;">Contact</label>
            						    </div>
            						    <div class="col-md-8 col-6">
            							<?php echo $row['email']; ?>
            						    </div>
            						</div>
                                    <hr />
                                <?php } ?>
        						<div class="row">
        						    <div class="col-sm-3 col-md-2 col-5">
        							<label style="font-weight:bold;">Statut :</label>
        						    </div>
        						    <div class="col-md-8 col-6">
        							<?php echo $row['role']; ?>
        						    </div>
        						</div>
    					    </div>
                            <?php //We print the history and parameters only if it is the profile of the owner of the session
                            if (isset($_SESSION['userInfo']['id']) && $_GET['id'] == $_SESSION['userInfo']['id']) { ?>
        					    <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
        						historique
        					    </div>
                                <div class="tab-pane fade" id="parameters" role="tabpanel" aria-labelledby="history-tab">
                                    <form action="/action_page.php" class="form-container">
                                    <label for="email"><b>Adresse mail</b></label>
                                    <input type="mail" placeholder="Nouvelle adresse mail" name="email" required>

                                    <label for="id"><b>Identifiant</b></label>
                                    <input type="text" placeholder="Nouvel identifiant" name="email" required>

                                    <label for="psw"><b>Mot de passe</b></label>
                                    <input type="password" placeholder="Nouveau mot de passe" name="psw" required>

                                    <label for="cpsw"><b>Confirmation mot de passe</b></label>
                                    <input type="password" placeholder="Confirmer mot de passe" name="cpsw" required>

                                    <label for="ad"><b>Adresse</b></label>
                                    <input type="text" placeholder="Nouvelle adresse" name="ad" required>

                                    <label for="tel"><b>Numéro de téléphone</b></label>
                                    <input type="tel" id="phone" name="phone" placeholder="06xxxxxxxx" pattern="0[6-7]{1}[0-9]{8}" required>

                                    <hr>

                                    <button type="submit" class="btn">Modifier</button>
                                    <button type="button" class="btn cancel" onclick="closeForm()">Fermer</button>
                                    </form>
        					    </div>
                            <?php }
                            ?>
    					</div>
    				    </div>
    				</div>
    			    </div>
    			</div>
    		    </div>
    		</div>
    	    </div>
    	<?php
		}
	}
	?>
	<?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
    </body>
</html>
<?php $_SESSION['token']->cycle(); ?>
