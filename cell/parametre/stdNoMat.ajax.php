<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
    $classe = (int) $_POST['clas'];
    if(empty($classe)){
        echo "<h3 class='alert'>Vous devez choisir une classe.</h3>";
    }else{
        $listeEleve = $config->listeEleveSansMatricule($classe,'non_supprime');
        $nbVal = count($listeEleve);
        ?>
        <table border='1' width='100%'>
            <tr>
                <th>N°</th>
                <th>Noms et Prénoms</th>
                <th>Statut</th>
                <th>Matricule</th>
            </tr>
<?php 
        if($nbVal==0){
            echo "<tr>
                <td colspan='5' align='center' class='bien'>Aucun élève sans matricule</td>
            </tr>
            </table>";
        }else{
            $a = 1;
            for($i=0;$i<$nbVal;$i++){ ?>
            <tr>
                <td><?php echo $a; ?></td>
                <td><?php echo $listeEleve[$i]['nom_complet']; ?></td>
                <td><?php echo $listeEleve[$i]['statut']; ?></td>
                <td>
                    <input type='hidden' name='eleve[]' value='<?php echo $listeEleve[$i]['id']; ?>' />
                    <input type='text' name='rne[]' placeholder='Matricule National' />
                </td>
            </tr>
<?php   
            $a++;
            }  ?>
            <tr>
                <td colspan='2' align='center'><input type='submit' name='addMatricule' value='Enregistrer' /></td>
                <td colspan='2' align='center'><input type='reset' value='Annuler' /></td>
            </tr>
<?php 
        }  ?>
            
        </table>
<?php 
    }
?>