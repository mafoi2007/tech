<?php 
session_start();
require_once('../../inc/connect.inc.php');
$finance = new Finance($db);
$config = new Config($db);
if(isset($_POST['classe'])){
    $classe = (int) $_POST['classe'];
    $nomClasse = $config->getClasse($classe);
    // print_r($nomClasse);
    if(empty($classe)){
        echo "<h3 class='alert'>Vous devez choisir une classe.</h3>";
    }else{ ?>
        <h2>Liste des Rubriques de la <?php echo $nomClasse['nom_classe']; ?></h2>
        <table border='1' width='75%'>
            <tr>
                <th>N°</th>
                <th>Libellé Rubrique</th>
                <th>Montant Rubrique</th>
            </tr>
            <?php 
            $listeRubrique = $finance->listeRubriqueClasse($_POST['classe']);
            $totalScolarite = $finance->totalScolarite($_POST['classe']);
            // print_r($totalScolarite);
            if(empty($listeRubrique)){ ?>
            <tr>
                <th colspan='5' class='alert'>Pas encore de Rubrique pour la classe</th>
            </tr>
            <?php }else{
                $a = 1;
                for($i=0;$i<count($listeRubrique);$i++){
                    echo "<tr>
                    <td>".$a."</td>
                    <td>".str_replace('_',' ',$listeRubrique[$i]['nom_rubrique'])."</td>
                    <td align='right'>".$listeRubrique[$i]['montant']."</td>
                    </tr>";
                    $a++;
                }
                echo "<tr>
                <th colspan='2'>Total</th>
                <th>".$totalScolarite['scolarite']."</th>
                </tr>";
            } ?>
        </table>
<?php
    }
}
// print_r($_POST);