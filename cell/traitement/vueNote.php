<div id = 'body2'>
	<h1 class='alert'>Vue globale des Notes</h1>
	<form method='post' action='../traitement.php' target='_blank'>
		<?php 
		$listClasse = $config->listClassSaisie();
		// echo '<pre>'; print_r($listClasse); echo '</pre>';
		if(empty($listClasse)){
			echo "<h3 class='alert'>Aucune Note n'a encore été saisie.</h3>";
		}else{ ?>
			Classe :
				<select name="classe" id='classe' onChange='listeSequence()'>
					<option value='null' selected>-Choisir une Classe-</option>
					<?php 
					for($nb=0;$nb<count($listClasse);$nb++){
						echo "<option value=";
						echo $listClasse[$nb]['id_classe'];
						echo ">";
						echo strtoupper($listClasse[$nb]['nom_classe']);
						echo "</option>\n";
					}
					?>
				</select>
				<div id='sequence' style='display:inline'>
				</div>
<?php 
		} ?>
		
	</form>			
					<?php	
					
						/*for($nb = 0; $nb <count($listeFr);$nb++) {
							
							
							
							
							
						}*/
					?>
		
	
	
	
<?php 
	if(isset($_POST['verifMois'])){
		$classe = $_POST['clas'];
		$mois = $_POST['mois'];
		if($classe=='null'){
			$_SESSION['message'] = 'Aucune classe n a été choisie';
		}else{
			if($mois=='null'){
				$_SESSION['message'] = 'Vous devez sélectionner un mois';
				unset($_POST);
				header('Location:'.$_SERVER['PHP_SELF']);
			}else{
				$noteSaisies = $config->getNoteSaisieMois($classe, $mois);
				 ?>
				<table border='1' width='100%'>
					<caption>Mois : Mois <?php echo strtoupper($noteSaisies[0]['periode']);?></caption>
					<thead>Classe : <?php echo strtoupper($noteSaisies[0]['libelle_classe']);?></thead>
					<tr>
						<th>N°</th>
						<th>Matière</th>
						<th>Date de Saisie</th>
						<th>Date de Modification</th>
						<th>Poste de Saisie</th>
					</tr>
					<?php 
					$a = 1;
					for($i=0;$i<count($noteSaisies);$i++){
						$cle = 'libelle_competence_'.$noteSaisies[$i]['section'];
						$poste = $noteSaisies[$i]['ip_saisie'].' / ';
						$poste .= $noteSaisies[$i]['type_machine'];
						echo "<tr>
							<td>".$a."</td>
							<td>".$noteSaisies[$i][$cle]."</td>
							<td>".$noteSaisies[$i]['date_saisie_fr']."</td>
							<td>".$noteSaisies[$i]['date_modification_fr']."</td>
							<td>".$poste."</td>
						</tr>";
						$a++;
					}
					?>
					
					
				</table>
<?php 				
			}
		}
	}
?>
	
	
	
	
	
	
	
	
	
	
</div>