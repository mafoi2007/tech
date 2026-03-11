<div id='body2'>
	<h1 class='bien'>Insérer une matière dans la classe</h1>
	<form method='post' action = '../traitement.php'>
		<table border='0' width='55%' align='center'>
			<tr>
				<th>Classe</th>
				<th> : </th>
				<th align='left'>
					<select name='classe'>
						<?php 
						$classe = $config->viewClasseAll('actif');
						if(count($classe)==0){
							echo "<option value='null'>-Aucune classe enregistrée-</option>";
						}else{
							for($i=0;$i<count($classe);$i++){
								echo "<option value='";
								echo $classe[$i]['id'];
								echo "'>";
								echo ucwords($classe[$i]['nom_classe']);
								echo "</option>";
							}
							echo "<option value='null' selected>-Choisir la classe-</option>";
						}
						?>
					</select>
				</th>
			</tr>
			<tr>
				<td colspan='5'>&nbsp;</td>
			</tr>
			<tr>
				<th>Matière</th>
				<th> : </th>
				<th align='left'>
					<select name='matiere'>
						<?php 
						$matiere = $config->getMatiereAll('actif');
						if(count($matiere)==0){
							echo "<option value='null'>-Aucune matière enregistrée-</option>";
						}else{
							for($i=0;$i<count($matiere);$i++){
								echo "<option value='";
								echo $matiere[$i]['id'];
								echo "'>";
								echo ucwords($matiere[$i]['nom_matiere']);
								echo "</option>";
							}
							echo "<option value='null' selected>-Choisir la matière-</option>";
						}
						?>
					</select>
				</th>
			</tr>
			<tr>
				<td colspan='5'>&nbsp;</td>
			</tr>
			<tr>
				<th>Coef </th>
				<th> : </th>
				<th align='left'>
					<input type='number' name='coef' id='coef' step ='0.1' min='1' max='10' value='2' />
				</th>
			</tr>
			<tr>
				<td colspan='5'>&nbsp;</td>
			</tr>
			<tr>
				<th>Groupe</th>
				<th> : </th>
				<th align='left'>
					<select name='groupe'>
						<?php 
						$listGroup = $config->listGroup();
						for($i=0;$i<count($listGroup);$i++){
							echo "<option value='".$listGroup[$i]['id']."'>".$listGroup[$i]['nom_groupe']."</option>";
						}
						?>
					</select>
				</th>
			</tr>
			<tr>
				<td colspan='5'>&nbsp;</td>
			</tr>
			<tr>
				<td colspan='5' align='center'>
					<input type='submit' name='addmatcls' value='Ajouter la matière' />
				</td>
			</tr>
		</table>
	</form>
</div>