<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new Config($db);
    // print_r($_POST);
    if(isset($_POST['classe'])){
        $classe = (int) $_POST['classe'];
        if($classe==0){
            $msg = "<h3 class='alert'>Veuillez choisir une classe</h3>";
            echo $msg;
        }else{ ?>
            <input type='submit' name='TraiterNoteAnnuelle' value='Traiter' />
<?php 
        }
    }
?>