<?php
    if (isset($_SESSION['userInfo']['role'])) {
        if ($_SESSION['userInfo']['role'] == "Admin") {
            //Menu Admin
            include($WWWPATH . "template/menu/menuAdmin.html");
        } else if ($_SESSION['userInfo']['role'] == "Contributeur") {
            //Menu Contributeur
            include($WWWPATH . "template/menu/menuClean.html");
        } else {
            //Menu Visiteur
            include($WWWPATH . "template/menu/menuClean1.html");
        }
    } else {
        include($WWWPATH . "template/menu/menuCleanbase.html");
    }
 ?>
