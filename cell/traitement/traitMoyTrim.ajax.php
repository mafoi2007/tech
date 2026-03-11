<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new Config($db);
	// print_r($_POST['classe']);
	if(isset($_POST['classe'])){
		$classe = $_POST['classe'];
		if($classe=='null'){
			echo "<h3 class='alert'>Choisisez une classe.</h3>";
		}else{
			$trimestre = $config->trimestresTraites($classe); ?>
			Trimestre : 
			<select name='trimestre'>
				<?php 
				for($j=0;$j<count($trimestre);$j++){
					$idSeq = $trimestre[$j]['trimestre'];
					$libSeq = strtoupper($trimestre[$j]['trimestre']);
					echo "<option value='".$idSeq."'>Trimestre ".$libSeq."</option>";
				}
				?>
			</select>
			<input type='submit' name='TraiterMoyenneTrimestrielle' value='Traiter' />
<?php 
		}
	}
?>