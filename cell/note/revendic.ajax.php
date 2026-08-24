<?php 
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
    // print_r($_POST);
    $classe = (int) $_POST['classe'];
    if($classe == 0){
        echo "<h3 class='alert'>Vous devez choisir une classe.</h3>";
    }else{
        $listeEleve = $config->listeEleve($classe, 'non_supprime', '');
        // echo '<pre>'; print_r($listeEleve); echo '</pre>';
        $_SESSION['classe'] = $_POST['classe'];
        // $_SESSION['classe'] = $classe;
        // echo '<pre>'; print_r($matiere); echo '</pre>';
        if(empty($listeEleve)){
            echo "<h3 class='alert'>Aucun élève dans la classe.</h3>";
        }else{ ?>
            Elève : <select name='eleve' id='eleve' onChange='getSequenceListNt()'>
                <option value='null' selected>-Choisir Elève-</option>
                <?php 
                for($i=0;$i<count($listeEleve);$i++){
                    echo "<option value='".$listeEleve[$i]['id']."'>";
                    echo $listeEleve[$i]['nom_complet']."</option>";
                }?>
            </select>
            <div id='sequence' style = 'display:inline'>
            </div>
<?php 
        }
    }
    
    