<?php 
	session_start();
	require_once('../inc/connect.inc.php');
	$config = new config($db);
	$nbSection = $config->getNbSection();
	if(isset($_POST['niveau'])){
		$niveau = (int) $_POST['niveau'];
		if($niveau==0){
			echo "<h3 class='alert'>Vous devez choisir un niveau.</h3>";
		}else{ ?>
			<table border='0' width='70%'>
				<tr>
					<td>Section </td>
					<td> : </td>
					<td>
					<select name='section' id='section'>
						<?php 
						if($nbSection==1){
							echo "<option value='fr'>Section Francophone</option>";
						}else{
							echo "<option value='fr'>Section Francophone</option>";
							echo "<option value='en'>Section Anglophone</option>";
						}
						?>
					</select>
					</td>
				</tr>
				<tr>
					<td colspan='3'>&nbsp;</td>
				</tr>
				<tr>
					<td><label for='nomClasse'>Nom de la Classe</label></td>
					<td> : </td>
					<td><input 
							type='text' 
							id='nomClasse'
							name='nomClasse' 
							size='25'
							placeholder="Exemple: Sixième A" 
							maxlength='22'
							required
							/>
					</td>
				</tr>
				<tr>
					<td colspan='3'>&nbsp;</td>
				</tr>
				<tr>
					<td><label for='codeClasse'>Code de la Classe</label></td>
					<td> : </td>
					<td><input 
							type='text' 
							id='codeClasse'
							name='codeClasse' 
							size='25'
							placeholder="Exemple: 6A" 
							maxlength='15'
							required
							/></td>
				</tr>
				<tr>
					<td colspan='3'>&nbsp;</td>
				</tr>
				
				<tr>
					<td colspan='3' align='center'>
						<input 
							type="submit" 
							name="ajout_classe" 
							value="Ajouter la classe" />
					</td>
				</tr>
			</table>
			
			
<?php 		}
	}