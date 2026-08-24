<h1 class='alert'>Ajouter une matière</h1>
<form method='post' action='../traitement.php'>
	<p title="Le Nom de la Matière tel qu'il apparait dans le bulletin">Nom de la matière :
		<input 
            type='text'
            name='nom_matiere'
            id = 'nom_matiere'
            placeholder='nom de la matière'
            required />
    </p>
    <p>Code la matière : 
        <input 
            type='text'
            name='code_matiere'
            id='code_matiere'
            placeholder='code la matière'
            required />
    </p>
    <input type="submit" name="ajout_matiere" value="ajouter la matiere" />
</form>