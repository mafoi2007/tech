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
        }else{ 
            $listeTrim = $config->sequencesTraiteesVraie($classe);
            // echo "<pre>"; print_r($listeTrim); echo "</pre>";
            ?>
            Séquence : 
            <select name='trimestre'>
                <?php 
                $listeTrim = $config->sequencesTraiteesVraie($classe);
                for($j=0;$j<count($listeTrim);$j++){
                    $trim = $listeTrim[$j]['sequence'];
                    echo "<option value='".$trim."'>Sequence ".$trim."</option>";
                } ?>
            </select>
            <input 
                type='hidden' 
                name='to_print' 
                value='BulletinSequentiel' />
            <input 
                type='submit' 
                name='print' 
                value='Générer' />
<?php 
        }
    }
?>