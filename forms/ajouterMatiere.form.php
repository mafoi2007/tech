<h1 class='alert'>Ajouter une matière</h1>
<form method='post' action='../traitement.php'>
	<p>Je veux ajouter 
		<select name='nbMatiere' id='nbMatiere' onChange='nbMatiere()'>
			<option value='1' selected>1</option>
			<option value='2'>2</option>
			<option value='3'>3</option>
			<option value='4'>4</option>
			<option value='5'>5</option>
		</select>
		Matière(s)</p>
	<div id='ajoutMat'>
	</div>
</form>
	
	
	
	
	
	
	
	
	
	
	
	<table border='1' width='100%'>
		<tr>
			<th>N°</th>
			<th>Nom de la Matière</th>
			<th>Code de la Matière</th>
		</tr>
		<tr>
			<td>
				1
			</td>
			<td>
				<input 
					type='text'
					name='nom_matiere[]'
					id = 'nom_matiere[]'
					size='50'
					placeholder='nom de la matière'
					required />
			</td>
			<td>
				<input 
					type='text'
					name='code_matiere[]'
					id='code_matiere[]'
					placeholder='code la matière'
					required />
			</td>
		</tr>
		<tr>
			<td>
				2
			</td>
			<td>
				<input 
					type='text'
					name='nom_matiere[]'
					id = 'nom_matiere[]'
					size='50'
					placeholder='nom de la matière'
					required />
			</td>
			<td>
				<input 
					type='text'
					name='code_matiere[]'
					id='code_matiere[]'
					placeholder='code la matière'
					required />
			</td>
		</tr>
		<tr>
			<td>
				3
			</td>
			<td>
				<input 
					type='text'
					name='nom_matiere[]'
					id = 'nom_matiere[]'
					size='50'
					placeholder='nom de la matière'
					required />
			</td>
			<td>
				<input 
					type='text'
					name='code_matiere[]'
					id='code_matiere[]'
					placeholder='code la matière'
					required />
			</td>
		</tr>
	</table>
    <input type="submit" name="ajout_matiere" value="ajouter la matiere" />
</form>