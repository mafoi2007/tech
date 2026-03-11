<div id='body2'>
    <h1 class='bien'>Vue d'ensemble des Effectifs</h1>
	On affiche l'effectif des élèves par classe et par sexe sous forme de tableau.
	
	
	<form method='post' action='../traitement.php' target=_blank>
		<table border='0' width='70%' align='center'>
			<tr>
				<th>Vue d'ensemble des effectifs</th>
			</tr>
			<tr>
				<input type='hidden' name='to_print' value='vueEffectif' />
				<td align='center'>
				<input 
					type='submit' 
					name='print' 
					value='Imprimer' /></td>
			</tr>
		</table>
	</form>
</div>