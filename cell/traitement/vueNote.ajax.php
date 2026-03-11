<?php 
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
	// print_r($_POST);
	$classe = (int) $_POST['classe'];
	// echo $classe;
	if(empty($classe)){ ?>
		<h3 class='alert'>Vous devez sélectionner une classe.</h3>
<?php 
	}else{ 
		$sequence = $config->listSequenceSaisie($classe);
		if(empty($sequence)){ ?>
			<h3 class='alert'>Oups !!! Aucune note saisie dans cette classe.</h3>
<?php 
		}else{
			// echo '<pre>'; echo var_dump($sequence); echo '</pre>';
			// echo '<pre>'; print_r($sequence); echo '</pre>';
		}		
		?>
		Séquence : 
		<select name='sequence' id='sequence'>
			<?php 
			for($i=0;$i<count($sequence);$i++){
				echo "<option value='";
				echo $sequence[$i]['id_periode'];
				echo "'>".$sequence[$i]['nom_periode']."</option>";
			} ?>
		</select>
		<input type='hidden' name='to_print' value='VisualiserNoteSequentielle' />
		<input type='submit' name='print' value='Valider' />
<?php 	
	}