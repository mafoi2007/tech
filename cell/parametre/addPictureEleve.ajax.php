<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
    $as = $config->getCurrentYear();
    $reponse = $_POST['clas'];
    if($reponse=='null'){
        echo "<h3 class='alert'>Vous devez faire un choix.</h3>";
    }else{
        $listeEleve = $config->listeEleve($reponse, 'non_supprime',$as);
        /*echo '<pre>'; print_r($listeEleve); echo '</pre>'; */?>
        <table border='1' width='75%'>
            <tr>
                <th>Nom de l'élève</th>
                <th>Photo</th>
            </tr>
        <?php 
        for($i=0;$i<count($listeEleve);$i++){
            echo "<tr>
                <td>".$listeEleve[$i]['nom_complet']."
                    <input type='hidden' name='eleve[]' value='".$listeEleve[$i]['id']."' /></td>
                <td><input type='file' name='photoEleve[]' /></td>
            </tr>";
        } ?>
            <tr>
                <td align='center'><input type='submit' name='addPhotoEleve' value='Ajouter Photo' /></td>
                <td align='center'><input type='reset' value='Annuler' /></td>
            </tr>
        </table>
<?php 
    }