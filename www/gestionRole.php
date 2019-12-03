<!-- PAGE TEMPLATE -->
<?php
$WWWPATH = "/opt/lampp/htdocs/www/ProjetS5/www/";
require($WWWPATH . "template/includes.php");
//Permission check
if (isset($_SESSION['userInfo']['role']) && $_SESSION['userInfo']['role'] == "Admin") {

    //FORM PROCESSING
?>
<!doctype html>
<html lang="fr">
    <head>
	<?php include($WWWPATH . "template/head.html"); ?>
    </head>
    <body>
	<!-- BODY -->
    <?php
        //Display search bar
        echo '
        <div class="row bg-dark text-light pt-3 pb-3">
            <div class="col">
                <form method="POST" action="gestionRole.php">
                    <div class="row pl-3 pr-3">
                        <div class="input-group col-3">
                            <input type="text" class="form-control" placeholder="Username" name="nameSearch"  style="height: 40px;">
                            <div class="input-group-append">
                                <input class="input-group-text" type="submit" value="Rechercher !"  style="height: 40px;">
                            </div>
                        </div>
                        <div class="col text-right">
                            <h3>
                                Gestionaire des roles
                            </h3>
                        </div>
                    </div>
                </form>
            </div>
        </div>';
        if (isset($_POST['nameSearch']) && ctype_alnum($_POST['nameSearch'])) {
            //Display users
            //First we get user data from the database, showing exact matchs first
            $prepared = $bdd->prepare("SELECT id, username, role FROM membres
                                        WHERE username LIKE :nameSearch
                                        ORDER BY (username=:exactName) DESC, LENGTH(username)
                                        LIMIT 50;");
            $values = array(':nameSearch' => "%$_POST[nameSearch]%", ':exactName' => $_POST['nameSearch']);
            if ($prepared->execute($values)) {
                //We executed the query, we can start to print the form
                echo '
                    <form method="POST" action="gestionRole.php">
                        <div class="row">
                            <div class="col-4 border-right">
                                <ul class="list-group border-0" style="overflow-y:  scroll; height: 500px;">';
                                //Here we print the usernames on the left
                while ($row = $prepared->fetch()) {
                    echo '
                                    <li class="list-group-item border-0">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" style="height: 40px;">
                                                    <input type="radio" name="id" value="' . $row['id'] . '"/>
                                                </div>
                                            </div>
                                            <p class="form-control text-capitalize" style="height: 40px;">' . $row['username'] . '</p>
                                            <div class="input-group-append">
                                                <div class="input-group-text" style="height: 40px;">
                                                    <p>' . $row['role'] . '</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>';
                }
                echo '
                                </ul>
                            </div>';
                            //Here we print the options and the submit button on the right
                echo '
                            <div class="col-8">
                                <div class="row pt-3 pb-2 border-bottom">
                                    <div class="col">
                                        <h5> Définir la séléction comme : </h5>
                                    </div>
                                </div>
                                <div class="row pt-3">
                                    <div class="input-group mb-3 col-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" style="height: 40px;">
                                                <input type="radio" name="role" value="Visiteur" checked>
                                            </div>
                                        </div>
                                        <p class="form-control" style="height: 40px;"> Visiteur </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-group mb-3 col-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" style="height: 40px;">
                                                <input type="radio" name="role" value="Contributeur">
                                            </div>
                                        </div>
                                        <p class="form-control" style="height: 40px;"> Contributeur </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-group mb-3 col-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" style="height: 40px;">
                                                <input type="radio" name="role" value="Admin">
                                            </div>
                                        </div>
                                        <p class="form-control" style="height: 40px;"> Admin </p>
                                    </div>
                                </div>
                                <div class="row pt-3 pb-2 border-top">
                                    <div class="col">
                                        <input class="btn btn-primary" type="submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>';
            }
        }
    ?>
	<?php include($WWWPATH . "template/bootstrapScripts.html"); ?>
    </body>
</html>
<?php
$_SESSION['token']->cycle();
}
?>
