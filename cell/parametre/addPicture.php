<div id="body2">
    <h1 class='bien'>ajouter des photos</h1>
	<form method='post' action='../traitement.php' enctype='multipart/form-data'>
		Je veux ajouter les photos pour : 
			<select name='personne' id='personne' onChange='TypePhoto()'>
				<option value='null'>-Choisir-</option>
				<option value='eleve'>Elève</option>
				<option value='utilisateur'>Enseignant</option>
			</select>

		<div id='resultat' style = 'display:inline'>
		</div>
	</form>
</div>


