<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
	$reponse = $_POST['userType'];
    if($reponse=='null'){
        echo "<h3 class='alert'>Vous devez faire un choix.</h3>";
    }else{
        $listeUtilisateur = $config->getUtilisateurType($reponse);
		/*echo '<pre>'; print_r($listeUtilisateur); echo '</pre>';*/
       if(empty($listeUtilisateur)){
		echo "<h3 class='alert'>Aucun utilisateur pour ce poste.</h3>";
	   }else{ ?>
	   		<table border='1' width='75%'>
				<tr>
					<th>Nom de l'utilisateur</th>
                	<th>Photo</th>
				</tr>
				<?php 
				for($i=0;$i<count($listeUtilisateur);$i++){
					echo "<tr>
						<td>".$listeUtilisateur[$i]['nom']."
						<input type='hidden' name='eleve[]' value='".$listeUtilisateur[$i]['idEnseignant']."' /></td>
						<td><input type='file' name='photoUtilisateur[]' /></td>
					</tr>";
				} ?>
				<tr>
                	<td align='center'><input type='submit' name='addPhotoUtilisateur' value='Ajouter Photo' /></td>
                	<td align='center'><input type='reset' value='Annuler' /></td>
            	</tr>
			</table>
<?php 
	   }
    }