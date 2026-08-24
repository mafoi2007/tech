<?php 
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
    // print_r($_POST);
    $subject = (int) $_POST['subject'];
    $classe = $_SESSION['classe'];
    if($subject==0){
        echo "<h3 class='alert'>Vous devez choisir une matière.</h3>";
    }else{
        $sequenceActive = $config->periodeSaisie($classe, $subject);
        // echo '<pre>'; print_r($sequenceActive); echo '</pre>';
        if(empty($sequenceActive)){
            echo "<h3 class='alert'>Aucune séquence active pour le moment .</h3>";
        }else{ ?>
            Séquence : <select name='periode' id='periode' onChange='saveNoteCpNt()'>
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