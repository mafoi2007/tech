<div id="body2">
    <h1 class='bien' title='Liste des Elèves sans matricule'>Liste des Elèves sans Matricule</h1>

	<form method='post' action='../traitement.php'>
		<p>Choisir la classe : 
			<select name='clas' id='clas' onChange='listMatricule()'>
				<?php 
					$listeClasse = $config->viewClasseStudent();
					for($i=0;$i<count($listeClasse);$i++){
						$id = $listeClasse[$i]['classe'];
						$nom = strtoupper($listeClasse[$i]['nom_classe']);
						echo "<option 
							value='".$id."'>";
						echo $nom."</option>\n";
					}
				?>
				<option value='null' selected>-choisir une classe-</option>
			</select>
		</p>
		<div id='resultat'>
		</div>
	</form>
</div>