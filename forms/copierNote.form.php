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
		name='sequenceDepart'
		value='<?php echo $_POST['periode']; ?>' />
    <input 
		type='hidden'
		name='sequenceArrivee'
		value='<?php echo ($_POST['periode']+1); ?>' />
	<fieldset>
		<legend><h3 class='bien'>Confirmation</h3></legend>
		<h4>Vous avez choisi de copier les notes de <font class='bien'>
			<?php echo $nomMatiere['nom_matiere']; ?></font> en 
		<font class='bien'><?php echo $nomClasse['nom_classe']; ?></font> de la 
			<font class='bien'><?php echo $nomSequence['nom_periode']; ?></font> pour la 
            <font class='alert'>Séquence <?php echo ($_POST['periode']+1) ?> 
		<input 
			type='submit' name='copyNote' value='Confirmer' /> &nbsp; &nbsp; &nbsp; &nbsp; 
		<input 
			type='submit' name='copyNote' value='Annuler' />
		</h4>
	</fieldset>
</form>
<?php 
	}else{
		echo "<h3 class='alert'>Vous n'avez pas encore saisi les notes de cette matière pour la classe.";
	}
?>


