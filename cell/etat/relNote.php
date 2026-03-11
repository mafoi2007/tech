<div id='body2'>
    <h1 class='bien'>Relevé de Notes de la classe</h1>
	<?php 
	$listeClasse = $config->viewClasseStudent();
	?>
	<form method='post' action='../traitement.php' target='_blank'>
		<p>Choisir la Classe : 
			<select name='classe'>
				<?php 
					if(empty($listeClasse)){
						echo "<option value='null'>Aucun élève pour l'instant</option>";
					}else{
						for($i=0;$i<count($listeClasse);$i++){
							echo "<option value='";
							echo $listeClasse[$i]['classe'];
							echo "'>".$listeClasse[$i]['nom_classe']."</option>";
						}
						echo "<option value='null' selected>-classe-</option>";
					}
				?>
			</select>
			<input type='hidden' name='to_print' value='releveNote' />
			<input type='hidden' name='print' value='Générer' />					
									 						
			<input type='submit' name='validerClasse' value='Choisir' />
		</p>
	</form>
</div>