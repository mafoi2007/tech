<?php 
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
    if(isset($_POST['nomEleve'])){
        $eleve = $_POST['nomEleve'];
        if(strlen($eleve)==0){
            echo "<h3 class='alert'>Vous devez saisir au moins une partie du nom.</h3>";
        }else{
            $resultat = $config->findEleve($eleve);
            if(empty($resultat)){
                echo "<h3 class='alert'>Aucun élève ne correspond à votre recherche.</h3>";
            }else{ ?>
                <h1>Resultats de la recherche</h1>
                <table border='1' width='70%' align='center'>
                    <tr>
                        <th>Cocher</th>
                        <th>Noms et Prénoms</th>
                    </tr>
                <?php 
                for($i=0;$i<count($resultat);$i++){
                    echo "<tr>
                        <td><input type='radio' name='eleve' value='".$resultat[$i]['id']."' /></td>
                        <td>".$resultat[$i]['nom_complet']."
                        <input type='hidden' name='to_print' value='certificatScol' />
                        </td>
                    </tr>";
                }
                ?>
                    <tr>
                        <td colspan='5' align='center'>
                            <input type='submit' name='print' value='Editer' />
                        </td>
                    </tr>
                </table>
            
<?php       }
        }
    }