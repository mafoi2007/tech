<?php 
	$verification = $config->verifNoteSaisie($classe, $matiere, $sequence);
	// echo '<pre>'; print_r($verification); echo '</pre>';
	if(!empty($verification)){ ?>
<form method='post' action='../traitement.php' target='_blank'>
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
		<legend><h3 class='bien'>Confirmation</h3></legend>
		<h4>Voulez - vous vraiment supprimer les notes de <font class='bien'>
			<?php echo $nomMatiere['nom_matiere']; ?></font> en 
		<font class='bien'><?php echo $nomClasse['nom_classe']; ?></font> pour le compte de la 
			<font class='bien'><?php echo $nomSequence['nom_periode']; ?></font> ? 
		<input 
			type='submit' name='deleteNote' value='Oui' /> &nbsp; &nbsp; &nbsp; &nbsp; 
		<input 
			type='submit' name='deleteNote' value='Non' />
		</h4>
	</fieldset>
</form>
<?php 
	}else{
		echo "<h3 class='alert'>Vous n'avez pas encore saisi les notes de cette matière pour la classe.";
	}
?>


