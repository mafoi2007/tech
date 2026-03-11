<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
    $as = $config->getCurrentYear();
    $reponse = $_POST['userType'];
    if($reponse=='null'){
        echo "<h3 class='alert'>Vous devez faire un choix.</h3>";
    }else{ 
        $users = $config->getUtilisateurType($reponse);
        if(!empty($users)){
            echo $users[0]['libelle_poste']." : ";
            echo "<select name='user' id='user' onChange='changePwd()'>";
                 echo "<option value='null' selected>-Choisir-</option>";
                 for($x=0;$x<count($users);$x++){
                    echo "<option value='".$users[$x]['idEnseignant']."'>".stripslashes($users[$x]['nom'])."</option>";
                 }
            echo "</select>";
            echo "<div id='changePwd'></div>";
        }else{
            echo "<h3 class='alert'>Aucun utilisateur défini.</h3>";
        }
    }