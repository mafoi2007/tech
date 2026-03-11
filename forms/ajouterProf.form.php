<h1 class='alert'>Ajouter un enseignant</h1>
<form method='post' action='../traitement.php' enctype='multipart/form-data'>
	<p>Fonction de l'enseignant :
		<select name="userType" id="userType" onChange='addProf()'>
			<?php 
			$userType = $config->userType();
			for($i=0;$i<count($userType);$i++){
				echo "<option value='".$userType[$i]['id']."'>".$userType[$i]['libelle_poste']."</option>";
			} ?>
			<option value='null' selected>-Choisir une fonction-</option>
		</select>
		<div id='valeur'>
				
		</div>
			
</form>