<div id='body2'>
    <h1 class='bien'>Visualisation de la matière</h1>
    <?php 
    if(isset($_GET['id'])){
        $matiere = (int)urldecode($_GET['id']);
        $detailMatiere = $config->getMatiere($matiere);
        if(empty($matiere)){
            echo "<h3 class='alert'>Vous devez choisir une matière valide.</h3>";
        }else{ ?>
            <form method='post' action='../traitement.php'>
                <table border='0' width='75%' align='center'>
                    <tr>
                        <td>Nom de la Matière : </td>
                        <td><input
                                type='text'
                                name='nom_matiere'
                                id='nom_matiere'
                                size='50'
                                value='<?php echo $detailMatiere['nom_matiere']; ?>' />
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Code de la Matière : </td>
                        <td><input 
                                type='text'
                                name='code_matiere'
                                id='code_matiere'
                                size='25'
                                value='<?php echo $detailMatiere['code_matiere']; ?>' />
                            <input 
                                type='hidden' 
                                name='idMatiere' 
                                value='<?php echo $detailMatiere['id']; ?>' />
                        </td>
                    </tr>
                     <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><input 
                                type='submit'
                                name='upd_matiere'
                                value='Mettre a jour' />
                        </td>
                        <td><input 
                                type='submit'
                                name='upd_matiere'
                            <?php if($detailMatiere['etat']=='actif'){ echo " value='Supprimer' ";}
                            elseif($detailMatiere['etat']=='inactif'){ echo " value='ReActiver' ";} ?>
                            />
                        </td>
                    </tr>
                </table>
            </form>
        <?php 
        }
    }else{
        echo "<h3 class='alert'>Vous devez choisir une matière pour cette action.</h3>";
    }
    ?>
</div>