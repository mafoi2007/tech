<?php 
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
    // print_r($_POST);
    $classe = (int) $_POST['classe'];
    if($classe == 0){
        echo "<h3 class='alert'>Vous devez choisir une classe.</h3>";
    }else{
        $matiere = $config->getMatiereSaisie($_POST['classe']);
        $_SESSION['classe'] = $_POST['classe'];
        // $_SESSION['classe'] = $classe;
        // echo '<pre>'; print_r($matiere); echo '</pre>';
        if(empty($matiere)){
            echo "<h3 class='alert'>Il semble que vous n'ayez pas de matière dans cette classe.</h3>";
        }else{ ?>
            Matière : <select name='subject' id='subject' onChange='getSequenceCpNt()'>
                <option value='null' selected>-Choisir Matière-</option>
                <?php 
                for($i=0;$i<count($matiere);$i++){
                    echo "<option value='".$matiere[$i]['id_matiere']."'>";
                    echo $matiere[$i]['nom_matiere']."</option>";
                }?>
            </select>
            <div id='sequence' style = 'display:inline'>
            </div>
<?php 
        }
    }
    
    