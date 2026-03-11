<h1 class='alert'>Ajouter un élève</h1>
<form method='post' action='../traitement.php'>
	<?php 
		// On affiche le formulaire en fonction des sections 
		$nbSection = $config->getNbSection();
		if($nbSection==1){  // On a une seule section 
			$listeClasse = $config->viewClasseAll('actif');
			if(empty($listeClasse)){
				echo "<h4 class='alert'>Vous devez d'abord créer des classes.</h4>";
			}else{ ?>
				<p>Classe : 
					<select name='clas' id='clas' onChange='addEleve()'>
<?php 
						for($nb=0;$nb<count($listeClasse);$nb++){
							echo "<option value=";
							echo $listeClasse[$nb]['id'];
							echo ">";
							echo strtoupper($listeClasse[$nb]['nom_classe']);
							echo "</option>\n";
						} ?>
						<option value='null' selected>-Choisir une Classe-</option>
					</select>
<?php 
			}
		}else{   // On a les deux sections 
	?>
			<p>Classe :
				<select name="clas" id='clas' onChange='addEleve()'>
					<?php
					$listeFr = $config->viewClasseSection('actif', 'fr');
					$listeEn = $config->viewClasseSection('actif', 'en');
					echo "<optgroup label='Section Francophone'></optgroup>";	
						for($nb = 0; $nb <count($listeFr);$nb++) {
							echo "<option value=";
							echo $listeFr[$nb]['id'];
							echo ">";
							echo strtoupper($listeFr[$nb]['nom_classe']);
							echo "</option>\n";
						}
					
					echo "<optgroup label='Section Anglophone'></optgroup>";
						for($na = 0; $na <count($listeEn);$na++) {
							echo "<option value=";
							echo $listeEn[$na]['id'];
							echo ">";
							echo strtoupper($listeEn[$na]['nom_classe']);
							echo "</option>\n";
						}
					
					?>
					<option value='null' selected>-Choisir une Classe-</option>
				</select></p>
<?php 
		} ?>			
			<div id='eleve'>
				
			</div>
</form>