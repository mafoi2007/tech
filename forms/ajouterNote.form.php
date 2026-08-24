<?php 
	$verification = $config->verifNoteSaisie($classe, $matiere, $sequence);
	if($verification==false){ ?>
<form method='post' action='../traitement.php'>
	<input 
		type='hidden'
		name='classe'
		value='<?php echo $_POST['classe']; ?>' />
	<input 
		type='hidden'
		name='matiere'
		value='<?php echo $_POST['subject']; ?>' />
	<input 
		type='hidden'
		name='sequence'
		value='<?php echo $_POST['periode']; ?>' />
	<fieldset>
		<legend><h3 class='bien'>Saisie des Notes Séquentielles</h3></legend>
		<p>Classe : <input type='text' value='<?php echo $nomClasse['nom_classe']; ?>' disabled />
			Matière : <input type='text' value='<?php echo $nomMatiere['nom_matiere']; ?>' disabled />
			Séquence : <input type='text' value='<?php echo $nomSequence['nom_periode']; ?>' disabled />
		</p>
	</fieldset>
	<table border='1' width='75%' align='center'>
		<tr>
			<th colspan='5'>
				<b> Compétence Evaluée : 
					<input 
						type = 'text' 
						placeholder = 'Enoncé de la compétence'
						name='competence' 
						size='45'
						required /></b>
			</th>
		</tr>
		<?php 
		$a = 1;
		for($i=0;$i<count($listeEleve);$i++){ ?>
			<tr>
				<td><?php echo $a; ?></td>
				<td>
					<?php echo $listeEleve[$i]['nom_complet']; ?>
					<input 
						type='hidden'
						name='eleve[]'
						value='<?php echo $listeEleve[$i]['id']; ?>' />
				</td>
				<td>
					<input 
						type='number'
						name='note[]'
						class='note-input'
						step='0.01' 
						max='20' 
						min='0'/>
				</td>
			</tr>
<?php 
			$a++;
		}
		?>
		<tr>
			<td colspan='5' align='center'><input type='submit' name='saveNote' value='Enregistrer' /></td>
		</tr>
	</table>
</form>

<script>
	(function(){
		var noteInputs = document.querySelectorAll("input.note-input");
		for(var i = 0; i < noteInputs.length; i++){
			noteInputs[i].addEventListener("keydown", function(event){
				if(event.key === "Enter"){
					event.preventDefault();
					var index = Array.prototype.indexOf.call(noteInputs, event.target);
					if(index > -1 && index < noteInputs.length - 1){
						noteInputs[index + 1].focus();
						noteInputs[index + 1].select();
					}
				}
			});
		}
	})();
</script>
	
<?php 	
	}else{
		$msg = "<h3 class='alert'>Les Notes de: <b class='bien'>".$nomMatiere['nom_matiere'];
		$msg .= "</b> de la classe <b class='bien'>".$nomClasse['nom_classe']."</b> pour la ";
		$msg .=" séquence <b class='bien'>".$nomSequence['nom_periode']."</b> ont déjà été saisies le ";
		$msg .= $verification['date_fr']." à ".$verification['heure_fr'];
		$msg .= ". Reportez-vous au menu <i><u>Modifier des Notes</u></i> ";
		$msg .= "pour des éventuels changements de notes.</h3>";
		echo $msg;
	}
?>