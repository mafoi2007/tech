<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new Config($db);
    // print_r($_POST);
    if(isset($_POST['trimestre'])){
        $trimestre = $_POST['trimestre'];
        if($trimestre=='null'){
            $msg = "<h3 class='alert'>Choisir un trimestre.</h3>";
            echo $msg;
        }else{ ?>
            <input 
                type='hidden' 
                name='to_print' 
                value='StatTrimestriel' />
            <input 
                type='submit' 
                name='print' 
                value='Générer' />
<?php 
        }
    }
?>