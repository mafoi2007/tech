<?php 
	session_start();
	require_once('../inc/connect.inc.php');
	$config = new config($db);
    $classe = (int) $_POST['classe'];
    if($classe==0){
        echo "<h3 class='alert'>Aucune classe valide choisie.</h3>";
    }else{ ?>
        <table border='1' width='100%'>
            <tr>
                <th>N°</th>
                <th>Noms et Prénoms</th>
                <th>Statut</th>
                <th>Côte</th>
                <th>Appréciation</th>
                <th>Moyenne Annuelle</th>
                <th>Décision du Conseil</th>
            </tr>
        <?php 
        $element = $config->elementConseil($classe);
        for($i=0;$i<count($element);$i++){
            echo "<tr>
                <td>".($i+1)."</td>
                <td>".$element[$i]['nom_eleve']."<input type='hidden' name='eleve[]' value='".$element[$i]['id_eleve']."' /></td>
                <td align='center'>".$element[$i]['statut']."</td>
                <td align='center'>".$element[$i]['cote']."</td>
                <td>".$element[$i]['appreciation']."</td>
                <td align='center'>".$element[$i]['moyenne']."</td>";
                echo "<td>";
                $conseil = $config->listeDecision();
                echo "<select name='decision[]'>";
				/*echo "<option value='1' ".$selected.">Admis(e)</option>";
				echo "<option value='2' ".$selected.">Redouble</option>";
				echo "<option value='3' ".$selected.">Exclu(e)</option>";*/
                for($a=0;$a<count($conseil);$a++){
                    echo "<option value='".$conseil[$a]['id']."' ".$selected.">".$conseil[$a]['valeur_decision']."</option>";
                }
				echo "<option value='null' selected>-Choisir-</option>";
                echo "</select>";
                echo "</td>
            </tr>";
        }
            echo "<tr>
                <td colspan='5' align='center'><input type='submit' name='validerConseil' value='Valide le Conseil' /></td>
                <td colspan = '3'><input type='reset' value='Annuler' /></td>
            </tr>";
        // echo '<pre>'; print_r($element); echo '</pre>';
        ?>
        </table>
<?php 
    }