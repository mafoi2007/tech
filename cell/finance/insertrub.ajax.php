<?php 
session_start();
require_once('../../inc/connect.inc.php');
$finance = new Finance($db);
if(isset($_POST['classe'])){
    $classe = (int) $_POST['classe'];
    if(empty($classe)){
        echo "<h3 class='alert'>Vous devez choisir une classe.</h3>";
    }else{ ?>
        <b>&nbsp; &nbsp; Rubrique :</b>
        <select name='rubrique'>
            <option value='null' selected>-Choisir-</option>
            <?php 
            $listeRubrique = $finance->listeRubrique('actif');
            for($i=0;$i<count($listeRubrique);$i++){
                $id = $listeRubrique[$i]['id'];
                $nomRubrique = str_replace('_',' ',utf8_decode($listeRubrique[$i]['nom_rubrique']));
                echo "<option value='".$id."'>".$nomRubrique."</option>";
            } ?>
        </select>
        <b>&nbsp; &nbsp; Montant : </b>
        <input 
            type='number'
            name='montant'
<?php
    }
}
print_r($_POST);