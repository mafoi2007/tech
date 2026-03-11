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
    }else{
        $listeRubrique = $finance->listeRubriqueClasse($_POST['classe']); ?>
        <h2>Rubriques Scolarité en  <?php echo $nomClasse['nom_classe']; ?></h2>
        <table border='1' width='75%'>
            <tr>
                <th>N°</th>
                <th>Libellé Rubrique</th>
                <th>Montant Rubrique</th>
                <th>Cocher pour Supprimer</th>
            </tr>
        <?php 
        if(empty($listeRubrique)){
            echo "<tr>";
                echo "<th colspan='5' class='alert'>Aucune Rubrique définie dans la classe</th>";
            echo "</tr>";
        }else{
            $a = 1;
            for($i=0;$i<count($listeRubrique);$i++){ ?>
                <tr>
                    <td><?php echo $a; ?></td>
                    <td><?php echo str_replace('_',' ',$listeRubrique[$i]['nom_rubrique']); ?></td>
                    <td align='right'><?php echo $listeRubrique[$i]['montant']; ?></td>
                    <td>
                        <input 
                            type='checkbox'
                            name='rubrique[]'
                            value='<?php echo $listeRubrique[$i]['id']; ?>'
                        />
                    </td>
                </tr>
            <?php 
                $a++;
            } ?>
            <tr>
                <td colspan='5' align='center'>
                    <input 
                        type='submit'
                        name='finance'
                        value='Supprimer la Rubrique'
                    />
                    <input 
                        type='hidden'
                        name='nature'
                        value='rmRubClass'
                    />
                </td>
            </tr>
<?php 
        } ?>
        </table>
<?php         
    }
}
// print_r($_POST);