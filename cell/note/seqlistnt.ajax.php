<?php 
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
    // print_r($_POST);
    $eleve = (int) $_POST['eleve'];
    $classe = $_SESSION['classe'];
    if($eleve==0){
        echo "<h3 class='alert'>Vous devez choisir un élève.</h3>";
    }else{
        $sequenceActive = $config->periodeSaisieRevendication($classe);
        // echo '<pre>'; print_r($sequenceActive); echo '</pre>';
        if(empty($sequenceActive)){
            echo "<h3 class='alert'>Aucune séquence active pour le moment .</h3>";
        }else{ ?>
            Séquence : <select name='periode' id='periode' onChange='revendicationNt()'>
                <option value='null' selected>-Choisir Séquence-</option>
                <?php 
                for($i=0;$i<count($sequenceActive);$i++){
                    echo "<option value='".$sequenceActive[$i]['id_periode']."'> Séquence ";
                    echo $sequenceActive[$i]['id_periode']."</option>";
                } ?>
            </select>
            <div id='addNt' style = 'display:inline'>
            </div>
<?php
        }
    }