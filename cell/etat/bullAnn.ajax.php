<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new Config($db);
    // print_r($_POST);
    if(isset($_POST['classe'])){
        $classe = (int) $_POST['classe'];
        if($classe==0){
            $msg = "<h3 class='alert'>Choisir une classe.</h3>";
            echo $msg;
        }else{ ?>
            <input 
                type='hidden' 
                name='to_print' 
                value='BulletinAnnuel' />
            <input 
                type='submit' 
                name='print' 
                value='Générer' />
<?php 
        }
    }
?>