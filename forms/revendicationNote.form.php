<form method='post' action = '../traitement.php' target='_blank'>
    <fieldset>
        <legend><h3 class='bien'>Informations de base</h3></legend>
        <h3>Nom de l'élève : 
            <font class='alert'>
                <?php echo $infoEleve['nom_complet']; ?>
            </font>
            <input 
                type='hidden' 
                name='eleve' 
                value='<?php echo $infoEleve['id']; ?>' />
        </h3>
        <h3>Classe de l'élève : 
            <font class='alert'>
                <?php echo $infoEleve['nom_classe']; ?>
            </font>
            <input 
                type='hidden' 
                name='classe' 
                value='<?php echo $infoEleve['classe']; ?>' />
        </h3>
        <h3>Période Concernée : 
            <font class='alert'>
                <?php echo $infoSequence['nom_periode']; ?>
            </font>
            <input 
                type='hidden' 
                name='periode' 
                value='<?php echo $infoSequence['id']; ?>' />
        </h3>
    </fieldset>
    <table border='1' width='100%'>
        <tr>
            <th>N°</th>
            <th>Matière</th>
            <th>Anc. Valeur</th>
            <th>Nv. Valeur</th>
            <th>Annuler Note</th>
        </tr>
        <?php 
        for($i=0;$i<count($listeMatiere);$i++){
            echo "<tr>";
                echo "<td align='center'>".($i+1)."</td>";
                echo "<td>".$listeMatiere[$i]['nom_matiere'];
                echo "<input type='hidden' name='matiere[]' value='";
                echo $listeMatiere[$i]['id_matiere']."' /></td>";
                echo "<td>";
                for($j=0;$j<count($valeurNote);$j++){
                    if($listeMatiere[$i]['id_matiere']==$valeurNote[$j]['id_matiere']){
                       echo "<input 
                                type='text' 
                                value='".$valeurNote[$j]['note']."' 
                                size='5' 
                                disabled />";
                    }
                }
                echo "</td>";
                echo "<td>";
                    echo "<input 
                            type='number' 
                            name='note[]' 
                            size='5' 
                            step='0.25'
                            min = ='0'
                            max = '20' />";
                echo "</td>";
                echo "<td><input type='checkbox' name='reset[".$listeMatiere[$i]['id_matiere']."]' </td>";
            echo "</tr>";
        }?>
        <tr>
            <td align='center' colspan='6'>
                <input 
                    type='submit'
                    name='revendic'
                    value='Valider' />
            </td>
        </tr>
    </table>
</form>