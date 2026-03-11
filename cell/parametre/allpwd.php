<div id="body2">
    <h1 class='bien' title='Changer mot de passe enseignant'>mot de passe enseignant</h1>

	<form method='post' action='../traitement.php'>
		Type Utilisateur
			<select name='userType' id='userType' onChange='passwordUsers()'>
				<option value='null' selected>-Type Utilisateur-</option>
				<?php 
				$userType = $config->userType();
				for($i=1;$i<count($userType);$i++){
					echo "<option value='".$userType[$i]['id']."'>".$userType[$i]['libelle_poste']."</option>";
				} ?>
			</select>
		<div id='resultat' style = 'display:inline'>
		</div>
	</form>
</div>