<div id='body2'>
    <h1 class='bien'>Désigner un professeur principal</h1>
    <form method='post' action='../traitement.php'>
        <table border='1' width='75%'>
            <tr>
                <th>N°</th>
                <th>Classe</th>
                <th>Enseignant</th>
            </tr>
        <?php 
        $listClasse = $config->viewClasseAll('actif');
        $a = 1;
        for($i=0;$i<count($listClasse);$i++){ ?>
            <tr>
                <td align='center'><?php echo $a; ?></td>
                <td>
                    <?php echo $listClasse[$i]['nom_classe']; ?>
                    <input type='hidden' name='classe[]' value='<?php echo $listClasse[$i]['id']; ?>' />
                </td>
                <td>
                    <select name='prof[]'>
                        <option value='null' selected>-Choisir Enseignant-</option>
                        <?php 
                        $enseignant = $config->getProfClasse($listClasse[$i]['id']);
                        if(empty($enseignant)){
                            echo "<option value='null'>AUCUN PROF DANS LA CLASSE</option>";
                        }else{
                            for($x=0;$x<count($enseignant);$x++){
                                echo "<option value='";
                                echo $enseignant[$x]['id_prof'];
                                echo "'>".stripslashes($enseignant[$x]['nom'])."</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
<?php      
            $a++;       
        } ?>
            <tr>
                <td colspan='5' align='center'>
                    <input type='submit' name='addpp' value='Ajouter' />
                </td>
            </tr>
        </table>
    </form>
</div>