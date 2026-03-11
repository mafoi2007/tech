<h1 class='alert'>Ajouter une classe</h1>
<form method='post' action='../traitement.php' enctype='multipart/form-data'>
	<p>Niveau de la classe :
		<select name="niveau" id="niveau" onChange='addClasse()'>
			<?php 
			$listeNiveau = $config->listeNiveaux();
			for($i=0;$i<count($listeNiveau);$i++){
				echo "<option value='".$listeNiveau[$i]['id']."'>".$listeNiveau[$i]['nom_niveau']."</option>";
			} ?>
			<option value='null' selected>-Choisir un niveau-</option>
		</select>
		<div id='clas'>
				
		</div>
			
</form>