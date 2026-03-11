<div id="body2">
    <h1>conseil de classe</h1>
	<form method='post' action='../traitement.php' target = _blank>
		<p>Classe : 
			<select name='classe'>
				<?php 
					$listeClasse = $config->viewClasseAll('actif');
					for($i=0;$i<count($listeClasse);$i++){
						echo "<option value='";
						echo $listeClasse[$i]['id'];
						echo "'>".$listeClasse[$i]['nom_classe']."</option>";
					}
				?>
				<option value='null' selected>-Choix de la classe-</option>
			</select>
		</p>
		
		<input 
			type='hidden' 
			name='to_print' 
			value='ConseilClasse' />
		<p><input 
				type='submit' 
				name='print' 
				value='Imprimer le Conseil de Classe' /></p>
	</form>
</div>