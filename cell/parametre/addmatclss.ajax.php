<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
    $classe = $_POST['classe'];
    if($classe=='null'){
        echo "<h3 class='alert'>Vous devez choisir une classe.</h3>";
    }else{ ?>
    
    <table border='0' width='90%'>
        <tr>
            <th>N°</th>
            <th>Nom de la Matière</th>
            <th>Coefficient</th>
            <th>Groupe</th>
        </tr>
    <?php 
    $listeMatiere = $config->getMatiereAll('actif');
    if(empty($listeMatiere)){
        echo "<tr>
            <th colspan='4' class='alert'>Aucune Matière Enregistrée</th>
        </tr>";
    }else{
        $x = 1;
        for($a=0;$a<count($listeMatiere);$a++){
            echo "<tr>";
                echo "<td>".$x."</td>";
                echo "<td>";
                    echo $listeMatiere[$a]['nom_matiere'];
                    echo " <input type='hidden' name='matiere[]' value='";
                    echo $listeMatiere[$a]['id'];
                    echo "' /></td>";
               echo "<td><input type='number' name='coef[]' id='coef' step ='0.1' max='10' /></td>";
               echo "<td>";
                    echo "<select name='groupe[]'>";
                        $listGroup = $config->listGroup();
                        for($i=0;$i<count($listGroup);$i++){
                            echo "<option value='";
                            echo $listGroup[$i]['id'];
                            echo "'>".$listGroup[$i]['nom_groupe']."</option>";
                        }
                        echo "<option value='null' selected>-Choisir Groupe-</option>";
                    echo "</select>";
               echo "</td>";
            echo "</tr>";
            $x++;
        }
    }
    echo "<tr>";
        echo "<td colspan='4' align='center'>
            <input type='submit' name='addmatclss' value='Ajouter les Matières' /></td>";
    echo "</tr>";
    echo "</table>";
    }