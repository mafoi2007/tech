<?php 
	session_start();
	require_once('../inc/connect.inc.php');
	$config = new config($db);
	if(isset($_POST['userType'])){
		$userType = (int) $_POST['userType'];
		if($userType==0){
			echo "<h3 class='alert'>Vous devez choisir une fonction.</h3>";
		}elseif($userType==1){
			echo "<h3 class='alert'>Un administrateur existe déjà. Choisisez une autre fonction.</h3>";
		}else{  ?>
			<table border='0' width='80%'>
				<tr>
					<td>Nom de l'utilisateur : </td>
					<td><input
							type='text'
							name='nom'
							id='nom'
							size='50'
							maxlength='50'
							placeholder='Nom de l utilisateur' />
					</td>
				</tr>
				<tr>
					<td>Prénom de l'utilisateur</td>
					<td><input
							type='text'
							name='prenom'
							id='prenom'
							size='50'
							maxlength='50'
							placeholder='prenom de l utilisateur' />
					</td>
				</tr>
				<tr>
					<td>Sexe de l'utilisateur: </td>
					<td><select name="sexe" id="sexe">
							<option value="M">Masculin</option>
							<option value="F">Féminin</option>
							<option value='NULL' selected>-Sexe-</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Login de l'utilisateur</td>
					<td><input
							type='text'
							name='login'
							id='login'
							size='20'
							maxlength='20'
							placeholder='login de l utilisateur' />
					</td>
				</tr>
				<tr>
					<td colspan='5' align='center'>
						<input 
							type='submit' 
							name='ajout_utilisateur' 
							value='Enregistrer' />
					</td>
				</tr>
			</table>

<?php 		
		}
	}