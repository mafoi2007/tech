<div id='body2'>
    <h1 class='alert'>Liste des Rubriques</h1>
    <form method='post' action='../traitement.php' target=_blank>
        <table border='1' width='70%' align='center'>
            <tr>
                <th>N°</th>
                <th>Nom de la Rubrique</th>
                <th>Code de la Rubrique</th>
                <th>Option </th>
                <th>Observations</th>
            </tr>
            <?php 
            $listeRubrique = $finance->listeRubriqueAll();
            // echo '<pre>';print_r($listeRubrique); echo '</pre>';
            $nb = 1;
            for($i=0;$i<count($listeRubrique);$i++){
                $lien = $_SERVER['PHP_SELF']."?action=";
                $lienMod = $lien."edit&amp;id=".$listeRubrique[$i]['id']."#body2";
                $lienSup = $lien."delete&amp;id=".$listeRubrique[$i]['id']."#body2";
                $lienUpd = $lien."update&amp;id=".$listeRubrique[$i]['id']."#body2"; ?>
            <tr>
                <td><?php echo $nb; ?></td>
                <td><?php echo str_replace('_', ' ', utf8_decode(stripslashes($listeRubrique[$i]['nom_rubrique']))); ?></td>
                <td><?php echo str_replace('_', ' ', utf8_decode(stripslashes($listeRubrique[$i]['code_rubrique']))); ?></td>
                <td><a href='<?php echo $lienMod; ?>'>Modifier</a></td>
                <?php 
                if($listeRubrique[$i]['etat']=='actif'){ ?>
                    <td><a href='<?php echo $lienSup; ?>'>Supprimer</a></td>
                <?php }elseif($listeRubrique[$i]['etat']=='inactif'){ ?>
                    <td><a href='<?php echo $lienUpd; ?>'><i><font color='red'>Restaurer</font></i></a></td>
               <?php  } ?>
            </tr>
           <?php  
                $nb++;
           } ?>
        </table>
    </form>
</div>