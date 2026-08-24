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
			?>
			<input type='submit' name='TraiterMoyenneAnnuelle' value='Traiter' />
<?php 
		}
	}
?>