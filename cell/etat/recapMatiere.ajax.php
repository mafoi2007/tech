<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new Config($db);
    // print_r($_POST);
    if(isset($_POST['matiere'])){
        $matiere = (int) $_POST['matiere'];
        if($matiere==0){
            $msg = "<h3 class='alert'>Choisir une matière.</h3>";
            echo $msg;
        }else{
            $trimestre = $config->getTrimestre($_POST['matiere']);
            if(empty($trimestre)){
                $msg = "<h3 class='alert'>La Matière n'a pas fait l'objet d'évaluation.</h3>";
                echo $msg;
            }else{ ?>
                Trimestre : 
                <select name='trimestre'>
                    <?php for($i=0;$i<count($trimestre);$i++){
                        $trim = $trimestre[$i];
                        echo "<option value='".$trim."'>Trimestre ".$trim."</option>";
                    }?>
                </select>
                <input 
                    type='hidden' 
                    name='to_print' 
                    value='RecapMatiere' />
                <input 
                    type='submit' 
                    name='print' 
                    value='Générer' />
            <?php }
        }
    }
?>