<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
    // print_r($_POST);
    $classe = (int) $_POST['classe'];
    // print_r($classe);
    if(empty($classe)){
        echo "<h3 class='alert'>Vous devez choisir une classe.</h3>";
    }else{
        $listMatiere = $config->getMatiereClasse($classe);
        // echo '<pre>'; print_r($listMatiere); echo '</pre>';
        if(empty($listMatiere)){
             echo "<h3 class='alert'>Il vous faut d'abord enregistrer les matières dans cette classe.</h3>";
        }else{  ?>
            <table border='01' width='90%'>
                <tr>
                    <th>Classe</th>
                    <th>Matière</th>
                    <th>Enseignant</th>
                </tr>
                <?php 
            for($x=0;$x<count($listMatiere);$x++){ ?>
                <tr>
                     <td align='center'>
                        <input 
                            type='text'
                            size='25' 
                            value='<?php echo $listMatiere[$x]['nom_classe']; ?>' 
                            disabled />
                    </td>
                    <td align='center'>
                        <input 
                            type='text'
                            size='40' 
                            value='<?php echo $listMatiere[$x]['nom_matiere']; ?>' 
                            readonly />
                        <input 
                            type='hidden'
                            name='matiere[]'
                            value='<?php echo $listMatiere[$x]['id']; ?>' />
                    </td>
                    <td>
                        <select name='enseignant[]'>
                        <?php 
                        $postes = $config->userType();
                        for($y=1;$y<count($postes);$y++){
                            echo "<optgroup label='".$postes[$y]['libelle_poste']."'>";
                            $users = $config->getUtilisateurType($postes[$y]['id']);
                            for($z=0;$z<count($users);$z++){
                                echo "<option value='";
                                echo $users[$z]['idEnseignant'];
                                echo "'>".stripslashes($users[$z]['nom'])."</option>";
                            }
                            echo "</optgroup>";
                        } ?>
                            <option value='null' selected>-Choisir Enseignant-</option>
                        </select>
                    </td>
                </tr>
<?php                    
            } ?>
                <tr>
                    <td colspan='5' align='center'>
                        <input
                            type='submit'
                            name='addprofcls'
                            value='Enregistrer' />
                    </td>
                </tr>
            </table>
 <?php           
        }
    }