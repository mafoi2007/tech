<?php 
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
    // print_r($_POST);
    $subject = (int) $_POST['subject'];
    if($subject==0){
        echo "<h3 class='alert'>Vous devez choisir une matière.</h3>";
    }else{
        $sequenceActive = $config->periodeSaisie($_SESSION['classe'], $subject);
        // echo '<pre>'; print_r($sequenceActive); echo '</pre>';
        if(empty($sequenceActive)){
            echo "<h3 class='alert'>Aucune note saisie pour le moment.</h3>";
        }else{ ?>
            Séquence : <select name='periode' id='periode' onChange='saveNoteViewNt()'>
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