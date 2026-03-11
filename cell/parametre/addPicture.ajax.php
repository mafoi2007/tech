<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
    $personne = $_POST['personne'];
    if($personne=='null'){
        echo "<h3 class='alert'>Vous devez faire un choix.</h3>";
    }elseif($personne=='eleve'){ ?>
        Choisissez d'abord la classe : 
        <select name='clas' id='clas' onChange='listeEleve()'>
            <?php 
            $listeClasse = $config->viewClasseStudent();
            for($i=0;$i<count($listeClasse);$i++){
                echo "<option value='".$listeClasse[$i]['classe']."'>".$listeClasse[$i]['nom_classe']."</option>";
            }
            ?>
            <option value='null' selected>-Choisr la Classe-</option>
        </select>
<?php 
    }elseif($personne=='utilisateur'){ ?>
        Choisissez le type d'utilisateur :
        <select name='userType' id='userType' onChange='listeUtilisateur()'>
            <?php 
            $listeUtilisateur = $config->userType();
            for($i=0;$i<count($listeUtilisateur);$i++){
                echo "<option value='".$listeUtilisateur[$i]['id']."'>".$listeUtilisateur[$i]['libelle_poste']."</option>";
            }
            ?>
            <option value='null' selected>-Choisr le type utilisateur-</option>
        </select>
<?php     
    }
?>

<div id='choixPhoto'>
</div>